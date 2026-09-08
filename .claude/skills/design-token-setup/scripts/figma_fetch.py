#!/usr/bin/env python3
"""Extract design tokens (fonts, colors, text styles, section + button metrics)
from a Figma file into `figma-extract.json`.

Standard library only -- no pip install required.

Usage:
    python3 figma_fetch.py <figma-url-or-file-key> [--out figma-extract.json]

The personal access token is read from FIGMA_TOKEN (environment or .env file).
"""

import argparse
import json
import os
import re
import sys
import urllib.error
import urllib.request
from collections import Counter, defaultdict

API_ROOT = 'https://api.figma.com/v1'
DEFAULT_OUT = 'figma-extract.json'

SECTION_NAME_RE = re.compile(r'\b(section|wrapper|container)\b', re.IGNORECASE)
BUTTON_NAME_RE = re.compile(r'\b(button|btn|cta)\b', re.IGNORECASE)

# Colour words that commonly appear in button layer names. Brand names (e.g.
# "Berry") are picked up generically by _variant_from_name below.
GENERIC_COLOR_WORDS = {'black', 'white', 'dark', 'light', 'primary', 'secondary'}
OUTLINE_WORDS = {'outline', 'outlined', 'ghost', 'stroke', 'border'}
# Words in button layer names that describe shape/content, not a colour variant.
NON_VARIANT_WORDS = {
    'button', 'btn', 'cta', 'arrow', 'text', 'icon', 'link', 'label', 'small',
    'large', 'medium', 'default', 'hover', 'active', 'disabled', 'left',
    'right', 'up', 'down', 'x', 'close', 'menu',
}

DEFAULT_BUTTON_VARIANTS = ['black', 'black-outline', 'white', 'white-outline']


class FigmaError(Exception):
    """A user-facing error with a clear message."""


# --------------------------------------------------------------------------- #
# env / input helpers
# --------------------------------------------------------------------------- #

def load_dotenv(start_dir):
    """Load KEY=VALUE pairs from the nearest .env, walking up from start_dir.

    Existing environment variables always win.
    """
    directory = os.path.abspath(start_dir)
    while True:
        candidate = os.path.join(directory, '.env')
        if os.path.isfile(candidate):
            _parse_dotenv(candidate)
            return candidate
        parent = os.path.dirname(directory)
        if parent == directory:
            return None
        directory = parent


def _parse_dotenv(path):
    with open(path, 'r', encoding='utf-8') as handle:
        for raw in handle:
            line = raw.strip()
            if not line or line.startswith('#') or '=' not in line:
                continue
            key, _, value = line.partition('=')
            key = key.strip()
            value = value.strip().strip('"').strip("'")
            if key and key not in os.environ:
                os.environ[key] = value


def parse_file_key(value):
    """Accept a full Figma URL or a bare file key."""
    value = value.strip()
    match = re.search(r'figma\.com/(?:file|design|proto)/([A-Za-z0-9]+)', value)
    if match:
        return match.group(1)
    if re.fullmatch(r'[A-Za-z0-9]{10,}', value):
        return value
    raise FigmaError(
        'Could not read a Figma file key from "%s".\n'
        'Pass a file URL (https://www.figma.com/design/<key>/...) or the key itself.' % value
    )


# --------------------------------------------------------------------------- #
# API
# --------------------------------------------------------------------------- #

def api_get(path, token):
    request = urllib.request.Request(
        API_ROOT + path,
        headers={'X-Figma-Token': token, 'Accept': 'application/json'},
    )
    try:
        with urllib.request.urlopen(request, timeout=60) as response:
            return json.loads(response.read().decode('utf-8'))
    except urllib.error.HTTPError as error:
        raise FigmaError(_http_message(error, path)) from error
    except urllib.error.URLError as error:
        raise FigmaError('Could not reach the Figma API (%s).' % error.reason) from error


def _http_message(error, path):
    body = ''
    try:
        body = error.read().decode('utf-8', 'replace')[:400]
    except Exception:  # pragma: no cover - best effort only
        pass

    if error.code in (401, 403):
        return (
            'Figma rejected the request for %s (HTTP %s).\n'
            'Check that FIGMA_TOKEN is a valid personal access token with access to this file.\n'
            'Server said: %s' % (path, error.code, body)
        )
    if error.code == 404:
        return 'Figma file not found (HTTP 404) for %s. Check the URL/file key.' % path
    if error.code == 429:
        retry = error.headers.get('Retry-After') if error.headers else None
        wait = ' Retry after %s seconds.' % retry if retry else ''
        return 'Figma rate limit hit (HTTP 429).%s' % wait
    return 'Figma API error on %s (HTTP %s): %s' % (path, error.code, body)


