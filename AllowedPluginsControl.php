<?php
/*
Plugin Name: Allowed Plugins Control
Description: Restricts plugin installation to a predefined list and hides this plugin from the Plugins page.
Version: 1.0
Author: Lungdsuo Mozhui
*/


function apc_get_allowed_plugins() {
    return [
        'akismet', 
        'classic-editor',
        'AllowedPluginsControl', 
        'laravel-dd'
        
    ];
}


function apc_restrict_plugin_installation($install_result, $slug) {
    $allowed_plugins = apc_get_allowed_plugins();

    if (!in_array($slug, $allowed_plugins)) {
        wp_die(
            __('You are not allowed to install this plugin.Please contact DITC for more information.', 'allowed-plugins-control'),
            __('Plugin Installation Restricted.Please contact DITC for more information', 'allowed-plugins-control'),
            ['response' => 403]
        );
    }

    return $install_result;
}
// add_filter('pre_install_plugin', 'apc_restrict_plugin_installation', 10, 2);

// Hide this plugin from the Plugins page
function apc_hide_self_plugin($plugins) {
    // Specify the plugin file to hide (this plugin)
    $plugin_to_hide = plugin_basename(__FILE__);

    if (isset($plugins[$plugin_to_hide])) {
        unset($plugins[$plugin_to_hide]);
    }

    return $plugins;
}
add_filter('all_plugins', 'apc_hide_self_plugin');


function apc_disable_install_button($links, $plugin) {
    $allowed_plugins = apc_get_allowed_plugins();

    if (!empty($plugin['slug']) && !in_array($plugin['slug'], $allowed_plugins)) {
        
        $links['install'] = '<span style="color: #a00;">' . __('Not Allowed. Please contact DITC for more information', 'allowed-plugins-control') . '</span>';
        unset($links['0']);
        unset($links['1']);
    }
    

    return $links;
}
add_filter('plugin_install_action_links', 'apc_disable_install_button', 10, 2);
function apc_block_plugin_activation($plugin, $network_wide) {
    $allowed_plugins = apc_get_allowed_plugins();
    $plugin_slug = dirname($plugin);

    if (!in_array($plugin_slug, $allowed_plugins)) {
        deactivate_plugins($plugin);
        wp_die(
            __('You are not allowed to activate this plugin. Please contact DITC for more information', 'allowed-plugins-control'),
            __('Plugin Activation Restricted. Please contact DITC for more information', 'allowed-plugins-control'),
            ['response' => 403]
        );
    }
}
add_action('activate_plugin', 'apc_block_plugin_activation', 10, 2);