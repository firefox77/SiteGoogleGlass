<?php
/**
* @package     Tag Groups
* @author      Christoph Amthor
* @copyright   2018 Christoph Amthor (@ Chatty Mango, chattymango.com)
* @license     GPL-3.0+
*/

if ( ! class_exists('TagGroups_Options') ) {

  /**
  *
  */
  class TagGroups_Options {

    const TAG_GROUPS_PLUGIN = 1;
    const TAG_GROUPS_PREMIUM_PLUGIN = 2;

    function __construct() {}

      /**
      * The list of all currently used options. Relevant for deleting, exporting and importing
      *
      * @param void
      * @return array
      */
      public function get_option_names() {

        $option_names = array();

        $option_names['tag_group_taxonomy'] = array( 'origin' => TagGroups_Options::TAG_GROUPS_PLUGIN, 'export' => true );
        $option_names['term_groups'] = array( 'origin' => TagGroups_Options::TAG_GROUPS_PLUGIN, 'export' => true );
        $option_names['term_group_positions'] = array( 'origin' => TagGroups_Options::TAG_GROUPS_PLUGIN, 'export' => true );
        $option_names['term_group_labels'] = array( 'origin' => TagGroups_Options::TAG_GROUPS_PLUGIN, 'export' => true );
        $option_names['tag_group_theme'] = array( 'origin' => TagGroups_Options::TAG_GROUPS_PLUGIN, 'export' => true );
        $option_names['tag_group_mouseover'] = array( 'origin' => TagGroups_Options::TAG_GROUPS_PLUGIN, 'export' => true );
        $option_names['tag_group_collapsible'] = array( 'origin' => TagGroups_Options::TAG_GROUPS_PLUGIN, 'export' => true );
        $option_names['tag_group_enqueue_jquery'] = array( 'origin' => TagGroups_Options::TAG_GROUPS_PLUGIN, 'export' => true );
        $option_names['tag_group_shortcode_widget'] = array( 'origin' => TagGroups_Options::TAG_GROUPS_PLUGIN, 'export' => true );
        $option_names['tag_group_show_filter'] = array( 'origin' => TagGroups_Options::TAG_GROUPS_PLUGIN, 'export' => true );
        $option_names['tag_group_show_filter_tags'] = array( 'origin' => TagGroups_Options::TAG_GROUPS_PLUGIN, 'export' => true );
        $option_names['tag_group_html_description'] = array( 'origin' => TagGroups_Options::TAG_GROUPS_PLUGIN, 'export' => true );
        $option_names['tag_group_admin_notice'] = array( 'origin' => TagGroups_Options::TAG_GROUPS_PLUGIN, 'export' => false );
        $option_names['chatty_mango_cache'] = array( 'origin' => TagGroups_Options::TAG_GROUPS_PLUGIN, 'export' => false );
        $option_names['tag_group_shortcode_enqueue_always'] = array( 'origin' => TagGroups_Options::TAG_GROUPS_PLUGIN, 'export' => true );
        $option_names['tag_group_tags_filter'] = array( 'origin' => TagGroups_Options::TAG_GROUPS_PLUGIN, 'export' => true );
        $option_names['tag_group_onboarding'] = array( 'origin' => TagGroups_Options::TAG_GROUPS_PLUGIN, 'export' => false );
        $option_names['tag_groups_per_page'] = array( 'origin' => TagGroups_Options::TAG_GROUPS_PLUGIN, 'export' => true );
        $option_names['tag_group_base_version'] = array( 'origin' => TagGroups_Options::TAG_GROUPS_PLUGIN, 'export' => true );
        $option_names['tag_group_base_first_activation_time'] = array( 'origin' => TagGroups_Options::TAG_GROUPS_PLUGIN, 'export' => true );
        $option_names['tag_group_group_languages'] = array( 'origin' => TagGroups_Options::TAG_GROUPS_PLUGIN, 'export' => true );
        $option_names['tag_group_sample_page_id'] = array( 'origin' => TagGroups_Options::TAG_GROUPS_PLUGIN, 'export' => false );

        /**
        * Deprecated after 0.36 - don't export
        */
        $option_names['tag_group_labels'] = array( 'origin' => TagGroups_Options::TAG_GROUPS_PLUGIN, 'export' => false );
        $option_names['tag_group_ids'] = array( 'origin' => TagGroups_Options::TAG_GROUPS_PLUGIN, 'export' => false );
        $option_names['max_tag_group_id'] = array( 'origin' => TagGroups_Options::TAG_GROUPS_PLUGIN, 'export' => false );

        /**
        * Options of the premium plugin; listed here so they survive uninstallation of premium plugin
        */
        $option_names['tag_group_meta_box_taxonomy'] = array( 'origin' => TagGroups_Options::TAG_GROUPS_PREMIUM_PLUGIN, 'export' => true );
        $option_names['tag_group_object_cache'] = array( 'origin' => TagGroups_Options::TAG_GROUPS_PREMIUM_PLUGIN, 'export' => true );
        $option_names['tag_group_meta_box_add_term'] = array( 'origin' => TagGroups_Options::TAG_GROUPS_PREMIUM_PLUGIN, 'export' => true );
        $option_names['tag_group_meta_box_change_group'] = array( 'origin' => TagGroups_Options::TAG_GROUPS_PREMIUM_PLUGIN, 'export' => true );
        $option_names['tag_group_role_edit_groups'] = array( 'origin' => TagGroups_Options::TAG_GROUPS_PREMIUM_PLUGIN, 'export' => true );
        $option_names['tag_group_open_all_with_terms'] = array( 'origin' => TagGroups_Options::TAG_GROUPS_PREMIUM_PLUGIN, 'export' => true );
        $option_names['tag_group_role_mb_override'] = array( 'origin' => TagGroups_Options::TAG_GROUPS_PREMIUM_PLUGIN, 'export' => true );
        $option_names['tag_group_hide_tagsdiv'] = array( 'origin' => TagGroups_Options::TAG_GROUPS_PREMIUM_PLUGIN, 'export' => true );
        $option_names['tag_group_latest_version'] = array( 'origin' => TagGroups_Options::TAG_GROUPS_PREMIUM_PLUGIN, 'export' => false );
        $option_names['tag_group_latest_version_url'] = array( 'origin' => TagGroups_Options::TAG_GROUPS_PREMIUM_PLUGIN, 'export' => false );
        $option_names['chatty_mango_packages'] = array( 'origin' => TagGroups_Options::TAG_GROUPS_PREMIUM_PLUGIN, 'export' => false );
        $option_names['tag_group_display_groups_under_posts'] = array( 'origin' => TagGroups_Options::TAG_GROUPS_PREMIUM_PLUGIN, 'export' => true );
        $option_names['tag_group_display_groups_under_posts_single'] = array( 'origin' => TagGroups_Options::TAG_GROUPS_PREMIUM_PLUGIN, 'export' => true );
        $option_names['tag_group_display_groups_under_posts_feed'] = array( 'origin' => TagGroups_Options::TAG_GROUPS_PREMIUM_PLUGIN, 'export' => true );
        $option_names['tag_group_display_groups_under_posts_home'] = array( 'origin' => TagGroups_Options::TAG_GROUPS_PREMIUM_PLUGIN, 'export' => true );
        $option_names['tag_group_display_groups_under_posts_archive'] = array( 'origin' => TagGroups_Options::TAG_GROUPS_PREMIUM_PLUGIN, 'export' => true );
        $option_names['tag_group_remove_the_post_terms'] = array( 'origin' => TagGroups_Options::TAG_GROUPS_PREMIUM_PLUGIN, 'export' => true );
        $option_names['tag_group_display_groups_under_posts_title'] = array( 'origin' => TagGroups_Options::TAG_GROUPS_PREMIUM_PLUGIN, 'export' => true );
        $option_names['tag_group_display_groups_under_posts_priority'] = array( 'origin' => TagGroups_Options::TAG_GROUPS_PREMIUM_PLUGIN, 'export' => true );
        $option_names['tag_group_premium_version'] = array( 'origin' => TagGroups_Options::TAG_GROUPS_PREMIUM_PLUGIN, 'export' => true );
        $option_names['tag_group_premium_first_activation_time'] = array( 'origin' => TagGroups_Options::TAG_GROUPS_PREMIUM_PLUGIN, 'export' => true );
        $option_names['tag_group_display_groups_under_posts_separator'] = array( 'origin' => TagGroups_Options::TAG_GROUPS_PREMIUM_PLUGIN, 'export' => true );
        $option_names['tag_group_dpf_template'] = array( 'origin' => TagGroups_Options::TAG_GROUPS_PREMIUM_PLUGIN, 'export' => true );
        $option_names['tag_group_add_product_tags_to_attributes'] = array( 'origin' => TagGroups_Options::TAG_GROUPS_PREMIUM_PLUGIN, 'export' => true );
        $option_names['tag_group_display_groups_under_products_separator'] = array( 'origin' => TagGroups_Options::TAG_GROUPS_PREMIUM_PLUGIN, 'export' => true );
        $option_names['tag_group_remove_the_product_tags'] = array( 'origin' => TagGroups_Options::TAG_GROUPS_PREMIUM_PLUGIN, 'export' => true );
        $option_names['tag_group_role_edit_tags'] = array( 'origin' => TagGroups_Options::TAG_GROUPS_PREMIUM_PLUGIN, 'export' => true );
        $option_names['tag_group_meta_box_include'] = array( 'origin' => TagGroups_Options::TAG_GROUPS_PREMIUM_PLUGIN, 'export' => true );
        $option_names['tag_group_meta_box_open_all'] = array( 'origin' => TagGroups_Options::TAG_GROUPS_PREMIUM_PLUGIN, 'export' => true );

        // should be last:
        $option_names['tag_group_reset_when_uninstall'] = array( 'origin' => TagGroups_Options::TAG_GROUPS_PLUGIN, 'export' => true );

        return $option_names;
      }

    }

  }