def fetch_variables(file_key, token):
    """Return the local-variables payload, or None when unavailable.

    The Variables REST API is Enterprise-only; a 403 here is normal and simply
    means we fall back to walking the document.
    """
    try:
        payload = api_get('/files/%s/variables/local' % file_key, token)
    except FigmaError as error:
        message = str(error)
        if 'HTTP 403' in message or 'HTTP 404' in message:
            return None
        raise
    meta = payload.get('meta') or {}
    if not meta.get('variables'):
        return None
    return meta


# --------------------------------------------------------------------------- #
# colour helpers
# --------------------------------------------------------------------------- #

def rgba_to_hex(color):
    def channel(value):
        return max(0, min(255, int(round(float(value) * 255))))

    return '#%02X%02X%02X' % (
        channel(color.get('r', 0)),
        channel(color.get('g', 0)),
        channel(color.get('b', 0)),
    )


def num(value):
    """Round to 2dp, returning an int when the result is whole (48.0 -> 48)."""
    rounded = round(float(value), 2)
    return int(rounded) if rounded == int(rounded) else rounded


def slugify(value):
    slug = re.sub(r'[^a-z0-9]+', '-', str(value).lower()).strip('-')
    return slug or 'color'


def variable_name_for(name, taken):
    """Turn "Primary/Black" into a unique "ds-black" style variable name.

    On a collision, fall back to the full path ("ds-accent-black") before
    resorting to a numeric suffix.
    """
    parts = [part for part in str(name).split('/') if part.strip()]
    leaf = parts[-1] if parts else str(name)
    options = ['ds-' + slugify(leaf)]
    if len(parts) > 1:
        options.append('ds-' + slugify('-'.join(parts)))

    for candidate in options:
        if candidate not in taken:
            taken.add(candidate)
            return candidate

    base = options[-1]
    index = 2
    while '%s-%d' % (base, index) in taken:
        index += 1
    candidate = '%s-%d' % (base, index)
    taken.add(candidate)
    return candidate


# --------------------------------------------------------------------------- #
# document walking
# --------------------------------------------------------------------------- #

def walk(node, parent=None, depth=0):
    """Yield (node, parent, depth) for every node in the document."""
    yield node, parent, depth
    for child in node.get('children') or []:
        for item in walk(child, node, depth + 1):
            yield item


def collect(document):
    """Single pass over the tree gathering everything downstream steps need."""
    text_nodes = []
    fills = Counter()
    fill_names = {}
    frames = []
    buttons = []

    for node, parent, depth in walk(document):
        node_type = node.get('type')

        for color in iter_solid_fills(node):
            fills[rgba_to_hex(color)] += 1

        style_id_map = node.get('styles') or {}
        if 'fill' in style_id_map or 'fills' in style_id_map:
            style_id = style_id_map.get('fill') or style_id_map.get('fills')
            solids = list(iter_solid_fills(node))
            if solids:
                fill_names.setdefault(style_id, rgba_to_hex(solids[0]))

        if node_type == 'TEXT':
            style = node.get('style') or {}
            if style.get('fontSize'):
                text_nodes.append({
                    'name': node.get('name', ''),
                    'depth': depth,
                    'y': ((node.get('absoluteBoundingBox') or {}) or {}).get('y'),
                    'fontFamily': style.get('fontFamily'),
                    'fontSize': num(style['fontSize']),
                    'fontWeight': int(style.get('fontWeight') or 400),
                    'lineHeight': line_height_ratio(style),
                    'styleId': style_id_map.get('text'),
                    'characters': (node.get('characters') or '')[:60],
                })

        if node_type in ('FRAME', 'COMPONENT', 'COMPONENT_SET', 'INSTANCE', 'GROUP'):
            name = node.get('name') or ''
            box = node.get('absoluteBoundingBox') or {}
            frames.append({
                'name': name,
                'depth': depth,
                'width': box.get('width'),
                'paddingLeft': node.get('paddingLeft'),
                'paddingRight': node.get('paddingRight'),
                'paddingTop': node.get('paddingTop'),
                'paddingBottom': node.get('paddingBottom'),
                'isSectionish': bool(SECTION_NAME_RE.search(name)),
            })
            if BUTTON_NAME_RE.search(name) and node_type != 'COMPONENT_SET':
                buttons.append({
                    'name': name,
                    'node': node,
                    'paddingLeft': node.get('paddingLeft'),
                    'paddingRight': node.get('paddingRight'),
                    'paddingTop': node.get('paddingTop'),
                    'paddingBottom': node.get('paddingBottom'),
                    'cornerRadius': node.get('cornerRadius'),
                })

    return {
        'textNodes': text_nodes,
        'fills': fills,
        'fillStyleColors': fill_names,
        'frames': frames,
        'buttons': buttons,
    }


