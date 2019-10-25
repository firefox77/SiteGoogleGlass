<?php
/**
* @package     Tag Groups
* @author      Christoph Amthor
* @copyright   2019 Christoph Amthor (@ Chatty Mango, chattymango.com)
* @license     GPL-3.0+
*/

if ( ! class_exists('TagGroups_Activation_Deactivation') ) {

  /**
  *
  */
  class TagGroups_Activation_Deactivation {


    /**
    * This script is executed when the (inactive) plugin is deleted through the admin backend.
    *
    *It removes the plugin settings from the option table and all tag groups. It does not change the term_group field of the taxonomies.
    */
    public static function on_uninstall() {

      if ( ! current_user_can( 'activate_plugins' ) ) {

        if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {

          error_log( '[Tag Groups] Insufficient permissions to uninstall plugin.' );

        }

        return;

      }

      // Referrer is wrong when triggered via Freemius
      // check_admin_referer( 'bulk-plugins' );

      /**
      * Delete options only if requested
      */
      // Note: WP_UNINSTALL_PLUGIN is not defined when using the deinstallation hook

      if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {

        error_log( '[Tag Groups] Starting uninstall routine.' );

      }

      /**
      * Purge cache
      */
      if ( file_exists( dirname( __FILE__ ) . '/class.cache.php' ) ) {

        require_once dirname( __FILE__ ) . '/class.cache.php';

        if ( class_exists( 'ChattyMango_Cache' ) ) {
          $cache = new ChattyMango_Cache();
          $cache
          ->type( get_option( 'tag_group_object_cache', ChattyMango_Cache::WP_OPTIONS ) )
          ->path( WP_CONTENT_DIR . '/chatty-mango/cache/' )
          ->purge_all();
        }

      }

      $tag_group_reset_when_uninstall = get_option( 'tag_group_reset_when_uninstall', 0 );

      $option_count = 0;

      if ( $tag_group_reset_when_uninstall && file_exists( dirname( __FILE__ ) . '/class.options.php' ) ) {

        require_once dirname( __FILE__ ) . '/class.options.php';

        $tagGroups_options = new TagGroups_Options();

        $option_names = $tagGroups_options->get_option_names();

        if ( isset( $option_names[ 'tag_group_group_languages' ] ) ) {

          foreach ( $option_names[ 'tag_group_group_languages' ] as $language ) {

            if ( delete_option( 'term_group_labels_' . $language ) ) {

              $option_count++;

            }

          }

        }

        foreach ( $option_names as $key => $value ) {

          if ( delete_option( $key ) ) {

            $option_count++;

          }

        }

        if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {

          error_log( sprintf( '[Tag Groups] %d options deleted.', $option_count ) );

        }

      }


      /**
      * Erase /chatty-mango/cache/ directory
      */
      if ( file_exists( WP_CONTENT_DIR . '/chatty-mango/cache' ) && is_dir( WP_CONTENT_DIR . '/chatty-mango/cache' ) ) {
        /**
        * Attempt to empty and remove chatty-mango/cache directory
        * (Different from purging cache because the previous one can be database.)
        */
        foreach ( new RecursiveIteratorIterator( new RecursiveDirectoryIterator( WP_CONTENT_DIR . '/chatty-mango/cache/' ) ) as $file) {

          // filter out "." and ".."
          if ( $file->isDir() ) continue;

          @unlink( $file->getPathname() );

        }

        @rmdir( WP_CONTENT_DIR . '/chatty-mango/cache' );

      }

      /**
      * Remove transients
      *
      * Don't call the method clear_term_cache since we don't know if it is still available.
      */
      if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {

        error_log( '[Tag Groups] Removing transients.' );

      }

      global $wpdb;

      $transients = $wpdb->get_col(
        "
        SELECT REPLACE(option_name, '_transient_', '') AS transient_name
        FROM {$wpdb->options}
        WHERE option_name LIKE '_transient_tag_groups_%'
        "
      );

      foreach( $transients as $transient ) {

        delete_transient( $transient );

        if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {

          error_log( sprintf( '[Tag Groups Premium] Deleted the transient %s.', $transient ) );

        }

      }

      /**
      * Remove regular crons
      */
      wp_clear_scheduled_hook( 'tag_groups_purge_expired_transients' );


      if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {

        error_log( '[Tag Groups] Finished uninstall routine.' );

      }

    }

  }

}
