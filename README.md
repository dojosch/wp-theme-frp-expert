# devsolution Starter

Starter Theme for devsolution

## 🚀 Quickstart

### 🛠 Installation

1. Move this folder to `wp-content/themes` in your local development environment.
2. Run `yarn install && yarn dev` in this folder.
3. Activate the theme in the WordPress admin panel.

### ⚙️ Development Workflow

4. Run `yarn watch` to start the dev watcher.
5. Use [Tailwind CSS v4 utility classes](https://tailwindcss.com/docs/utility-first) to style your components.
6. Write interactive frontend logic using [Alpine.js](https://alpinejs.dev/) (already included).
7. Develop components in `page-templates/components/` and render them using `ds_render_component()`.

### 🚀 Deployment

8. Run `yarn bundle` to compile production-ready assets and create a ZIP.
9. Upload the resulting ZIP to your WordPress site using “Upload Theme” under “Appearance > Themes”.

---

This theme uses:

- **Tailwind CSS v4**
- **Alpine.js v3**
- A clean utility structure for custom post types, security, ACF blocks, components, and mail handling.