def iter_solid_fills(node):
    for fill in node.get('fills') or []:
        if fill.get('type') != 'SOLID' or fill.get('visible') is False:
            continue
        color = fill.get('color')
        if color:
            yield color


def line_height_ratio(style):
    size = style.get('fontSize')
    px = style.get('lineHeightPx')
    if size and px:
        return str(round(float(px) / float(size), 2))
    percent = style.get('lineHeightPercentFontSize')
    if percent:
        return str(round(float(percent) / 100.0, 2))
    return 'normal'


# --------------------------------------------------------------------------- #
# token building
# --------------------------------------------------------------------------- #

def colors_from_variables(meta):
    collections = meta.get('variableCollections') or {}
    taken = set()
    colors = []
    ordered = sorted(
        (meta.get('variables') or {}).values(),
        key=lambda variable: str(variable.get('name') or '').lower(),
    )
    for variable in ordered:
        if variable.get('resolvedType') != 'COLOR' or variable.get('remote'):
            continue
        values = variable.get('valuesByMode') or {}
        collection = collections.get(variable.get('variableCollectionId')) or {}
        default_mode = collection.get('defaultModeId')
        value = values.get(default_mode) if default_mode in values else next(iter(values.values()), None)
        if not isinstance(value, dict) or 'r' not in value:
            continue  # alias to another variable -- skip, the target is listed separately
        name = variable.get('name') or 'color'
        colors.append({
            'name': name,
            'hex': rgba_to_hex(value),
            'variableName': variable_name_for(name, taken),
        })
    return colors


def colors_from_nodes(collected, file_styles):
    """Fallback: dedupe every solid fill, naming the ones backed by a style."""
    style_names = {}
    for style_id, hex_value in collected['fillStyleColors'].items():
        style = file_styles.get(style_id) or {}
        if style.get('name'):
            style_names[hex_value] = style['name']

    taken = set()
    colors = []
    for hex_value, count in collected['fills'].most_common():
        name = style_names.get(hex_value, hex_value)
        colors.append({
            'name': name,
            'hex': hex_value,
            'variableName': variable_name_for(name, taken),
            'usageCount': count,
        })
    return colors


def build_text_styles(text_nodes):
    if not text_nodes:
        return {}

    def as_style(node):
        return {
            'fontFamily': node['fontFamily'],
            'fontSize': node['fontSize'],
            'fontWeight': node['fontWeight'],
            'lineHeight': node['lineHeight'],
        }

    by_size = sorted(text_nodes, key=lambda node: node['fontSize'], reverse=True)
    heading = by_size[0]

    # Subheading: the largest size below the heading's, preferring nodes that sit
    # near a heading-sized node in the layout.
    smaller = [node for node in by_size if node['fontSize'] < heading['fontSize']]
    subheading = smaller[0] if smaller else None
    if smaller:
        heading_y = heading.get('y')
        if heading_y is not None:
            near = [
                node for node in smaller
                if node.get('y') is not None and abs(node['y'] - heading_y) < 400
            ]
            if near:
                subheading = max(near, key=lambda node: node['fontSize'])

    # Body: the most frequent family/size/weight combination.
    combos = Counter(
        (node['fontFamily'], node['fontSize'], node['fontWeight'], node['lineHeight'])
        for node in text_nodes
    )
    family, size, weight, line_height = combos.most_common(1)[0][0]
    body = {
        'fontFamily': family,
        'fontSize': size,
        'fontWeight': weight,
        'lineHeight': line_height,
    }

    styles = {'heading': as_style(heading), 'body': body}
    if subheading:
        styles['subheading'] = as_style(subheading)
    return {key: styles[key] for key in ('heading', 'subheading', 'body') if key in styles}


