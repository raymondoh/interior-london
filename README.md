# WordPress Boilerplate Theme

A lean, modern WordPress starter theme with **Tailwind CSS v4**, **esbuild**, and optional modules (Alpine.js, Fancybox, Swiper).

---

## 🚀 Quick Start

1. Clone this theme into your WordPress `wp-content/themes/` directory.
2. Install dependencies:
   ```bash
   npm install
   ```
3. Install dependencies:
   npm run watch
4. Or build for production (minified):
   npm run build
5. Activate the theme in the WordPress admin, and you’re good to go.

📦 Scripts
npm install – install dependencies

npm run watch – watch and rebuild CSS/JS on changes

npm run build – one-time build (minified)

🗂 File Structure
theme/
├── style.css # Theme header + optional overrides
├── functions.php # Boots theme, defines modules, pulls in inc/\*
├── inc/
│ ├── setup.php # Theme supports, menus, image sizes
│ └── enqueue.php # Enqueues CSS/JS + optional modules
├── assets/
│ ├── css/main.css # Compiled Tailwind output
│ └── js/main.js # Bundled JS output
├── src/
│ ├── css/tailwind.css # Tailwind entrypoint (@import "tailwindcss";)
│ └── js/main.js # Theme JS entrypoint
├── header.php # Calls wp_head()
├── footer.php # Calls wp_footer()
├── index.php # Default loop template
└── front-page.php # Homepage template (optional)

⚙️ Modules
Modules are toggled in functions.php via $BP_MODULES:
$BP_MODULES = array(
'alpine' => false, // Alpine.js
'fancybox' => false, // Fancybox (lightbox)
'swiper' => false, // Swiper (sliders)
);
Set to true to enqueue the CDN assets.

🎨 Styling

Tailwind v4 is installed and configured.

Add global base styles, components, and utilities inside src/css/tailwind.css.

Run npm run build or npm run watch to recompile into assets/css/main.css.

✅ Requirements

Node.js 18+

WordPress 6.0+

PHP 7.4+

🆕 Creating a New Project

When starting a new site:

1. Copy the boilerplate into wp-content/themes/your-theme-name.
2. Update style.css header:

Update style.css header:
/_
Theme Name: My Project Theme
Author: Your Name
Description: Custom theme for [Project Name].
Version: 1.0.0
Text Domain: my-project
_/ 4. Edit functions.php → flip module toggles (alpine, fancybox, swiper) depending on what you need. 4. Install dependencies:
npm install 5. Run the build:
npm run watch

6. Customize templates: duplicate/extend index.php into page.php, single.php, archive.php as needed.
   7.Start coding 🚀

📝 Notes
This boilerplate is intentionally minimal: no Customizer, no widgets, no legacy clutter.

Extend templates (page.php, single.php, archive.php, etc.) as needed per project.

Compatible with child themes or direct extension.
