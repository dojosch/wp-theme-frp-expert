#!/usr/bin/env python3
"""Convert Figma Dev Mode MCP `get_variable_defs` output into `figma-extract.json`.

This is the preferred extraction path: the MCP returns named variables and text
styles directly, so nothing has to be inferred from the node tree.

Standard library only.

Usage:
    python3 mcp_tokens_to_extract.py --input variable-defs.json
    pbpaste | python3 mcp_tokens_to_extract.py            # read from stdin

`--extra` merges a JSON fragment over the result, for the `section` and `button`
values that variable defs cannot supply (derive those from get_design_context /
get_metadata on a section frame and a button component):

    python3 mcp_tokens_to_extract.py -i defs.json --extra '{"section": {...}}'
"""

import argparse
import json
import os
import re
import sys

DEFAULT_OUT = 'figma-extract.json'

# "Font(family: "Inter", style: Light, size: 45, weight: 300, lineHeight: 56, letterSpacing: 0)"
FONT_RE = re.compile(r'^Font\((.*)\)$', re.S)
HEX_RE = re.compile(r'^#(?:[0-9a-fA-F]{3,4}|[0-9a-fA-F]{6}|[0-9a-fA-F]{8})$')

BODY_NAME_RE = re.compile(r'\b(body|paragraph|copy|text|fliess|fließ)\b', re.IGNORECASE)

# lineHeight is px when close to the font size, but Figma also reports it as a
# percentage (e.g. 100 meaning 100%). Anything this many times the font size is
# treated as a percentage.
PERCENT_RATIO_THRESHOLD = 3.0


class ConvertError(Exception):
    """A user-facing error with a clear message."""


def parse_font(value):
    """Parse a Font(...) descriptor into a dict, or return None."""
    match = FONT_RE.match(str(value).strip())
    if not match:
        return None

    fields = {}
    for key, raw in re.findall(r'(\w+)\s*:\s*("(?:[^"\\]|\\.)*"|[^,]+)', match.group(1)):
        raw = raw.strip()
        if raw.startswith('"') and raw.endswith('"'):
            fields[key] = raw[1:-1]
        else:
            try:
                fields[key] = float(raw) if '.' in raw else int(raw)
            except ValueError:
                fields[key] = raw
    if 'family' not in fields:
        return None
    return fields


def num(value):
    rounded = round(float(value), 2)
    return int(rounded) if rounded == int(rounded) else rounded


def line_height_ratio(fields):
    size = fields.get('size')
    raw = fields.get('lineHeight')
    if not size or not raw or not isinstance(raw, (int, float)):
        return 'normal'
    ratio = float(raw) / float(size)
    if ratio > PERCENT_RATIO_THRESHOLD:
        # Reported as a percentage (lineHeight: 100 == 100%).
        ratio = float(raw) / 100.0
    return str(round(ratio, 2))


def weight_from(fields):
    weight = fields.get('weight')
    if isinstance(weight, (int, float)):
        return int(weight)
    style = str(fields.get('style') or '').lower()
    named = {
        'thin': 100, 'extralight': 200, 'ultralight': 200, 'light': 300,
        'regular': 400, 'normal': 400, 'medium': 500, 'semibold': 600,
        'demibold': 600, 'bold': 700, 'extrabold': 800, 'black': 900,
    }
    for name, value in named.items():
        if name in style.replace(' ', ''):
            return value
    return 400


def slugify(value):
    slug = re.sub(r'[^a-z0-9]+', '-', str(value).lower()).strip('-')
    return slug or 'color'


def common_prefix_words(names):
    """Find a brand prefix shared by every colour name (e.g. "imark ")."""
    if len(names) < 2:
        return []
    word_lists = [name.split() for name in names]
    prefix = []
    for index in range(min(len(words) for words in word_lists)):
        candidate = word_lists[0][index]
        if all(words[index].lower() == candidate.lower() for words in word_lists):
            prefix.append(candidate)
        else:
            break
    # Never strip the whole name away.
    if any(len(words) <= len(prefix) for words in word_lists):
        return prefix[:-1]
    return prefix


def variable_name_for(name, taken):
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