def build_fonts(text_nodes, variables_meta, text_styles):
    """Collect families with the weights actually used, tagged by role."""
    weights = defaultdict(set)
    for node in text_nodes:
        if node['fontFamily']:
            weights[node['fontFamily']].add(node['fontWeight'])

    if variables_meta:
        for variable in (variables_meta.get('variables') or {}).values():
            if variable.get('resolvedType') != 'STRING':
                continue
            if 'font' not in (variable.get('name') or '').lower():
                continue
            for value in (variable.get('valuesByMode') or {}).values():
                if isinstance(value, str) and value and value not in weights:
                    weights[value] = weights.get(value, set())

    usage = {}
    for role in ('heading', 'subheading', 'body'):
        family = (text_styles.get(role) or {}).get('fontFamily')
        if family and family not in usage:
            usage[family] = role

    fonts = []
    for family, used_weights in weights.items():
        fonts.append({
            'family': family,
            'weights': sorted(used_weights) or [400],
            'usage': usage.get(family, 'other'),
        })
    fonts.sort(key=lambda font: (font['usage'] == 'other', font['family'].lower()))
    return fonts


def build_section(frames):
    candidates = [frame for frame in frames if frame['isSectionish']]
    if not candidates:
        top_level = [frame for frame in frames if frame['depth'] <= 2 and frame['width']]
        candidates = top_level[:10]

    widths = [frame['width'] for frame in candidates if frame['width']]
    max_width = int(round(max(widths))) if widths else None

    def spread(keys):
        values = sorted({
            int(round(frame[key]))
            for frame in candidates
            for key in keys
            if frame.get(key)
        })
        return values

    x_values = spread(('paddingLeft', 'paddingRight'))
    y_values = spread(('paddingTop', 'paddingBottom'))

    section = {'maxWidth': max_width}
    if x_values:
        section['paddingX'] = {'lg': x_values[-1], 'sm': x_values[0]}
    if y_values:
        section['paddingY'] = {'lg': y_values[-1], 'sm': y_values[0]}
    section['candidateCount'] = len(candidates)
    return section


def _variant_from_name(name, color_words):
    """Derive a colour variant slug from a Figma layer name.

    "Button-Berry-Arrow-Outline" -> "berry-outline"; "Button-Black-Text-Arrow"
    -> "black". Only words that are known colours (generic ones, or a word from
    the file's own palette) count, so a label like "Button-Kontakt-speichern"
    yields None rather than a bogus "kontakt" variant.
    """
    words = [word.lower() for word in re.split(r'[\W_]+', name, flags=re.UNICODE) if word]
    outline = any(word in OUTLINE_WORDS for word in words)
    known = GENERIC_COLOR_WORDS | set(color_words or ())
    color = next((word for word in words if word in known), None)
    if not color:
        return 'outline' if outline else None
    return '%s-outline' % color if outline else color


def color_words_from(colors):
    """Words usable as button variant names, taken from the extracted palette."""
    words = set()
    for color in colors:
        for word in re.split(r'[\W_]+', str(color.get('name') or ''), flags=re.UNICODE):
            word = word.lower()
            if len(word) > 2 and word not in NON_VARIANT_WORDS and not word.isdigit():
                words.add(word)
    return words


def build_button(buttons, color_words=None):
    matched = set()
    for button in buttons:
        variant = _variant_from_name(button['name'], color_words)
        if variant:
            matched.add(variant)

    # Keep the conventional order for the generic names, then any brand colours.
    variants = [label for label in DEFAULT_BUTTON_VARIANTS if label in matched]
    variants += sorted(matched.difference(variants))

    result = {'colorVariants': variants or DEFAULT_BUTTON_VARIANTS}
    if not variants:
        result['colorVariantsSource'] = 'default (no variant names matched in Figma)'

    if not buttons:
        result['note'] = 'No node named button/btn/cta found -- values need filling in manually.'
        return result

    def common(key):
        values = [button[key] for button in buttons if button.get(key)]
        if not values:
            return None
        return int(round(Counter(values).most_common(1)[0][0]))

    padding_x = common('paddingLeft') or common('paddingRight')
    padding_y = common('paddingTop') or common('paddingBottom')
    radius = common('cornerRadius')

    font_sizes = []
    for button in buttons:
        for node, _parent, _depth in walk(button['node']):
            if node.get('type') == 'TEXT' and (node.get('style') or {}).get('fontSize'):
                font_sizes.append(num(node['style']['fontSize']))
    font_size = Counter(font_sizes).most_common(1)[0][0] if font_sizes else None

    for key, value in (
        ('fontSize', font_size),
        ('paddingX', padding_x),
        ('paddingY', padding_y),
        ('borderRadius', radius),
    ):
        if value is not None:
            result[key] = value

    result['matchedNodes'] = len(buttons)
    return result


