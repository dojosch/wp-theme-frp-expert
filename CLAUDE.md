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

Components live in `theme/page-templates/components/` and sections in `theme/page-templates/sections/`. Use the central render function:

```php
ds_render_component('component-name', ['var' => $value]);
// Includes components/{component-name}.php with $args extracted as variables
```

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
