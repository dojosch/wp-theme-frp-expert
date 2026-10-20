# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Commands

**Development:**
```bash
yarn watch      # Same as dev + BrowserSync live reload
```

**Production:**
```bash
yarn prod       # Minified production build
```

## Architecture

This is a WordPress theme (PHP 7.4+, WP 6.2+) using Tailwind CSS v4, Alpine.js v3, and ACF (Advanced Custom Fields) for flexible content. The block editor is disabled — all content is managed through ACF flexible content fields.

### Entry Points

- [theme/functions.php](theme/functions.php) — Bootstraps by requiring all files from `theme/config/` and `theme/utils/`
- [theme/page-templates/main-template.php](theme/page-templates/main-template.php) — Main page template; loops over ACF flexible content rows and includes matching section layouts

### Config vs Utils

- **`theme/config/`** — WordPress hooks and setup (enqueues, CPTs, ACF field groups, security hardening, performance bloat removal)
- **`theme/utils/`** — Pure helper functions consumed by templates and components

### Component System

Always use `ds_render_component()` instead of writing inline HTML for anything a component already covers. Components live in `theme/page-templates/components/`; sections in `theme/page-templates/sections/`. The render function extracts the `$args` array as local variables inside the component file.

```php
ds_render_component('component-name', ['var' => $value]);
```

**Available components and their variables:**

| Component | Required variables | Optional variables |
|---|---|---|
| `heading` | `$heading` (array with `heading` + `heading_tag` keys) | `$css_class` |
| `image` | `$image` (array with `src` + `alt` keys) | `$css_class` |
| `text` | `$text` (HTML string) | `$css_class` |
| `link` | `$link` (ACF link array) | `$css_class` |
| `link-button` | `$link` (ACF link array) | `$css_class` (appended to `ds-button`) |
| `video` | `$video` (array with `url` + `mime_type` keys) | `$css_class` |
| `media` | `$media` (array with `type`, `image` ID or `video` array) | `$css_class` |
| `shortcode` | `$shortcode` (shortcode string) | `$css_class` |
| `faq` | `$heading` (string or array) | `$heading_tag`, `$text`, `$index`, `$icon` (inline SVG), `$open`, `$css_class`, `$button_class`, `$number_class`, `$heading_class`, `$icon_class`, `$icon_open_class`, `$icon_idle_class`, `$content_class`, `$text_class` |

Section layouts are included from `theme/page-templates/sections/` based on the ACF flexible content row layout name. Each section has a `section_config` sub-field with `id`, `css_class`, and `background`.

### Key Utility Functions

**Images** — all return `['src', 'alt']` or `null`:
```php
ds_get_image_data_from_field($field_name, $size)
ds_get_image_data_from_sub_field($field_name, $size)
ds_get_image_data_from_option_field($field_name, $size)
ds_get_image_data_from_id($attachment_id, $size)
```

**Content:**
```php
ds_get_link($link_array, $css_class)            // ACF link array → <a> tag
ds_open_link($link_array, $css_class)           // ACF link array -> <a> tag
ds_close_link()
ds_open_section($additional_classes)            // Opens <section> wrapper
ds_close_section()
```

**Assets:**
```php
ds_get_theme_asset_url($path)   // → /assets/{path}
ds_get_theme_image_url($path)   // → /assets/images/{path}
ds_get_theme_icon_url($path)    // → /assets/images/icons/{path}
ds_get_theme_logo_url($path)    // → /assets/images/logos/{path}
```

**Debug:**
```php
ds_console_log($data, $context) // Outputs to browser console
```

### Frontend Assets

- **CSS**: Tailwind CSS v4, compiled via PostCSS. Source: `styles/tailwind/tailwind.css`. Output: `theme/dist/style.css` (frontend) and `theme/dist/style-editor.css` (block editor). All classes are prefixed `ds_`.
- **Admin CSS**: plain CSS, no Tailwind. Source: `styles/admin.css`, copied to `theme/dist/admin.css` and enqueued on every wp-admin screen.
- **JS**: Bundled with esbuild from `javascript/`. Output: `theme/dist/script.min.js`.
- **Libraries**: Alpine.js and Swiper are bundled into the JS output.

