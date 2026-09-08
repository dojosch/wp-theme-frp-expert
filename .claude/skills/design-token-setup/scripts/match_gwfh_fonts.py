#!/usr/bin/env python3
"""Check each font in `figma-extract.json` against Google Fonts and record the
matching google-webfonts-helper URL.

Standard library only -- no pip install required.

Usage:
    python3 match_gwfh_fonts.py [--extract figma-extract.json]

Set GOOGLE_FONTS_API_KEY (environment or .env) for an authoritative lookup.
Without a key the script falls back to the bundled list below, which covers the
commonly used families but is not exhaustive.
"""

import argparse
import json
import os
import re
import sys
import urllib.error
import urllib.parse
import urllib.request

WEBFONTS_API = 'https://www.googleapis.com/webfonts/v1/webfonts'
GWFH_URL = 'https://gwfh.mranftl.com/fonts/{slug}?subsets=latin'
DEFAULT_EXTRACT = 'figma-extract.json'

# Fallback used when GOOGLE_FONTS_API_KEY is unset: family -> category.
BUNDLED_GOOGLE_FONTS = {
    'Abril Fatface': 'display', 'Alegreya': 'serif', 'Alegreya Sans': 'sans-serif',
    'Anton': 'sans-serif', 'Archivo': 'sans-serif', 'Archivo Black': 'sans-serif',
    'Arimo': 'sans-serif', 'Arvo': 'serif', 'Asap': 'sans-serif', 'Assistant': 'sans-serif',
    'Barlow': 'sans-serif', 'Barlow Condensed': 'sans-serif', 'Bebas Neue': 'display',
    'Bitter': 'serif', 'Cabin': 'sans-serif', 'Cairo': 'sans-serif', 'Cardo': 'serif',
    'Catamaran': 'sans-serif', 'Caveat': 'handwriting', 'Chivo': 'sans-serif',
    'Cormorant': 'serif', 'Cormorant Garamond': 'serif', 'Crimson Pro': 'serif',
    'Crimson Text': 'serif', 'DM Mono': 'monospace', 'DM Sans': 'sans-serif',
    'DM Serif Display': 'serif', 'DM Serif Text': 'serif', 'Dosis': 'sans-serif',
    'EB Garamond': 'serif', 'Exo': 'sans-serif', 'Exo 2': 'sans-serif',
    'Figtree': 'sans-serif', 'Fira Code': 'monospace', 'Fira Sans': 'sans-serif',
    'Fjalla One': 'sans-serif', 'Frank Ruhl Libre': 'serif', 'Fraunces': 'serif',
    'Geist': 'sans-serif', 'Geist Mono': 'monospace', 'Hanken Grotesk': 'sans-serif',
    'Heebo': 'sans-serif', 'Hind': 'sans-serif', 'IBM Plex Mono': 'monospace',
    'IBM Plex Sans': 'sans-serif', 'IBM Plex Serif': 'serif', 'Inconsolata': 'monospace',
    'Instrument Sans': 'sans-serif', 'Instrument Serif': 'serif', 'Inter': 'sans-serif',
    'Inter Tight': 'sans-serif', 'JetBrains Mono': 'monospace', 'Josefin Sans': 'sans-serif',
    'Jost': 'sans-serif', 'Kanit': 'sans-serif', 'Karla': 'sans-serif', 'Lato': 'sans-serif',
    'League Spartan': 'sans-serif', 'Libre Baskerville': 'serif',
    'Libre Franklin': 'sans-serif', 'Lora': 'serif', 'Manrope': 'sans-serif',
    'Marcellus': 'serif', 'Merriweather': 'serif', 'Merriweather Sans': 'sans-serif',
    'Montserrat': 'sans-serif', 'Mulish': 'sans-serif', 'Newsreader': 'serif',
    'Noto Sans': 'sans-serif', 'Noto Serif': 'serif', 'Nunito': 'sans-serif',
    'Nunito Sans': 'sans-serif', 'Old Standard TT': 'serif', 'Onest': 'sans-serif',
    'Open Sans': 'sans-serif', 'Oswald': 'sans-serif', 'Outfit': 'sans-serif',
    'Overpass': 'sans-serif', 'Oxygen': 'sans-serif', 'PT Sans': 'sans-serif',
    'PT Serif': 'serif', 'Playfair Display': 'serif', 'Plus Jakarta Sans': 'sans-serif',
    'Poppins': 'sans-serif', 'Prata': 'serif', 'Public Sans': 'sans-serif',
    'Quicksand': 'sans-serif', 'Raleway': 'sans-serif', 'Red Hat Display': 'sans-serif',
    'Roboto': 'sans-serif', 'Roboto Condensed': 'sans-serif', 'Roboto Mono': 'monospace',
    'Roboto Slab': 'serif', 'Rubik': 'sans-serif', 'Sora': 'sans-serif',
    'Source Code Pro': 'monospace', 'Source Sans 3': 'sans-serif',
    'Source Serif 4': 'serif', 'Space Grotesk': 'sans-serif', 'Space Mono': 'monospace',
    'Spectral': 'serif', 'Syne': 'sans-serif', 'Titillium Web': 'sans-serif',
    'Ubuntu': 'sans-serif', 'Unbounded': 'display', 'Urbanist': 'sans-serif',
    'Work Sans': 'sans-serif', 'Zilla Slab': 'serif',
}


