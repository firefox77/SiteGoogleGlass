<?php

/**
*
* Plugin Name: Tag Groups
* Plugin URI: https://chattymango.com/tag-groups/
* Description: Organize your tags in groups and display them in highly customizable tag clouds (tabs, accordion and more).
* Author: Chatty Mango
* Author URI: https://chattymango.com/
* Version: 1.22.0
* License: GNU GENERAL PUBLIC LICENSE, Version 3
* Text Domain: tag-groups
* Domain Path: /languages
*/
// keep the following line for automatic processing
// define( "CM_TGP_KERNL_UUID", '' );
// Don't call this file directly
if ( !defined( 'ABSPATH' ) ) {
    die;
}

if ( function_exists( 'tag_groups_premium_fs_sdk' ) ) {
    tag_groups_premium_fs_sdk()->set_basename( false, __FILE__ );
    return;
}

if ( !defined( 'TAG_GROUPS_PLUGIN_IS_FREE' ) ) {
    
    if ( plugin_basename( __FILE__ ) == 'tag-groups/tag-groups.php' ) {
        define( 'TAG_GROUPS_PLUGIN_IS_FREE', true );
    } else {
        // Don't define the constant! If the premium plugin runs earlier, the free plugin still needs a chance to define it.
    }

}
if ( !defined( 'TAG_GROUPS_PLUGIN_IS_KERNL' ) ) {
    
    if ( defined( 'CM_TGP_KERNL_UUID' ) && CM_TGP_KERNL_UUID != '' || defined( 'CM_TGP_BETA_PLUGIN_UUID' ) && CM_TGP_BETA_PLUGIN_UUID != '' ) {
        define( 'TAG_GROUPS_PLUGIN_IS_KERNL', true );
    } else {
        define( 'TAG_GROUPS_PLUGIN_IS_KERNL', false );
    }

}

if ( !defined( 'TAG_GROUPS_PLUGIN_BASENAME' ) ) {
    /**
     * The plugin's relative path (starting below the plugin directory), including the name of this file.
     */
    define( "TAG_GROUPS_PLUGIN_BASENAME", plugin_basename( __FILE__ ) );
    /**
     * The required minimum version of WordPress.
     */
    define( "TAG_GROUPS_MINIMUM_VERSION_WP", "4.0" );
    /**
     * Comma-separated list of default themes that come bundled with this plugin.
     */
    define( "TAG_GROUPS_BUILT_IN_THEMES", "ui-gray,ui-lightness,ui-darkness,blitzer,aristo" );
    /**
     * The theme that is selected by default. Must be among TAG_GROUPS_BUILT_IN_THEMES.
     */
    define( "TAG_GROUPS_STANDARD_THEME", "ui-gray" );
    /**
     * The default number of groups on one page on the edit group screen.
     */
    define( "TAG_GROUPS_ITEMS_PER_PAGE", 20 );
    /**
     * This plugin's last piece of the path, i.e. basically the plugin's name
     */
    define( "TAG_GROUPS_PLUGIN_RELATIVE_PATH", basename( dirname( __FILE__ ) ) );
    /**
     * This plugin's absolute path on this server - starting from root.
     */
    define( "TAG_GROUPS_PLUGIN_ABSOLUTE_PATH", dirname( __FILE__ ) );
    /**
     * The path to the premium plugin main file.
     * Codester-default was tag-groups-premium.php, Freemium-generated is tag-groups.php
     */
    // use: WP_PLUGIN_DIR . '/' . TAG_GROUPS_PLUGIN_BASENAME
    /**
     * The full URL (including protocol) of the RSS channel that informas about updates.
     */
    define( "TAG_GROUPS_UPDATES_RSS_URL", "https://chattymango.com/category/updates/tag-groups-free/feed/" );
}

/**
* Make scope of $tag_groups_loader global for wp-cli
*/
global  $tag_groups_loader ;
require_once dirname( __FILE__ ) . '/include/class.loader.php';
$tag_groups_loader = new TagGroups_Loader( TAG_GROUPS_PLUGIN_ABSOLUTE_PATH );
$tag_groups_loader->require_classes();
// Load the Freemius SDK only if we don't have the Kernl update SDK

if ( !TAG_GROUPS_PLUGIN_IS_KERNL && !function_exists( 'tag_groups_premium_fs_sdk' ) ) {
    // Create a helper function for easy SDK access.
    function tag_groups_premium_fs_sdk()
    {
        global  $tag_groups_premium_fs_sdk ;
        
        if ( !isset( $tag_groups_premium_fs_sdk ) ) {
            // Include Freemius SDK.
            require_once dirname( __FILE__ ) . '/vendor/freemius/start.php';
            $tag_groups_premium_fs_sdk = fs_dynamic_init( array(
                'id'             => '3545',
                'slug'           => 'tag-groups',
                'type'           => 'plugin',
                'public_key'     => 'pk_de9caa44b85150adcf7406ad2e895',
                'is_premium'     => false,
                'has_addons'     => false,
                'has_paid_plans' => true,
                'trial'          => array(
                'days'               => 7,
                'is_require_payment' => true,
            ),
                'menu'           => array(
                'slug'       => 'tag-groups-settings',
                'first-path' => 'admin.php?page=tag-groups-settings-first-steps',
                'contact' => false,
            ),
                'is_live'        => true,
            ) );
        }
        
        return $tag_groups_premium_fs_sdk;
    }
    
    // Init Freemius.
    tag_groups_premium_fs_sdk();
    // Signal that SDK was initiated.
    do_action( 'tag_groups_premium_fs_sdk_loaded' );
    global  $tag_groups_premium_fs_sdk ;
    $tag_groups_premium_fs_sdk->add_filter( 'show_first_trial_after_n_sec', array( 'TagGroups_Base', 'change_time_show_first_trial' ) );
    $tag_groups_premium_fs_sdk->add_filter( 'reshow_trial_after_every_n_sec', array( 'TagGroups_Base', 'change_time_reshow_trial' ) );
    $tag_groups_premium_fs_sdk->add_filter(
        'show_admin_notice',
        array( 'TagGroups_Base', 'change_show_admin_notice' ),
        10,
        2
    );
    if ( !TAG_GROUPS_PLUGIN_IS_KERNL ) {
        $tag_groups_premium_fs_sdk->add_action( 'after_uninstall', array( 'TagGroups_Activation_Deactivation', 'on_uninstall' ) );
    }
} else {
    global  $tag_groups_premium_fs_sdk ;
    if ( empty($tag_groups_premium_fs_sdk) ) {
        $tag_groups_premium_fs_sdk = new FS_SDK_Kernl();
    }
}