### PHP Conventions

- All theme functions are prefixed `ds_`.
- Text domain: `ds-starter`.
- PHP CodeSniffer enforces WordPress-Extra + WordPress-Docs standards; always escape output (`esc_attr`, `esc_url`, `esc_html`, `wp_kses`).
- Locale: `de_DE` (German), timezone: `Europe/Vienna`.

**Formatting** — `yarn format:php` rewrites `theme/` to match; `yarn lint:format` checks without writing (part of `yarn lint`). Write new code this way rather than relying on the formatter:

- No alignment padding on assignments — `$file = ...`, never `$file       = ...`.
- Control-structure conditions pad inside the parens but not before them — `if( $debugging )`, never `if ($x)` or `if($x)`. Applies to `if`, `elseif`, `while`, `for`, `foreach`, `switch`, `catch`.
- Everything else stays tight: no padding inside call parens or brackets, and none after `!` — `get_field('heading', $id)`, `!empty($x)`, `['page']`. A nested call inside a condition keeps that tightness: `if( !empty($args) )`.
- A condition whose whole body is a single `return`, `continue` or `break` goes on one line without braces — `if( !$link ) return;`. Anything longer keeps its braces.
- `ds_render_component()` calls use short array syntax with `=>` aligned, the array opening on the call line and the keys one indent level in:

```php
ds_render_component('heading', [
    'heading'   => $heading,
    'css_class' => 'ds-heading',
]);
```

Note: these rules invert several WordPress-Extra sniffs (`Generic.Formatting.MultipleStatementAlignment`, `WordPress.WhiteSpace.ControlStructureSpacing`, `Generic.ControlStructures.InlineControlStructure`). `phpcbf` is not installed in this checkout; if it gets installed, exclude those sniffs in `phpcs.xml.dist` — `lint-fix:php` runs the formatter after `phpcbf` so the house style wins either way.

### Template Rules

Apply these when writing or editing anything under `theme/page-templates/`. `yarn lint:templates` checks the mechanical subset and runs on save during `yarn watch`; suppress a single false positive with a `ds-lint-ignore` (or `ds-lint-ignore:<rule>`) comment on the offending line or the line above.

**Markup and styling**

- Use px in Tailwind arbitrary values, never rem — `gap-[77px]`, not `gap-[4.8125rem]`. Applies to spacing, sizes, font sizes and line heights. Raw `@media` queries in `styles/tailwind/custom/*.css` are the exception: mirror Tailwind's rem breakpoints there (`@media (min-width: 64rem)` for `lg`). *(lint: `no-rem-arbitrary`)*
- Space stacked elements with `flex flex-col` + `gap-*` on the parent. Never use `mt-*` for spacing; nest another `flex flex-col gap-*` for a sub-group's tighter rhythm. An absolute offset with no preceding sibling to space from (e.g. `lg:mt-[305px]` staggering a grid column) is a position, not spacing — mark it with `ds-lint-ignore`. *(lint: `no-margin-spacing`)*
- Use `<div>` for structural wrappers. Reserve `<p>` for prose. *(lint: `no-p-wrapper`)*
- Style one-off, single-template cases with inline Tailwind utilities. Add a named class to `styles/tailwind/custom/layout.css` only when it is reused across multiple files (buttons, links, headings).
- Check whether an existing named class (`.ds-button`, `.ds-button--menu`, …) already gives the right base behavior before writing a new one. Two classes with near-identical `@apply` lists mean the second should not exist.

**PHP templates**

- Render ACF text and WYSIWYG output with `ds_render_component('text', [...])`. Never hand-roll `<div><?php echo $text; ?></div>`, and never wrap the call in an `!empty($text)` check — the component already guards on empty and unset values. The same applies to the other components: they self-guard, so callers don't add their own checks. *(lint: `no-raw-text-echo`, `no-redundant-text-guard`)*
- No top-of-file docblock or explainer comment on section, layout and page templates — narrative explanation belongs in the commit message. Two exceptions: page templates keep the WordPress `Template Name:` header, and components document their `$args` contract. *(lint: `no-file-docblock`)*
- Don't declare a PHP variable for a value used only once — inline the ternary class string or ACF sub-field read at its single call site. Keep variables for values read twice or more, or non-trivial to recompute.
- Use the `section-header` component for a section's sub-heading + heading pair rather than two `heading` calls; pass layout tweaks via `css_class` on the wrapper. (Not present in this theme yet — add it before the first section needs one.)

