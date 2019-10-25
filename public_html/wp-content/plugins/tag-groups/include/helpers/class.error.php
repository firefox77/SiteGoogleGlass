<?php
/**
* @package     Tag Groups
* @author      Christoph Amthor
* @copyright   2019 Christoph Amthor (@ Chatty Mango, chattymango.com)
* @license     GPL-3.0+
*/

if ( ! class_exists( 'ChattyMango_Error' ) ) {

  /**
  * Error processing
  *
  */
  class ChattyMango_Error {

    /**
    * binary values for bitmasks
    */
    const INFO = 1;
    const WARNING = 2;
    const ERROR = 4;

    private $reporting_level = ChattyMango_Error::INFO;


    public static function init() {

      return new ChattyMango_Error();

    }

    /**
    * setter for $this->reporting_level
    *
    * @param integer $level
    * @return object $this
    */
    public function set_reporting_level( $reporting_level )
    {

      $this->reporting_level = $reporting_level;

      return $this;

    }

    /**
    * getter for $this->reporting_level
    *
    * @param void
    * @return integer
    */
    public function get_reporting_level()
    {

      return $this->reporting_level;

    }


    /**
    * Dumps a message to the error log or on the screen
    *
    * @param string $source
    * @param mixed $message
    * @param boolean $add_trace
    * @param integer $severity
    * @return boolean
    */
    public function dump( $source = '', $message = '', $add_trace = false, $severity = ChattyMango_Error::INFO )
    {

      if ( $severity < $this->reporting_level ) {

        return false;

      }

      if ( defined( 'WP_DEBUG' ) && WP_DEBUG && ! wp_doing_ajax() ) {

        if ( ! empty( $source ) ) {

          echo '[' . $source . ']' . "<br/>\n";

        }

        echo '<pre>';

        if ( is_string( $message ) ) {

          echo $message;

        } else {

          var_dump( $message );

        }

        echo '</pre>';

        if ( $add_trace ) {

          echo 'backtrace';

          echo '<pre>';

          echo nl2br( self::get_backtrace() );

          echo '</pre>';

        }

        echo '</pre>';

        return true;

      } else {

        return $this->log( $source, $message, $add_trace, $severity );

      }

    }

    /**
    * Dumps a message to the error log or on the screen
    *
    * @param string $source
    * @param mixed $message
    * @param boolean $add_trace
    * @param integer $severity
    * @return boolean
    */
    public function dump_and_die( $source = '', $message = '', $add_trace = false, $severity = ChattyMango_Error::INFO )
    {

      $this->dump( $source, $message, $add_trace, $severity );

      die();

    }


    /**
    * Logs a message do debug.log
    *
    * @param string $source
    * @param mixed $message
    * @param boolean $add_trace
    * @param integer $severity
    * @return boolean
    */
    public function log( $source = '', $message = '', $add_trace = false, $severity = ChattyMango_Error::INFO )
    {

      if ( $severity < $this->reporting_level ) {

        return false;

      }

      $log = '';

      if ( ! defined( 'WP_DEBUG' ) || ! WP_DEBUG ) {

        return false;

      }

      if ( ! empty( $source ) ) {

        $source = '[' . $source . '] ';

      }

      if ( is_string( $message ) ) {

        $log .= $source . $message;

      } else {

        ob_start();

        var_dump( $message );

        $caught_dump = ob_get_clean();

        $log .= $source . $caught_dump;

      }

      if ( $add_trace ) {

        $log .= "\nbacktrace:\n" . self::get_backtrace();

      }

      error_log( $log );

      return true;

    }


    /**
    * Creates a HTML presentation of the backtrace
    *
    * based on http://php.net/manual/en/function.debug-backtrace.php#112238
    *
    * @param void
    * @return string
    */
    public function get_backtrace()
    {

      $path = ABSPATH; //get_home_path();

      $e = new Exception();

      $trace = explode( "\n", $e->getTraceAsString() );

      // reverse array to make steps line up chronologically
      $trace = array_reverse($trace);

      array_shift( $trace ); // remove {main}

      array_pop( $trace ); // remove call to this method

      $length = count( $trace );

      $result = array();

      for ( $i = 0; $i < $length; $i++ ) {

        if ( strpos( $trace[$i], 'ChattyMango_Error::' ) !== false ) {

          continue;

        }

        // remove home path
        $output = str_replace( $path, '', substr( $trace[$i], strpos( $trace[$i], ' ' ) ) );

        $result[] = ($i + 1)  . ')' . $output;

      }

      return "\t" . implode( "\n\t", $result );

    }


  }

}