if ( !function_exists( 'tag_groups_init' ) ) {
    /**
     * Do all initial stuff: register hooks, check dependencies
     *
     *
     * @param void
     * @return void
     */
    function tag_groups_init()
    {
        global  $tag_groups_premium_fs_sdk, $tag_groups_loader ;
        // global $tagGroups_Base_instance;
        if ( plugin_basename( __FILE__ ) != 'tag-groups/tag-groups.php' ) {
            // TGP-Codester or TGP-Freemius
            
            if ( defined( 'TAG_GROUPS_PLUGIN_IS_FREE' ) && TAG_GROUPS_PLUGIN_IS_FREE ) {
                /**
                 * The free version is also active.
                 */
                /**
                 * Make sure we don't delete data by removing the base plugin by returning data removal to opt-in:
                 * Set the option to OFF and keep, because removing the plugin might only happen later.
                 */
                update_option( 'tag_group_reset_when_uninstall', 0 );
                require_once ABSPATH . 'wp-admin/includes/plugin.php';
                deactivate_plugins( 'tag-groups/tag-groups.php', true );
                // add the hook directly
                add_action( 'admin_notices', function () {
                    echo  '<div class="notice notice-info is-dismissible"><p>' . __( 'The free Tag Groups plugin cannot be active together with Tag Groups Premium.', 'tag-groups' ) . ' <a href="https://documentation.chattymango.com/documentation/tag-groups-premium/messages/the-free-tag-groups-plugin-cannot-be-active-together-with-this-version-of-tag-groups-premium/" target="_blank" style="text-decoration: none;" title="' . __( 'more information', 'tag-groups' ) . '"><span class="dashicons dashicons-editor-help"></span></a></p></div><div clear="all" /></div>' ;
                } );
                /**
                 * Remove the misleading "Plugin activated" messaage
                 */
                unset( $_GET['activate'] );
            }
        
        }
        // URL must be defined after WP has finished loading its settings
        
        if ( !defined( 'TAG_GROUPS_PLUGIN_URL' ) ) {
            define( "TAG_GROUPS_PLUGIN_URL", plugins_url( '', __FILE__ ) );
            // start all initializations, registration of hooks, housekeeping, menus, ...
            $tag_groups_loader->set_version();
            $tag_groups_loader->check_preconditions();
            $tag_groups_loader->provide_globals();
            $tag_groups_loader->add_hooks();
            $tag_groups_loader->register_shortcodes_and_blocks();
            $tag_groups_loader->register_REST_API();
        }
    
    }
    
    add_action( 'plugins_loaded', 'tag_groups_init' );
    register_activation_hook( __FILE__, array( $tag_groups_loader, 'on_activation' ) );
}

if ( !function_exists( 'tag_groups_cloud' ) && class_exists( 'TagGroups_Shortcode_Tabs' ) ) {
    /**
     *
     * Wrapper for the static method tag_groups_cloud
     *
     * @param array $atts
     * @param bool $return_array
     * @return string
     */
    function tag_groups_cloud( $atts = array(), $return_array = false )
    {
        return TagGroups_Shortcode_Tabs::tag_groups_cloud( $atts, $return_array );
    }

}
if ( !function_exists( 'tag_groups_accordion' ) && class_exists( 'TagGroups_Shortcode_Accordion' ) ) {
    /**
     *
     * Wrapper for the static method tag_groups_accordion
     *
     * @param array $atts
     * @return string
     */
    function tag_groups_accordion( $atts = array() )
    {
        return TagGroups_Shortcode_Accordion::tag_groups_accordion( $atts );
    }

}
if ( !function_exists( 'post_in_tag_group' ) ) {
    /**
     * Checks if the post with $post_id has a tag that is in the tag group with $tag_group_id.
     *
     * @param int $post_id
     * @param int $tag_group_id
     * @return boolean
     */
    function post_in_tag_group( $post_id, $tag_group_id )
    {
        global  $tag_groups_premium_fs_sdk ;
        
        if ( class_exists( 'TagGroups_Premium_Post' ) ) {
        } else {
            $tag_group_taxonomy = TagGroups_Taxonomy::get_enabled_taxonomies();
            $tags = get_the_terms( $post_id, $tag_group_taxonomy );
            if ( $tags ) {
                foreach ( $tags as $tag ) {
                    if ( $tag->term_group == $tag_group_id ) {
                        return true;
                    }
                }
            }
            return false;
        }
    
    }

}
/**
* guess what - the end
*/