### Custom Post Types

Registered in `theme/config/cpt.php` using `ds_register_cpt()`.

### ACF Field Groups

JSON sync files live in `theme/config/acf-fields/`. Options pages are configured in `theme/config/acf-options.php`.

When registering ACF field groups in PHP, always use the helpers from `theme/utils/acf-fields/` instead of writing raw field arrays. Each helper accepts `$key`, `$label`, and an optional `$args` array that is merged via `wp_parse_args` to override defaults.

**Heading fields** (`theme/utils/acf-fields/heading.php`) — all return a `group` with `heading` + `heading_tag` sub-fields:
```php
ds_heading_field($key, $label, $default_tag='h2', $default_text='', $args=[])          // text input
ds_heading_textarea_field($key, $label, $default_tag='h2', $default_text='', $args=[]) // textarea (supports line breaks)
ds_heading_wysiwyg_field($key, $label, $toolbar='basic', $default_tag='h2', $args=[]) // WYSIWYG
```
The returned group value is an array `['heading' => '...', 'heading_tag' => 'h2']` — pass it directly as `$heading` to the `heading` component.

**Text fields** (`theme/utils/acf-fields/text.php`):
```php
ds_text_field($key, $label, $args=[])                          // single-line text
ds_textarea_field($key, $label, $rows=4, $args=[])             // textarea
ds_wysiwyg_field($key, $label, $toolbar='basic', $media_upload=0, $args=[]) // WYSIWYG → use $text in text component
```

**Email field** (`theme/utils/acf-fields/email.php`):
```php
ds_email_field($key, $label, $args=[]) // email input with ACF email validation
```

**Select field** (`theme/utils/acf-fields/select.php`):
```php
ds_select_field($key, $label, $choices=[], $default_value='', $args=[]) // select, $choices as 'value' => 'Label'
```

**Image fields** (`theme/utils/acf-fields/image.php`) — return format is `id`:
```php
ds_image_field($key, $label, $args=[])                          // standard image
ds_image_crop_field($key, $label, $width=1, $height=1, $args=[]) // forced aspect ratio crop
ds_header_image_field($key, $label, $args=[])                   // returns full array, not id
```
Retrieve image data with `ds_get_image_data_from_field()` / `ds_get_image_data_from_id()` and pass the result as `$image` to the `image` component.

**Link field** (`theme/utils/acf-fields/link.php`):
```php
ds_link_field($key, $label, $args=[]) // ACF link array → pass as $link to link / link-button component
```

**Group field** (`theme/utils/acf-fields/group.php`):
```php
ds_group_field($key, $label, $sub_fields=[], $args=[]) // group of sub_fields
```

**Accordion field** (`theme/utils/acf-fields/accordion.php`):
```php
ds_accordion_field($key, $label, $args=[]) // collapsible accordion that wraps the fields after it
```

**Repeater field** (`theme/utils/acf-fields/repeater.php`):
```php
ds_repeater_field($key, $label, $sub_fields=[], $button_label='Add Row', $args=[]) // repeater of sub_fields
```

**Toggle field** (`theme/utils/acf-fields/toggle.php`):
```php
ds_toggle_field($key, $label, $args=[]) // true/false switch
```

**Video field** (`theme/utils/acf-fields/video.php`):
```php
ds_video_field($key, $label, $args=[]) // file field (mp4/webm) → pass as $video to video component
```

**Media field** (`theme/utils/acf-fields/media.php`) — group with `type` selector + conditional `image`/`video` sub-fields:
```php
ds_media_field($key, $label, $args=[])                          // image (id) or video
ds_media_crop_field($key, $label, $width=1, $height=1, $args=[]) // same with aspect-ratio crop
```
Pass the whole group value as `$media` to the `media` component.