<?php
/**
* @package     Tag Groups
* @author      Christoph Amthor
* @copyright   2018 Christoph Amthor (@ Chatty Mango, chattymango.com)
* @license     GPL-3.0+
*/

if ( ! class_exists('TagGroups_Base') ) {

  /**
  *
  */
  class TagGroups_Base {


    /**
    * Returns the first element of an array without changing the original array
    *
    * @param array $array
    * @return mixed
    */
    public static function get_first_element( $array = array() )
    {

      if ( ! is_array( $array ) ) {

        return;

      }

      return reset( $array );

    }


    /**
    * sanitizes many classes separated by space
    *
    * @param string $classes
    * @return string
    */
    public static function sanitize_html_classes( $classes ){

      // replace multiple spaces by one
      $classes = preg_replace( '!\s+!', ' ', $classes );

      // turn into array
      $classes = explode( ' ', $classes );

      if( ! empty( $classes ) ) {

        $classes = array_map( 'sanitize_html_class', $classes );

      }

      // turn back
      $classes = implode( ' ', $classes );

      return $classes;

    }


    /**
    * Change the time until the first trial encouragement appears
    *
    * @param int $sec Default is 24 hours.
    * @return int
    * @since 1.19.1
    */
    public static function change_time_show_first_trial( $sec ) {

      // 7 days in sec.
      return 7 * 24 * 60 * 60;

    }


    /**
    * Change the time between trial encouragements
    *
    * @param int $sec Default is 30 days.
    * @return int
    * @since 1.19.1
    */
    public static function change_time_reshow_trial( $sec ) {

      // 60 days in sec.
      return 60 * 24 * 60 * 60;

    }


    /**
    * Show Freemius admin notice of trial promotion only in Tag Groups own settings or Tag Groups Admin page
    * "page" parameter starts with tag-groups-settings or is tag-groups_{post_type}
    *
    * @param mixed $show
    * @param array $msg
    * @return boolean
    * @since 1.19.2
    */
    public static function change_show_admin_notice( $show, $msg ) {

      if (
        'trial_promotion' == $msg['id']
        && ( empty( $_GET['page'] ) || strpos( $_GET['page'], 'tag-groups' ) !== 0 )
      ) {

        // Don't show the trial promotional admin notice.
        return false;

      }

      return true;

    }


    /**
    * Clear the cache of various plugins
    *
    * @param void
    * @return void
    */
    public static function clear_cache()
    {

      if ( function_exists( 'flush_pgcache' ) ) {

        flush_pgcache;

      }

      if ( function_exists( 'flush_minify' ) ) {

        flush_minify;

      }

      if ( function_exists( 'wp_cache_clear_cache' ) ) {

        wp_cache_clear_cache();

      }

    }

  } // class

}
