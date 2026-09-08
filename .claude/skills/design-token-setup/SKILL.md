---
name: design-token-setup
description: Set up a project's design tokens from a Figma file. Triggers when the user supplies a Figma design link (or file key) and wants fonts, colors, typography classes, and section/button classes wired into the Tailwind theme — e.g. "set up design tokens from this Figma", "new project setup from this design", "pull the fonts and colors out of Figma". Prefers the Figma Dev Mode MCP; falls back to the REST API when the desktop app is not available.
---

# Design token setup from Figma

Turns a Figma file into the theme's design tokens: `@font-face` blocks, `@theme`
font/color variables, and the `.ds-heading` / `.ds-subheading` / `.ds-section` /
`.ds-button` classes.

There are two extraction paths. **Prefer path A.**

|                            | Path A — Figma MCP                           | Path B — REST API                              |
| -------------------------- | -------------------------------------------- | ---------------------------------------------- |
| Needs                      | Figma desktop app open, Dev Mode MCP enabled | `FIGMA_TOKEN`                                  |
| Gets variables on any plan | yes                                          | **no** — REST Variables API is Enterprise-only |
| Token quality              | named variables + text styles, exact         | inferred from the node tree                    |

Path A is better because it returns the design system as authored — real
variable names and text styles — instead of guessing from geometry. Use path B
only when the desktop app is not running.

## Before first use

Both paths read `.env` from the project root (walking up from the working
directory). `.env` is gitignored; `.env.example` documents the keys.

- `FIGMA_TOKEN` — needed **only for path B**. Personal access token from
  <https://www.figma.com/settings> → Security → Personal access tokens
  (read-only "File content" scope is enough).
- `GOOGLE_FONTS_API_KEY` — _optional_, used by the font matcher in both paths.
  From <https://console.cloud.google.com/apis/credentials> with the Web Fonts
  Developer API enabled. Without it the matcher falls back to a bundled list of
  ~108 common families — good enough for most files, but a font it reports as
  unavailable may still be on Google Fonts.

For path A the user must have the Figma **desktop app** running with the file
open and the Dev Mode MCP server enabled (Figma → Preferences → Enable Dev Mode
MCP server). Check it is up before relying on it:

```bash
curl -s -o /dev/null -w "%{http_code}\n" --max-time 5 http://127.0.0.1:3845/mcp
```

Any response (including `400`) means the server is listening; a connection
failure means it is not — fall back to path B.

The scripts use only the Python standard library. The project has no other
Python code and no `requests` dependency, so keep it that way.

## Path A — Figma MCP (preferred)

### A1. Get the variable definitions

Call `get_variable_defs`, passing the node id from the user's Figma URL
(`?node-id=1-2` → `nodeId: "1:2"`). Point it at a **top-level page frame**, not a
single small node — the returned set only covers variables actually used inside
the node you ask about, so a text node returns two entries while the page frame
returns the whole palette and type scale.

If the user gave no node id, call `get_metadata` with no `nodeId` to list the
document's pages / current selection, then pick the frame with the user.

The response is a flat map of name → value:

```json
{
	"imark Black Text": "#000000",
	"imark White 20": "#fcfaf833",
	"H2": "Font(family: \"Inter\", style: Light, size: 60, weight: 300, lineHeight: 73, letterSpacing: 0)",
	"Body": "Font(family: \"Inter\", style: Light, size: 16, weight: 300, lineHeight: 23, letterSpacing: 0)"
}
```

### A2. Convert it to the extract file

Save that JSON and convert it — do not transcribe the values by hand:

```bash
python3 .claude/skills/design-token-setup/scripts/mcp_tokens_to_extract.py -i defs.json
```

This writes `figma-extract.json`, handling the parts that are easy to get wrong:

- **`lineHeight` is px in some styles and a percentage in others.** `lineHeight: 100`
  at `size: 14` means 100%, not 100px. Anything more than 3× the font size is
  read as a percentage.
- **Heading is chosen by size, not by name.** A file can define an `H1 | SEO`
  style at 16px for markup reasons while the visual headline is `H2` at 60px.
  Never assume the style called `H1` is the largest.
- **8-digit hex is preserved** (`#fcfaf833` — a colour with alpha).
- A brand prefix shared by every colour name (`imark …`) is stripped, so
  `imark Berry Barrierefrei` becomes `--color-ds-berry-barrierefrei`.

Every style is kept under `allTextStyles`, so the full type scale is available
even though only three roles are mapped.

### A3. Fill in section and button

