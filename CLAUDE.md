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
| `collapsible` | `$heading` (array), `$index` | `$heading_tag`, `$text`, `$link` |

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

- **CSS**: Tailwind CSS v4, compiled via PostCSS. Source: `tailwind/tailwind.css`. Output: `theme/dist/style.css` (frontend) and `theme/dist/style-editor.css` (block editor). All classes are prefixed `ds_`.
- **JS**: Bundled with esbuild from `javascript/`. Output: `theme/dist/script.min.js`.
- **Libraries**: Alpine.js and Swiper are bundled into the JS output.

### PHP Conventions

- All theme functions are prefixed `ds_`.
- Text domain: `ds-starter`.
- PHP CodeSniffer enforces WordPress-Extra + WordPress-Docs standards; always escape output (`esc_attr`, `esc_url`, `esc_html`, `wp_kses`).
- Locale: `de_DE` (German), timezone: `Europe/Vienna`.

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

**Repeater field** (`theme/utils/acf-fields/repeater.php`):
```php
ds_repeater_field($key, $label, $sub_fields=[], $args=[]) // repeater of sub_fields
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