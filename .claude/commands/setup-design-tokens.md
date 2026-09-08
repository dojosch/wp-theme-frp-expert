---
description: Set up design tokens (fonts, colors, typography, section/button classes) from a Figma file
argument-hint: <figma-url>
---

Set up this theme's design tokens from the Figma file at: $1

Use the `design-token-setup` skill and follow its procedure.

Prefer **path A (Figma MCP)**: extract the node id from the URL above
(`?node-id=1-2` → `nodeId: "1:2"`) and call `get_variable_defs` on a top-level
page frame, then convert with `mcp_tokens_to_extract.py`. Fall back to path B
(`figma_fetch.py` with the URL) only if the Dev Mode MCP server is not
reachable.

If no URL was given above, ask for the Figma file link — or, if the desktop app
already has the right frame selected, say so and work from the selection.

Remember: show the extracted JSON summary and get confirmation before writing to
any file, and do not attempt to download fonts from google-webfonts-helper —
that step is the user's.