def build(defs):
    colors_raw, styles_raw = {}, {}
    for name, value in defs.items():
        if isinstance(value, str) and HEX_RE.match(value.strip()):
            colors_raw[name] = value.strip().lower()
            continue
        fields = parse_font(value) if isinstance(value, str) else None
        if fields:
            styles_raw[name] = fields

    # --- colours -------------------------------------------------------- #
    prefix = common_prefix_words(list(colors_raw))
    taken = set()
    colors = []
    for name in sorted(colors_raw, key=str.lower):
        display = ' '.join(name.split()[len(prefix):]) if prefix else name
        entry = {
            'name': name,
            'hex': colors_raw[name].upper() if len(colors_raw[name]) <= 7
                   else colors_raw[name][:7].upper() + colors_raw[name][7:],
            'variableName': variable_name_for(display or name, taken),
        }
        if len(colors_raw[name]) in (5, 9):
            entry['hasAlpha'] = True
        colors.append(entry)

    # --- text styles ----------------------------------------------------- #
    def as_style(name, fields):
        return {
            'figmaStyle': name,
            'fontFamily': fields['family'],
            'fontSize': num(fields.get('size') or 16),
            'fontWeight': weight_from(fields),
            'lineHeight': line_height_ratio(fields),
        }

    sized = sorted(
        ((name, fields) for name, fields in styles_raw.items() if fields.get('size')),
        key=lambda item: float(item[1]['size']),
        reverse=True,
    )

    text_styles = {}
    body_entry = next(
        ((name, fields) for name, fields in sized if BODY_NAME_RE.search(name)),
        None,
    )
    # Heading/subheading come from size, not name: a file can have an "H1 | SEO"
    # style that is deliberately small.
    ranked = [item for item in sized if body_entry is None or item[0] != body_entry[0]]
    if ranked:
        text_styles['heading'] = as_style(*ranked[0])
    if len(ranked) > 1:
        text_styles['subheading'] = as_style(*ranked[1])
    if body_entry:
        text_styles['body'] = as_style(*body_entry)
    elif sized:
        text_styles['body'] = as_style(*sized[-1])

    # --- fonts ------------------------------------------------------------ #
    usage = {}
    for role in ('heading', 'subheading', 'body'):
        family = (text_styles.get(role) or {}).get('fontFamily')
        if family and family not in usage:
            usage[family] = role

    weights = {}
    for fields in styles_raw.values():
        weights.setdefault(fields['family'], set()).add(weight_from(fields))

    fonts = [
        {
            'family': family,
            'weights': sorted(used),
            'usage': usage.get(family, 'other'),
        }
        for family, used in sorted(weights.items(), key=lambda item: item[0].lower())
    ]

    return {
        'source': {'extraction': 'figma-mcp:get_variable_defs'},
        'fonts': fonts,
        'colors': colors,
        'textStyles': text_styles,
        'allTextStyles': {name: as_style(name, fields) for name, fields in sized},
        'section': {
            '_needsReview': 'Not available from variable defs -- fill from '
                            'get_design_context/get_metadata on a section frame.',
        },
        'button': {
            '_needsReview': 'Not available from variable defs -- fill from '
                            'get_design_context on a button component.',
        },
    }


def deep_merge(base, override):
    for key, value in override.items():
        if isinstance(value, dict) and isinstance(base.get(key), dict):
            deep_merge(base[key], value)
        else:
            base[key] = value
    return base


def load_extra(value):
    if not value:
        return None
    if os.path.isfile(value):
        with open(value, 'r', encoding='utf-8') as handle:
            return json.load(handle)
    return json.loads(value)


def main(argv=None):
    parser = argparse.ArgumentParser(
        description='Convert Figma MCP get_variable_defs output into figma-extract.json.'
    )
    parser.add_argument('-i', '--input', help='JSON file of variable defs (default: stdin)')
    parser.add_argument('-o', '--out', default=DEFAULT_OUT, help='Output path (default: %s)' % DEFAULT_OUT)
    parser.add_argument('--extra', help='JSON file or literal merged over the result')
    args = parser.parse_args(argv)

    raw = None
    if args.input:
        if not os.path.isfile(args.input):
            raise ConvertError('No such input file: %s' % args.input)
        with open(args.input, 'r', encoding='utf-8') as handle:
            raw = handle.read()
    else:
        if sys.stdin.isatty():
            raise ConvertError('No input. Pass --input <file> or pipe JSON on stdin.')
        raw = sys.stdin.read()

    try:
        defs = json.loads(raw)
    except json.JSONDecodeError as error:
        raise ConvertError('Input is not valid JSON (%s).' % error) from error
    if not isinstance(defs, dict):
        raise ConvertError('Expected a JSON object of {name: value} variable defs.')

    result = build(defs)

    try:
        extra = load_extra(args.extra)
    except (json.JSONDecodeError, OSError) as error:
        raise ConvertError('--extra is not valid JSON (%s).' % error) from error
    if extra:
        deep_merge(result, extra)
        # A merged-in value answers the placeholder, so drop it.
        for key in ('section', 'button'):
            block = result.get(key)
            if isinstance(block, dict) and any(
                not name.startswith('_') for name in block
            ):
                block.pop('_needsReview', None)

    out_path = os.path.abspath(args.out)
    with open(out_path, 'w', encoding='utf-8') as handle:
        json.dump(result, handle, indent=2, ensure_ascii=False)
        handle.write('\n')

    print('Wrote %s' % out_path)
    print('  Colors:      %d' % len(result['colors']))
    for color in result['colors']:
        print('    %-28s %-9s -> --color-%s' % (color['name'], color['hex'], color['variableName']))
    print('  Fonts:       %s' % ', '.join(
        '%s [%s] %s' % (font['family'], font['usage'],
                        '/'.join(str(weight) for weight in font['weights']))
        for font in result['fonts']
    ) or 'none')
    for role in ('heading', 'subheading', 'body'):
        style = result['textStyles'].get(role)
        if style:
            print('  %-11s %s %spx / %s / lh %s' % (
                role + ':', style['figmaStyle'], style['fontSize'],
                style['fontWeight'], style['lineHeight']))
    pending = [
        key for key in ('section', 'button')
        if '_needsReview' in (result.get(key) or {})
    ]
    if pending:
        print('\n%s still %s values -- see _needsReview in the JSON.' % (
            ' and '.join(pending), 'need' if len(pending) > 1 else 'needs'))
    return 0


if __name__ == '__main__':
    try:
        sys.exit(main())
    except ConvertError as error:
        print('Error: %s' % error, file=sys.stderr)
        sys.exit(1)
    except KeyboardInterrupt:
        sys.exit(130)