Variable defs carry no layout, so `section` and `button` come back marked
`_needsReview`. Get them from the design:

- **Section** — call `get_design_context` on one representative content section
  (**load the `figma-design-to-code` skill first; it is a mandatory prerequisite
  for that tool**). Read the content max-width and the horizontal/vertical
  padding off the returned layout, and note the desktop vs mobile artboard
  widths from `get_metadata`.
- **Button** — call `get_design_context` on a button component to get font size,
  padding, radius, and its colour treatment.

Do not call `get_metadata` on a whole page: on a real file that is ~200k
characters and will blow the context window. Work frame by frame, or use the
node ids from a parent's metadata.

Derive the variant list from the button layer names, and **use the file's own
colour words rather than assuming `black`/`white`.** A layer set named
`Button-Berry`, `Button-Berry-Arrow-Outline`, `Button-Black-Text-Arrow`,
`Button-White-Text-Arrow` means the variants are `berry`, `berry-outline`,
`black`, `white`. Ignore words that are labels rather than colours
(`Button-Kontakt-speichern` is not a "kontakt" variant).

Merge the values in:

```bash
python3 .claude/skills/design-token-setup/scripts/mcp_tokens_to_extract.py \
  -i defs.json \
  --extra '{"section": {"maxWidth": 1340, "paddingX": {"lg": 50, "sm": 24}, "paddingY": {"lg": 96, "sm": 48}},
            "button": {"fontSize": 16, "paddingX": 24, "paddingY": 12, "borderRadius": 8,
                       "colorVariants": ["berry", "berry-outline", "black", "white"]}}'
```

Then continue at **step 2**.

## Path B — REST API (fallback)

```bash
python3 .claude/skills/design-token-setup/scripts/figma_fetch.py "<figma-url>"
```

Writes the same `figma-extract.json` and prints a summary saying whether it used
the Variables API or fell back to walking the document tree.

Treat its `textStyles`, `section` and `button` values as guesses — it picks the
largest text on the page as the heading and looks for frames named
`section`/`wrapper`/`container`, which many real files do not have (watch for
`section.candidateCount`). `--no-variables` forces the document-walk path.

## 2. Match fonts

Same for both paths:

```bash
python3 .claude/skills/design-token-setup/scripts/match_gwfh_fonts.py
```

Adds `gwfhAvailable`, `gwfhSlug`, `gwfhUrl` and `category` to each font entry.

## 3. Show the user the extract before writing anything

**Always** summarize the extracted values in chat and get confirmation before
touching a file. Even on path A the role mapping is a heuristic: which style is
"the heading", whether a 45px style is a subheading or an h3, and the whole
`section`/`button` block are judgement calls. Ask about anything that looks off
rather than writing it.

## 4. Locate the target files

Search rather than assuming — these are the paths in this theme today, but
confirm each one exists before editing:

```bash
find styles -name "tailwind.css" -o -name "fonts.css" -o -name "layout.css"
```

| What                            | Expected path                       |
| ------------------------------- | ----------------------------------- |
| Tailwind entry + `@theme` block | `styles/tailwind/tailwind.css`      |
| `@font-face` rules              | `styles/tailwind/custom/fonts.css`  |
| Component classes               | `styles/tailwind/custom/layout.css` |
| Font binaries                   | `theme/assets/fonts/<slug>/`        |

Read each file first and match the formatting already in it (4-space indent,
single quotes in CSS `font-family`, the `/* Fonts */` and `/* Colors */`
comment headers inside `@theme`).

## 5. Fonts

For each font with `gwfhAvailable: true`:

1. Give the user its `gwfhUrl` and the weight list, and ask them to download the
   `woff2` files and place them in `theme/assets/fonts/<gwfhSlug>/`. **Do not
   try to download these yourself** — google-webfonts-helper has no public API
   and the scripts deliberately do not scrape it.
2. Once the user confirms the files are in place, list the directory to get the
   real filenames, then write one `@font-face` block per weight into
   `fonts.css`, following the commented example already in that file:

    ```css
    @font-face {
    	font-display: swap;
    	font-family: 'Inter';
    	font-style: normal;
    	font-weight: 300;
    	src: url('../assets/fonts/inter/inter-v20-latin-300.woff2')
    		format('woff2');
    }
    ```

    The `../` is relative to the compiled stylesheet at `theme/dist/style.css`,
    **not** to the source file — so `../assets/fonts/…` resolves to
    `theme/assets/fonts/…`. If the commented example uses a flat layout with no
    per-font subdirectory, follow whichever layout the downloaded files use.