# --------------------------------------------------------------------------- #
# main
# --------------------------------------------------------------------------- #

def main(argv=None):
    parser = argparse.ArgumentParser(description='Extract design tokens from a Figma file.')
    parser.add_argument('file', help='Figma file URL or file key')
    parser.add_argument('--out', default=DEFAULT_OUT, help='Output path (default: %s)' % DEFAULT_OUT)
    parser.add_argument('--token', help='Figma token (defaults to FIGMA_TOKEN)')
    parser.add_argument(
        '--no-variables',
        action='store_true',
        help='Skip the Variables API and always walk the document tree',
    )
    args = parser.parse_args(argv)

    load_dotenv(os.getcwd())
    token = args.token or os.environ.get('FIGMA_TOKEN')
    if not token:
        raise FigmaError(
            'No Figma token. Set FIGMA_TOKEN in .env (see .env.example) or pass --token.\n'
            'Create one at https://www.figma.com/developers/api#access-tokens'
        )

    file_key = parse_file_key(args.file)
    payload = api_get('/files/%s' % file_key, token)
    document = payload.get('document') or {}
    file_styles = payload.get('styles') or {}

    collected = collect(document)

    variables_meta = None if args.no_variables else fetch_variables(file_key, token)
    if variables_meta:
        colors = colors_from_variables(variables_meta)
        source = 'variables'
    else:
        colors = []
        source = 'node-walk'
    if not colors:
        colors = colors_from_nodes(collected, file_styles)
        source = 'node-walk'

    text_styles = build_text_styles(collected['textNodes'])
    fonts = build_fonts(collected['textNodes'], variables_meta, text_styles)

    result = {
        'source': {
            'fileKey': file_key,
            'fileName': payload.get('name'),
            'lastModified': payload.get('lastModified'),
            'extraction': source,
        },
        'fonts': fonts,
        'colors': colors,
        'textStyles': text_styles,
        'section': build_section(collected['frames']),
        'button': build_button(collected['buttons'], color_words_from(colors)),
    }

    out_path = os.path.abspath(args.out)
    with open(out_path, 'w', encoding='utf-8') as handle:
        json.dump(result, handle, indent=2, ensure_ascii=False)
        handle.write('\n')

    print_summary(result, out_path)
    return 0


def print_summary(result, out_path):
    source = result['source']
    print('Figma extract written to %s' % out_path)
    print('  File:        %s (%s)' % (source.get('fileName'), source.get('fileKey')))
    print('  Extraction:  %s' % (
        'Variables API' if source['extraction'] == 'variables' else 'document node walk (no local variables)'
    ))
    fonts = result['fonts']
    if fonts:
        print('  Fonts:       %d' % len(fonts))
        for font in fonts:
            print('    - %s [%s] weights: %s' % (
                font['family'], font['usage'], ', '.join(str(weight) for weight in font['weights'])
            ))
    else:
        print('  Fonts:       none found')
    print('  Colors:      %d' % len(result['colors']))
    styles = result['textStyles']
    for role in ('heading', 'subheading', 'body'):
        style = styles.get(role)
        if style:
            print('  %-11s %spx / %s / lh %s (%s)' % (
                role + ':', style['fontSize'], style['fontWeight'],
                style['lineHeight'], style['fontFamily']
            ))
    section = result['section']
    print('  Section:     max-width %s, paddingX %s, paddingY %s' % (
        section.get('maxWidth'), section.get('paddingX'), section.get('paddingY')
    ))
    button = result['button']
    print('  Button:      variants %s' % ', '.join(button['colorVariants']))
    if button.get('note'):
        print('               %s' % button['note'])
    print('\nReview the JSON before writing any CSS -- picked nodes are heuristics.')


if __name__ == '__main__':
    try:
        sys.exit(main())
    except FigmaError as error:
        print('Error: %s' % error, file=sys.stderr)
        sys.exit(1)
    except KeyboardInterrupt:
        sys.exit(130)
