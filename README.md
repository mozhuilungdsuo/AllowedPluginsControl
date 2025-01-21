# Allowed Plugins Control

## Plugin Details
- **Plugin Name**: Allowed Plugins Control
- **Description**: Restricts plugin installation to a predefined list and hides this plugin from the Plugins page.
- **Version**: 1.0
- **Author**: Lungdsuo Mozhui

## Overview
The Allowed Plugins Control plugin allows WordPress administrators to restrict the installation of plugins to a predefined list. Additionally, it hides itself from the Plugins page to prevent accidental deactivation or removal.

## Features
1. **Predefined Plugin Installation Restriction**: 
   - Ensures that only plugins specified in the allowed list can be installed.
2. **Self-Hiding from Plugins Page**:
   - Prevents this plugin from being visible in the Plugins page.
3. **Disable Install Button for Restricted Plugins**:
   - Removes the "Install" button for plugins not included in the allowed list.

## Installation
1. Download the plugin file.
2. Upload it to your WordPress installation in the `wp-content/plugins/` directory.
3. Activate the plugin through the WordPress Admin Dashboard under **Plugins** > **Installed Plugins**.

## Configuration
1. Open the plugin file and locate the function `apc_get_allowed_plugins()`.
2. Add the slugs of the plugins you want to allow in the array. For example:
   ```php
   function apc_get_allowed_plugins() {
       return [
           'akismet', 
           'classic-editor', 
       ];
   }
   ```
4. The slugs can be found in the URL of the plugin's WordPress.org page. For example, the slug for Akismet is `akismet`. or you can find the plugin slug in the plugin's main file.
5. Save the changes

## Code Details

### 1. Define Allowed Plugins
The `apc_get_allowed_plugins` function specifies which plugins are permitted for installation.
```php
function apc_get_allowed_plugins() {
    return [
        'akismet', 
        'classic-editor', 
    ];
}


## Disclaimer
Use this plugin carefully. Misconfiguration can restrict essential plugins from being installed. Ensure the allowed list is updated as required.

## Changelog
### Version 1.0
- Initial release
- Added functionality to restrict plugin installation to a predefined list.
- Self-hiding feature for better security.
- Disabled install button for restricted plugins.

## Author
**Lungdsuo Mozhui**