class MatchError(Exception):
    """A user-facing error with a clear message."""


def load_dotenv(start_dir):
    directory = os.path.abspath(start_dir)
    while True:
        candidate = os.path.join(directory, '.env')
        if os.path.isfile(candidate):
            with open(candidate, 'r', encoding='utf-8') as handle:
                for raw in handle:
                    line = raw.strip()
                    if not line or line.startswith('#') or '=' not in line:
                        continue
                    key, _, value = line.partition('=')
                    key = key.strip()
                    value = value.strip().strip('"').strip("'")
                    if key and key not in os.environ:
                        os.environ[key] = value
            return candidate
        parent = os.path.dirname(directory)
        if parent == directory:
            return None
        directory = parent


def gwfh_slug(family):
    """Google Webfonts Helper slug: lowercase, spaces -> dashes."""
    slug = str(family).strip().lower().replace(' ', '-')
    return re.sub(r'[^a-z0-9-]', '', slug)


def fetch_google_catalog(api_key):
    """Return {lowercased family: category} from the Google Fonts API."""
    url = '%s?%s' % (WEBFONTS_API, urllib.parse.urlencode({'key': api_key, 'sort': 'alpha'}))
    try:
        with urllib.request.urlopen(url, timeout=60) as response:
            payload = json.loads(response.read().decode('utf-8'))
    except urllib.error.HTTPError as error:
        detail = ''
        try:
            detail = error.read().decode('utf-8', 'replace')[:300]
        except Exception:  # pragma: no cover - best effort only
            pass
        if error.code in (400, 403):
            raise MatchError(
                'Google Fonts API rejected the key (HTTP %s). Check GOOGLE_FONTS_API_KEY, '
                'or unset it to use the bundled list.\n%s' % (error.code, detail)
            ) from error
        if error.code == 429:
            raise MatchError('Google Fonts API rate limit hit (HTTP 429). Try again later.') from error
        raise MatchError('Google Fonts API error (HTTP %s): %s' % (error.code, detail)) from error
    except urllib.error.URLError as error:
        raise MatchError('Could not reach the Google Fonts API (%s).' % error.reason) from error

    return {
        item['family'].lower(): item.get('category', 'sans-serif')
        for item in payload.get('items', [])
        if item.get('family')
    }


def main(argv=None):
    parser = argparse.ArgumentParser(
        description='Flag which fonts in figma-extract.json are available on Google Webfonts Helper.'
    )
    parser.add_argument('--extract', default=DEFAULT_EXTRACT,
                        help='Path to figma-extract.json (default: %s)' % DEFAULT_EXTRACT)
    args = parser.parse_args(argv)

    load_dotenv(os.getcwd())

    path = os.path.abspath(args.extract)
    if not os.path.isfile(path):
        raise MatchError('No extract file at %s. Run figma_fetch.py first.' % path)

    with open(path, 'r', encoding='utf-8') as handle:
        try:
            data = json.load(handle)
        except json.JSONDecodeError as error:
            raise MatchError('%s is not valid JSON (%s).' % (path, error)) from error

    fonts = data.get('fonts')
    if not isinstance(fonts, list) or not fonts:
        raise MatchError('No "fonts" array in %s -- nothing to match.' % path)

    api_key = os.environ.get('GOOGLE_FONTS_API_KEY')
    if api_key:
        catalog = fetch_google_catalog(api_key)
        lookup_source = 'Google Fonts API (%d families)' % len(catalog)
    else:
        catalog = {family.lower(): category for family, category in BUNDLED_GOOGLE_FONTS.items()}
        lookup_source = 'bundled list (%d families, no GOOGLE_FONTS_API_KEY set)' % len(catalog)

    matched, manual = [], []
    for font in fonts:
        family = font.get('family')
        if not family:
            continue
        category = catalog.get(str(family).strip().lower())
        if category:
            font['gwfhAvailable'] = True
            font['gwfhSlug'] = gwfh_slug(family)
            font['gwfhUrl'] = GWFH_URL.format(slug=font['gwfhSlug'])
            font['category'] = category
            matched.append(font)
        else:
            font['gwfhAvailable'] = False
            font['gwfhSlug'] = None
            font['note'] = 'manual -- not on Google Webfont Helper, add fallback only.'
            manual.append(font)

    with open(path, 'w', encoding='utf-8') as handle:
        json.dump(data, handle, indent=2, ensure_ascii=False)
        handle.write('\n')

    print('Matched fonts against %s' % lookup_source)
    print('Updated %s\n' % path)
    if matched:
        print('Google Fonts (download the weights listed, place in theme/assets/fonts/<slug>/):')
        for font in matched:
            print('  %s [%s] weights %s' % (
                font['family'], font['category'],
                ', '.join(str(weight) for weight in font.get('weights') or []),
            ))
            print('    %s' % font['gwfhUrl'])
    if manual:
        print('\nNot on Google Webfont Helper -- manual, add fallback only:')
        for font in manual:
            print('  %s' % font['family'])
    if not api_key and manual:
        print('\nNote: matched against the bundled list. Set GOOGLE_FONTS_API_KEY for an '
              'authoritative check before treating a font as unavailable.')
    return 0


if __name__ == '__main__':
    try:
        sys.exit(main())
    except MatchError as error:
        print('Error: %s' % error, file=sys.stderr)
        sys.exit(1)
    except KeyboardInterrupt:
        sys.exit(130)
