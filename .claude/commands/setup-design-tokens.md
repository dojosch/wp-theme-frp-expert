---
description: Set up design tokens (fonts, colors, typography, section/button classes) from a Figma file
argument-hint: <figma-url>
---

Set up this theme's design tokens from the Figma file at: $1

Use the `design-token-setup` skill and follow its procedure. Extract the node id
from the URL above (`?node-id=1-2` → `nodeId: "1:2"`) and call
`get_variable_defs` on a top-level page frame.

If no URL was given, ask for the link — or work from the current selection in
the Figma desktop app if the user says the right frame is already selected.

Mind the skill's token budget: no `get_metadata` on a page id, always
`excludeScreenshot: true`, and let `--emit-css` write the CSS.

Show the summary and get confirmation before writing to any file, and do not
download fonts from google-webfonts-helper — that step is the user's.
