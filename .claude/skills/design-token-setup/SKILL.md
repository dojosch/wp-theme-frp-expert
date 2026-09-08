---
name: design-token-setup
description: Set up a project's design tokens from a Figma file via the Figma Dev Mode MCP. Triggers when the user supplies a Figma design link (or has a frame selected) and wants fonts, colors, typography classes, and section/button classes wired into the Tailwind theme — e.g. "set up design tokens from this Figma", "new project setup from this design", "pull the fonts and colors out of Figma".
---

# Design token setup from Figma

Requires the Figma **desktop app** open with the Dev Mode MCP server enabled
(Figma → Preferences → Enable Dev Mode MCP server). If `get_variable_defs`
errors, say so and stop — there is no fallback path.

## Token budget

This skill is cheap if you follow these; ignoring them costs tens of thousands
of tokens:

- **Never call `get_metadata` on a page id.** A real page is ~200k characters
  and will blow the context window. Call it on one frame, or not at all.
- **Pass `excludeScreenshot: true`** to `get_design_context`. Images are the
  single largest cost here and the layout numbers are in the text.
- **Call `get_design_context` at most twice** — one section frame, one button.
- **Don't read `figma-extract.json` back.** The scripts print everything you
  need; the file is for them, not for you.
- **Don't hand-write the CSS.** `--emit-css` generates it.

## 1. Extract

Call `get_variable_defs` with the node id from the user's URL (`?node-id=1-2` →
`nodeId: "1:2"`). Target a **top-level page frame**: the result covers only
variables used inside the node you ask for, so a text node returns two entries
while the page frame returns the whole system. With no URL, call `get_metadata`
with no `nodeId` (that lists pages / the current selection) and pick a frame
with the user.

Save the response to `defs.json` and convert:

```bash
python3 .claude/skills/design-token-setup/scripts/mcp_tokens_to_extract.py -i defs.json
python3 .claude/skills/design-token-setup/scripts/match_gwfh_fonts.py
```

The converter handles what is easy to get wrong: `lineHeight` that is px in one
style and a percentage in another (`lineHeight: 100` at `size: 14` means 100%);
heading chosen by **size, not name** (a file may define `H1 | SEO` at 16px while
the real headline is `H2` at 60px); 8-digit hex with alpha; and stripping a
brand prefix shared by every colour (`imark Berry` → `--color-ds-berry`).

`match_gwfh_fonts.py` adds `gwfhAvailable` / `gwfhSlug` / `gwfhUrl` / `category`.
It is fully offline, matching against a bundled list of ~108 families. A family
it does not know is reported as **unverified, not unavailable** — it still gets
a `gwfhCandidateUrl`. Open that URL (or ask the user to) before concluding the
font has to be self-hosted, and extend `BUNDLED_GOOGLE_FONTS` when you confirm
a new one.

## 2. Section and button

Variable defs carry no layout, so these come back `_needsReview`. Call
`get_design_context` (with `excludeScreenshot: true`) on one representative
section frame and one button component. **Load the `figma-design-to-code` skill
first — it is a mandatory prerequisite for that tool.**

Read off the content max-width, horizontal/vertical padding, and the button's
font size, padding and radius.

Derive variants from button layer names using **the file's own colour words, not
an assumed black/white**: `Button-Berry`, `Button-Berry-Arrow-Outline`,
`Button-Black-Text-Arrow` → `berry`, `berry-outline`, `black`. Ignore label
words — `Button-Kontakt-speichern` is not a "kontakt" variant.

Merge them in:

```bash
python3 .claude/skills/design-token-setup/scripts/mcp_tokens_to_extract.py -i defs.json \
  --extra '{"section": {"maxWidth": 1340, "paddingX": {"lg": 50, "sm": 24}, "paddingY": {"lg": 96, "sm": 48}},
            "button": {"fontSize": 16, "paddingX": 24, "paddingY": 12, "borderRadius": 24,
                       "colorVariants": ["berry", "berry-outline", "black", "white"]}}'
python3 .claude/skills/design-token-setup/scripts/match_gwfh_fonts.py
```

(Re-run the matcher — the converter rewrites the file.)

## 3. Confirm before writing

Show the user the printed summary and get confirmation. The role mapping is a
heuristic: which style is "the heading", whether a 45px style is a subheading or
an h3, and the whole section/button block are judgement calls.

## 4. Fonts

For each font with `gwfhAvailable: true`, give the user its `gwfhUrl` and weight
list and ask them to put the `.woff2` files in `theme/assets/fonts/<gwfhSlug>/`.
**Do not download them yourself** — google-webfonts-helper has no public API and
the scripts deliberately do not scrape it. Only the weights the design uses.

For `gwfhAvailable: false`, check its `gwfhCandidateUrl` first. If the font is
genuinely not there, skip the files but keep the family in the `@theme` variable
with its fallback, and say it needs self-hosting or a licence.

## 5. Generate and merge the CSS

Once the font files are in place (or if there are none to place):

```bash
python3 .claude/skills/design-token-setup/scripts/mcp_tokens_to_extract.py --emit-css
```

This prints CSS grouped by target file, reading the real `.woff2` filenames off
disk for the `@font-face` blocks. Verify the paths exist before editing —
they are what this theme uses today, not a guarantee:

| Block                           | File                                |
| ------------------------------- | ----------------------------------- |
| `@theme` fonts / sizes / colors | `styles/tailwind/tailwind.css`      |
| `@font-face`                    | `styles/tailwind/custom/fonts.css`  |
| Component classes               | `styles/tailwind/custom/layout.css` |

**Merge, do not paste over.** Specifically:

- `.ds-heading`, `.ds-subheading`, `.ds-section`, `.ds-button` and the `body`
  rule **already exist** in `layout.css`. Update them in place; never add a
  second class with a near-identical `@apply` list.
- Several `--text-ds-*` sizes already exist. Add only the missing ones.
- `--color-background`, `--color-primary`, `--color-secondary`,
  `--color-ds-black`, `--color-ds-white` already exist. Repoint them at the new
  palette rather than adding a parallel set, and define raw palette entries
  before the semantic ones that reference them. Report any existing variable
  with no counterpart in the design instead of dropping it.
- Act on every `TODO` comment in the emitted CSS.
- Arbitrary values are **px, never rem** (`px-[80px]`), per the Template Rules
  in `CLAUDE.md`. The `--text-ds-*` scale is the one exception: rem with the px
  value in a trailing comment.

## 6. Verify and report

```bash
yarn development:tailwind:frontend && yarn lint:prettier
```

Then report: files written; fonts still needing manual work; anything guessed or
ambiguous (an unfilled `_needsReview`, a font slot left alone because the design
has only one family, a `TODO` you resolved by judgement); and anything in the
extract you deliberately skipped.

## Notes

- `figma-extract.json` is a working artifact — gitignore or delete it when done.
- MCP tools act on the **current selection** when given no `nodeId`. Always pass
  an explicit one when you have it.
- Both scripts are standard-library only and need no network, keys or `.env`.
