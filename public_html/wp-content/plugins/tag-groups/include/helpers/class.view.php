<?php
/**
* @package     Tag Groups
* @author      Christoph Amthor
* @copyright   2019 Christoph Amthor (@ Chatty Mango, chattymango.com)
* @license     GPL-3.0+
* @since
*/

if ( ! class_exists( 'TagGroups_View' ) ) {

  /**
  * General handling of views
  *
  * @since
  */
  class TagGroups_View {

    /**
    * full path of the file providing the view
    *
    * @var string
    * @since
    */
    private $view;

    /**
    * array of variables to be made available to the view (key is the variable name)
    *
    * @var array
    * @since
    */
    private $vars;


    /**
    * Constructor: checks if view exists
    *
    * @param string $view identifier of the view
    * @return object $this
    * @since
    */
    public function __construct( $view ) {

      $path = TAG_GROUPS_PLUGIN_ABSOLUTE_PATH . "/views/" . $view . ".view.php";

      if ( file_exists( $path ) ) {

        $this->view = $path;

      } else {

        ChattyMango_Error::init()->dump_and_die( 'tag groups', 'View ' . $path . ' not found' );

      }

      $this->vars = array();

      return $this;

    }


    /**
    * renders the view
    *
    * @param void
    * @return void
    */
    public function render()
    {

      extract( $this->vars, EXTR_SKIP );

      ob_start();

      include $this->view;

      $html = ob_get_clean();

      echo $this->do_filter( $html );

    }


    /**
    * returns the view
    *
    * @param void
    * @return string $html
    */
    public function return_html()
    {

      extract( $this->vars, EXTR_SKIP );

      ob_start();

      include $this->view;

      $html = ob_get_clean();

      return $this->do_filter( $html );

    }


    /**
     * Option to customize the output
     *
     * @param string $html
     * @return string
     */
    private function do_filter( $html )
    {

      $view_slug = str_replace( '/', '-', $this->view );

      return apply_filters( 'tag_groups_view_' . $view_slug, $html );

    }


    /**
    * General setter for $this->vars, accepting an array of key and values or one pair of key and value
    *
    *
    * @param array|string $variable_name_or_array
    * @param mixed@null $data
    * @return object $this
    */
    public function set( $variable_name_or_array, $data = null )
    {

      if ( is_string( $variable_name_or_array ) ) {

        $this->set_view_var( $variable_name_or_array, $data );

      } else if ( is_array( $variable_name_or_array ) ) {

        foreach ( $variable_name_or_array as $key => $value ) {

          $this->set_view_var( $key, $value );

        }

      }

      return $this;

    }


    /**
    * Setter for $this->vars
    *
    * @param string $key
    * @param mixed $value
    * @return void
    */
    private function set_view_var( $key, $value )
    {

      $this->vars[ $key ] = $value;

    }

  }

}
