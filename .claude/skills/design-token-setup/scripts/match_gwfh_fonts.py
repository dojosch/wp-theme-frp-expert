#!/usr/bin/env python3
"""Check each font in `figma-extract.json` against a bundled list of Google
Fonts and record the matching google-webfonts-helper URL.

Standard library only, and fully offline -- no API key, no network, no .env.

Usage:
    python3 match_gwfh_fonts.py [--extract figma-extract.json]

The bundled list is not exhaustive. A family it does not know is reported as
unverified, not as unavailable: the candidate gwfh URL is still written out so
it can be checked by opening it.
"""

import argparse
import json
import os
import re
import sys
import unicodedata

GWFH_URL = 'https://gwfh.mranftl.com/fonts/{slug}?subsets=latin'
DEFAULT_EXTRACT = 'figma-extract.json'

# Known Google Fonts: family -> category. Extend as needed.
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


def _ascii_fold(value):
    """Fold accents to ASCII so slugs keep their letters: Söhne -> sohne."""
    text = str(value)
    for source, target in (('ß', 'ss'), ('æ', 'ae'), ('œ', 'oe'), ('ø', 'o'), ('đ', 'd'), ('ł', 'l')):
        text = text.replace(source, target).replace(source.upper(), target.upper())
    decomposed = unicodedata.normalize('NFKD', text)
    return ''.join(ch for ch in decomposed if not unicodedata.combining(ch))


def gwfh_slug(family):
    """Google Webfonts Helper slug: lowercase, spaces -> dashes."""
    slug = _ascii_fold(family).strip().lower().replace(' ', '-')
    return re.sub(r'[^a-z0-9-]', '', slug)


def main(argv=None):
    parser = argparse.ArgumentParser(
        description='Flag which fonts in figma-extract.json are available on Google Webfonts Helper.'
    )
    parser.add_argument('--extract', default=DEFAULT_EXTRACT,
                        help='Path to figma-extract.json (default: %s)' % DEFAULT_EXTRACT)
    args = parser.parse_args(argv)

    path = os.path.abspath(args.extract)
    if not os.path.isfile(path):
        raise MatchError('No extract file at %s. Run mcp_tokens_to_extract.py first.' % path)

    with open(path, 'r', encoding='utf-8') as handle:
        try:
            data = json.load(handle)
        except json.JSONDecodeError as error:
            raise MatchError('%s is not valid JSON (%s).' % (path, error)) from error

    fonts = data.get('fonts')
    if not isinstance(fonts, list) or not fonts:
        raise MatchError('No "fonts" array in %s -- nothing to match.' % path)

    catalog = {family.lower(): category for family, category in BUNDLED_GOOGLE_FONTS.items()}

    matched, unverified = [], []
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
            # Unknown to the bundled list -- not proof it is unavailable.
            font['gwfhAvailable'] = False
            font['gwfhSlug'] = gwfh_slug(family)
            font['gwfhCandidateUrl'] = GWFH_URL.format(slug=font['gwfhSlug'])
            font['note'] = ('not in the bundled Google Fonts list -- open the candidate URL '
                            'to check; if it 404s, self-host and add a fallback only.')
            unverified.append(font)

    with open(path, 'w', encoding='utf-8') as handle:
        json.dump(data, handle, indent=2, ensure_ascii=False)
        handle.write('\n')

    print('Matched against the bundled Google Fonts list (%d families).' % len(catalog))
    print('Updated %s\n' % path)
    if matched:
        print('Google Fonts (download the weights listed, place in theme/assets/fonts/<slug>/):')
        for font in matched:
            print('  %s [%s] weights %s' % (
                font['family'], font['category'],
                ', '.join(str(weight) for weight in font.get('weights') or []),
            ))
            print('    %s' % font['gwfhUrl'])
    if unverified:
        print('\nNot in the bundled list -- check these before treating them as unavailable:')
        for font in unverified:
            print('  %s' % font['family'])
            print('    %s' % font['gwfhCandidateUrl'])
    return 0


if __name__ == '__main__':
    try:
        sys.exit(main())
    except MatchError as error:
        print('Error: %s' % error, file=sys.stderr)
        sys.exit(1)
    except KeyboardInterrupt:
        sys.exit(130)