Only write the weights the design actually uses (the `weights` array), not every
weight the family ships.

For each font with `gwfhAvailable: false`: skip the file setup entirely, but
still add the family to the `@theme` variable with its fallback, and tell the
user it has to be self-hosted or licensed separately.

In `tailwind.css` under `/* Fonts */`, set the family variables, using the
matcher's `category` field to pick the slot (`serif` / `display` →
`--font-serif`, otherwise `--font-sans`) and keeping the existing fallbacks:

```css
/* Fonts */
--font-sans: 'Inter', 'Arial', sans-serif;
--font-serif: 'Newsreader', 'Times New Roman', serif;
```

**A file with only one family is the common case.** Do not invent a second one:
put it in the slot its category calls for, ask the user what the other slot
should do, and leave that slot's existing value alone until they say.

## 6. Colors

Under `/* Colors */` in `tailwind.css`:

1. Add each extracted colour as a custom property named from its
   `variableName` (`--color-ds-berry-barrierefrei: #a35c6b;`).
2. **First read what is already there.** This theme ships `--color-background`,
   `--color-primary`, `--color-secondary`, `--color-ds-black` and
   `--color-ds-white`. Update those in place to reference the new palette rather
   than adding a second near-identical set:

    ```css
    --color-ds-black: var(--color-ds-black-text);
    ```

    Define the raw palette entries before the semantic ones that reference them.

3. Report any existing variable whose meaning has no counterpart in the extract
   — do not silently drop or repurpose it.

## 7. Type scale, section and button classes

Font sizes live in `tailwind.css` as `--text-ds-<px>` entries written in rem with
the px value in a trailing comment (`--text-ds-16: 1rem; /* 16px */`). Follow
that convention for new sizes, and use the resulting `text-ds-*` utility in
`layout.css`. `allTextStyles` in the extract gives the full scale to work from.

Everywhere else, arbitrary Tailwind values are written in **px, never rem**
(`px-[80px]`), per the Template Rules in `CLAUDE.md`.

`.ds-heading`, `.ds-subheading`, `.ds-section` and `.ds-button` **already exist**
in `layout.css`, along with the `body` rule carrying the body text style. Update
them in place. Do not add a second class with a near-identical `@apply` list.

- `.ds-section` — `max-width` from `section.maxWidth`, padding from
  `section.paddingX` / `paddingY`, small value as the base and large on `lg:`:

    ```css
    .ds-section {
    	@apply mx-auto max-w-[1340px] px-[24px] py-[48px] lg:px-[50px] lg:py-[96px];
    }
    ```

- `.ds-heading` / `.ds-subheading` — family, size, weight and line height from
  `textStyles.heading` / `textStyles.subheading`.
- Body text — apply `textStyles.body` to the existing `body` rule.
- `.ds-button` — base styles (font size, padding, radius) with no colour, then
  one `.ds-button--<variant>` modifier per entry in `button.colorVariants`
  carrying only the colour treatment, used as
  `class="ds-button ds-button--berry"`:

    ```css
    .ds-button {
    	@apply w-fit rounded-full px-[24px] py-[12px] text-center text-ds-16 leading-normal;
    }

    .ds-button--berry {
    	@apply border border-ds-berry-barrierefrei bg-ds-berry-barrierefrei text-ds-white;
    	@apply lg:hover:bg-transparent lg:hover:text-ds-berry-barrierefrei;
    }
    ```

## 8. Verify and report

Run the build and the formatter check so the new CSS actually compiles:

```bash
yarn development:tailwind:frontend && yarn lint:prettier
```

Then summarize:

- which files were written and what went into each;
- fonts still needing manual work (`gwfhAvailable: false`, or files the user has
  not dropped in yet);
- values that were guessed or ambiguous — an unfilled `_needsReview`, a
  `section.candidateCount` of 0 on path B, a second font slot left alone, an
  existing colour variable with no counterpart in the extract;
- anything in the extract you deliberately did not write.

## Notes

- `figma-extract.json` is a working artifact. It is not gitignored — either add
  it to `.gitignore` or delete it once the tokens are in place.
- Re-running the extractor overwrites the file, discarding hand corrections;
  re-run `match_gwfh_fonts.py` afterwards, since it enriches the file in place.
- The MCP tools act on the **current selection** when given no `nodeId`, so what
  they return depends on what the user has clicked in the desktop app. Always
  pass an explicit `nodeId` when you have one.
