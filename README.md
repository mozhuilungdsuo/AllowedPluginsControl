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
3. Save the changes.

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
```

### 2. Restrict Plugin Installation
The `apc_restrict_plugin_installation` function prevents installation of plugins not included in the allowed list. If a user attempts to install a restricted plugin, a message will be displayed.
```php
function apc_restrict_plugin_installation($install_result, $slug) {
    $allowed_plugins = apc_get_allowed_plugins();

    if (!in_array($slug, $allowed_plugins)) {
        wp_die(
            __('You are not allowed to install this plugin.', 'allowed-plugins-control'),
            __('Plugin Installation Restricted', 'allowed-plugins-control'),
            ['response' => 403]
        );
    }

    return $install_result;
}
add_filter('pre_install_plugin', 'apc_restrict_plugin_installation', 10, 2);
```

### 3. Hide Plugin from Plugins Page
The `apc_hide_self_plugin` function hides this plugin from being displayed in the Plugins page.
```php
function apc_hide_self_plugin($plugins) {
    $plugin_to_hide = plugin_basename(__FILE__);

    if (isset($plugins[$plugin_to_hide])) {
        unset($plugins[$plugin_to_hide]);
    }

    return $plugins;
}
add_filter('all_plugins', 'apc_hide_self_plugin');
```

### 4. Disable Install Button
The `apc_disable_install_button` function removes the "Install" button for plugins not in the allowed list.
```php
function apc_disable_install_button($links, $plugin) {
    $allowed_plugins = apc_get_allowed_plugins();

    if (!empty($plugin['slug']) && !in_array($plugin['slug'], $allowed_plugins)) {
        unset($links['install']);
    }

    return $links;
}
add_filter('plugin_install_action_links', 'apc_disable_install_button', 10, 2);
```

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

