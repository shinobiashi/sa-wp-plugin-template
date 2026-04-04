# sa-wp-plugin-template

Template repository for developing WooCommerce extension plugins.

## Stack

- **PHP**: 8.2+, WordPress 6.4+, WooCommerce 9.0+
- **Frontend**: `@wordpress/scripts` (webpack) + React
- **Dev environment**: `wp-env`
- **Coding standards**: WordPress Coding Standards (WPCS)
- **HPOS**: WooCommerce Custom Order Tables compatibility declared

### Directory Structure

```text
plugin-name/
├── plugin-name.php                            # Main plugin file
├── uninstall.php                              # Uninstall handler
├── composer.json
├── package.json
├── webpack.config.js
├── .wp-env.json
├── includes/
│   ├── class-plugin-name.php                 # Main class (singleton)
│   ├── admin/
│   │   └── class-saai-admin-plugin-name.php  # Admin submenu & script registration
│   └── saai_framework/
│       ├── class-saai-admin-page.php         # Shared SAAI admin menu
│       └── class-saai-wc-user.php            # WC user utility
├── src/
│   └── saai/admin/
│       └── overview/                         # SAAI overview page (React)
├── assets/
│   ├── build/                                # webpack build output
│   └── images/                               # Icons and images
└── i18n/                                     # Translation files
```

## Getting Started

### Prerequisites

- [NPM](https://www.npmjs.com/)
- [Composer](https://getcomposer.org/download/)
- [wp-env](https://developer.wordpress.org/block-editor/reference-guides/packages/packages-env/)

### Installation and Build

```bash
npm install
npm run build
wp-env start
```

## Creating a New Plugin from This Template

1. Create a new repository using this template.
2. Replace `plugin-name`, `Plugin_Name`, and `plugin_name` with your actual plugin slug/name.
3. Update the constants `PLUGIN_NAME_PATH`, `PLUGIN_NAME_URL`, and `PLUGIN_NAME_VERSION` accordingly.
4. Update `name` in `composer.json` and `package.json`.
5. Run `npm install && npm run build`.

## Common Commands

| Command | Description |
| --- | --- |
| `npm run build` | Build JS/CSS |
| `npm run start` | Start watch mode |
| `npm run lint:js` | Lint JavaScript |
| `npm run lint:css` | Lint CSS |
| `npm run make-pot` | Generate translation template |
| `wp-env start` | Start dev environment |
| `wp-env stop` | Stop dev environment |
