<?php
/**
* Chatty Mango Cache
*
* @package     Chatty Mango Cache
* @author      Christoph Amthor, https://chattymango.com
* @copyright   2017 Christoph Amthor
* @license     GPL-2.0+
* @version     1.2.4
*
*
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
* OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
* THE SOFTWARE.
*
*/

if ( ! class_exists('ChattyMango_Cache') ) {

  class ChattyMango_Cache {

    const VERSION = "1.2.4";

    // options where to save the data (preparations for future development)
    const OFF = 0;
    const WP_OPTIONS = 1; // WordPress option framework
    const DATABASE = 2;
    const FILE = 3;
    const OTHER = 9;

    private $key; // Identifier for cache entry.

    // Adjust the default type in future version according to best available option:
    private $type = 1; // Location where to save the cache.

    private $lifetime = 21600; // Cache lifetime in seconds; default 6 hours

    private $serve_old_cache = false; // If cache is outdated, still serve old cache before purging?

    private $path; // absolute path where to store cache files, if $type == ChattyMango_Cache::FILE

    public $error = 0; // last error
    /**
    *       0: no error
    *       1: dependencies not met
    *       2: path not available
    *       3: path not writable
    *       4: unknown type
    *       5: error reading file
    *       6: error writing file
    *       7: bad key
    */

    public $expired = false; // true if the requested cache is expired

    public function __construct() {}

      /**
      * @deprecated since 0.32, left for backwards-compatibility
      *
      * @var void
      * @return opject $this
      */
      static function init() {

        $instance = new ChattyMango_Cache();

        return $instance;

      }

      /**
      * get the version
      *
      * @var void
      * @return string
      */
      static function version() {

        return VERSION;

      }


      /**
      * Sets the key to identify the cache
      *
      * @param mixed $key
      * @return object $this
      */
      public function key( $key ) {

        if ( empty( $key ) ) {

          $this->error = 7;

          $key = '';

        }

        if ( ! is_string( $key ) ) {

          $key = serialize( $key );

        }

        $this->key = md5( $key );


        return $this;

      }


      /**
      * Sets the type of the cache
      *
      * @param int $type
      * @return object $this
      */
      public function type( $type = ChattyMango_Cache::WP_OPTIONS ) {

        // check if dpendencies are met
        if ( ChattyMango_Cache::WP_OPTIONS == $type && !function_exists( 'get_option' ) ) {

          $type = 0;

          $this->error = 1;

        }

        $this->type = $type;

        return $this;

      }


      /**
      * Sets the (absolute) path to the cache files
      *
      * @param string $path Defaults to a cache directory under the current directory.
      * @return object $this
      */
      public function path( $path = './cache/' ) {

        // add a trailing slash
        $path .= ( substr( $path, -1 ) == '/' ? '' : '/' );

        if ( ! is_dir( $path ) ) {

          // try to create the path
          // permissions: all for owner, read + write for group, nothing for everybody else
          if ( mkdir( $path, 0760, true ) ) {

            $this->path = $path;

          } else {

            $this->error = 2;

            $this->type = 0;

          }

        } elseif ( !is_writable( $path ) ) {

          $this->error = 3;

          $this->type = 0;

        } else {

          $this->path = $path;

        }

        return $this;

      }


      /**
      * Sets whether to serve invalidated cache before purging it
      *
      * @param bool $yes
      * @return object $this
      */
      public function serve_old_cache( $yes = false ) {

        $this->serve_old_cache = $yes;

        return $this;

      }


      /**
      * Sets the lifetime of the cache
      *
      * @param int $seconds Cache invalidated this time after being set.
      * @return object $this
      */
      public function lifetime( $seconds ) {

        $this->lifetime = $seconds;

        return $this;

      }


      /**
      * Getter for the data
      *
      * @return mixed
      */
      public function get() {

        switch ( $this->type ) {

          case ChattyMango_Cache::WP_OPTIONS:

          return $this->get_from_wp_options();

          break;


          case ChattyMango_Cache::FILE:

          return $this->get_from_files();

          break;


          case ChattyMango_Cache::OTHER:

          return wp_cache_get( $this->key );

          break;


          default;

          $this->error = 4;

          return false;

          break;

        }

      }


      /**
      * Setter for the data
      *
      * @param mixed $data
      * @return bool success?
      */
      public function set( $data = null ) {

        switch ( $this->type ) {

          case ChattyMango_Cache::WP_OPTIONS:

          return $this->set_to_wp_options( $data );

          break;


          case ChattyMango_Cache::FILE:

          return $this->set_to_files( $data );

          break;


          case ChattyMango_Cache::OTHER:

          return wp_cache_set( $this->key, $data, $this->lifetime );

          break;


          default;

          $this->error = 4;

          return false;

          break;

        }

      }


      /**
      * Purge all overdue entries.
      *
      * @param void
      * @return object $this
      */
      public function purge() {

        switch ( $this->type ) {

          case ChattyMango_Cache::WP_OPTIONS:

          return $this->purge_from_wp_options();

          break;


          case ChattyMango_Cache::FILE:

          return $this->purge_from_files();

          break;


          case ChattyMango_Cache::OTHER:

          return wp_cache_delete( $this->key );

          break;


          default;

          $this->error = 4;

          return false;

          break;

        }

      }


      /**
      * Purge the entire cache.
      *
      * @param void
      * @return object $this
      */
      public function purge_all() {

        switch ( $this->type ) {

          case ChattyMango_Cache::WP_OPTIONS:

          return $this->purge_all_from_wp_options();

          break;


          case ChattyMango_Cache::FILE:

          return $this->purge_all_from_files();

          break;


          case ChattyMango_Cache::OTHER:

          return wp_cache_flush();

          break;


          default;

          $this->error = 4;

          return false;

          break;

        }

      }


      ##############################
      #         ChattyMango_Cache::WP_OPTIONS
      ##############################

      /**
      * Getter for use with native ChattyMango_Cache::WP_OPTIONS - simple but maybe not useful for big amounts of data
      *
      * @param void
      * @return mixed
      */
      private function get_from_wp_options() {

        $cache = get_option( 'chatty_mango_cache', array() );

        if ( isset( $cache[ $this->key ] ) ) {

          if ( time() > $cache[ $this->key ]['time'] ) {

            $this->expired = true;

            if ( $this->serve_old_cache ) {

              $previous_cache = $cache[ $this->key ]['data'];

              // cache is expired: delete from cache
              unset( $cache[ $this->key ] );

              update_option( 'chatty_mango_cache', $cache );

              return $previous_cache;

            } else {

              // cache is expired: delete from cache
              unset( $cache[ $this->key ] );

              update_option( 'chatty_mango_cache', $cache );

              return false;

            }

          } else {

            return $cache[ $this->key ]['data'];

          }

        }

        return false;

      }


      /**
      * Setter for use with native ChattyMango_Cache::WP_OPTIONS - simple but maybe not useful for big amounts of data
      *
      * @param mixed $data
      * @return bool success?
      */
      private function set_to_wp_options( $data ) {

        $cache = get_option( 'chatty_mango_cache', array() );

        // update the cache
        $cache[ $this->key ]['data'] = $data;

        $cache[ $this->key ]['time'] = time() + $this->lifetime;

        update_option( 'chatty_mango_cache', $cache );

        return true;

      }


      /**
      * Purges invalidated cache entries (not only for $this->key)
      *
      * @param void
      * @return object $this
      */
      private function purge_from_wp_options() {

        $cache = get_option( 'chatty_mango_cache', array() );

        foreach ( $cache as $key => $value ) {

          if ( time() > $cache[ $key ]['time'] ) {

            // cache is expired: delete from cache
            unset( $cache[ $key ] );

          }

        }

        update_option( 'chatty_mango_cache', $cache );

        return $this;

      }


      /**
      * Purges all cache
      *
      * @param void
      * @return object $this
      */
      private function purge_all_from_wp_options() {

        update_option( 'chatty_mango_cache', array() );

        return $this;

      }


      ##############################
      #         ChattyMango_Cache::FILE
      #
      # file pattern: key as md5, dash, timestamp, dot, php
      ##############################

      /**
      * Getter for use with ChattyMango_Cache::FILE
      *
      * @param void
      * @return mixed
      */
      private function get_from_files() {

        if ( !empty( $this->path ) ) {

          foreach ( new RecursiveIteratorIterator( new RecursiveDirectoryIterator( $this->path ) ) as $file) {

            // filter out "." and ".."
            if ($file->isDir()) continue;

            $filename = $file->getBasename();

            preg_match( '/(' . $this->key  . ')-(\d+)/', $filename, $matches );

            if ( isset( $matches[1]) && $this->key == $matches[1] ) {

              if ( isset( $matches[2] ) ) {

                // check if entry is still valid
                if ( time() > (int) $matches[2] ) {

                  // cache is expired

                  $this->expired = true;

                  if ( !$this->serve_old_cache ) {

                    // delete from cache
                    @unlink( $file->getPathname() );

                    return false;

                  }

                }

                $file_contents = @file_get_contents( $file->getPathname() );

                if ( $file_contents === false ) {

                  $this->error = 5;

                  return false;

                }

                // remove the initial exit
                $file_contents = str_replace( '<?php exit; ?>', '', $file_contents );

                $cache = json_decode( $file_contents, true );

                if ( $this->expired ) {

                  // delete from cache
                  @unlink( $file->getPathname() );

                }

                return $cache;

              }

            }

          }

        }

        return false;

      }


      /**
      * Getter for use with ChattyMango_Cache::FILE - simple but maybe not useful for big amounts of data
      *
      * @param mixed $data
      * @return bool success?
      */
      private function set_to_files( $data ) {

        $filename = $this->path . $this->key . '-' . (string) ( time() + $this->lifetime ) . '.php';

        $file_contents = '<?php exit; ?>' . json_encode( $data );

        if ( !@file_put_contents( $filename, $file_contents, LOCK_EX ) ) {

          $this->error = 6;

          return false;

        }

        return true;

      }


      /**
      * Purges invalidated cache entries (not only for $this->key)
      *
      * @param void
      * @return object $this
      */
      private function purge_from_files() {

        if ( !empty( $this->path ) ) {

          foreach ( new RecursiveIteratorIterator( new RecursiveDirectoryIterator( $this->path ) ) as $file) {

            // filter out "." and ".."
            if ($file->isDir()) continue;

            $filename = $file->getBasename();

            preg_match( '/(' . $this->key . ')-(\d+)/', $filename, $matches );

            if ( isset( $matches[0] ) ) {

              // check if entry is still valid
              if ( time() > (int) $matches[0] ) {

                // cache is expired: delete from cache
                @unlink( $file->getPathname() );

              }

            }

          }

        }

        return $this;

      }


      /**
      * Purges all cache
      *
      * @param void
      * @return object $this
      */
      private function purge_all_from_files() {

        if ( !empty( $this->path ) ) {

          foreach ( new RecursiveIteratorIterator( new RecursiveDirectoryIterator( $this->path ) ) as $file) {

            // filter out "." and ".."
            if ($file->isDir()) continue;

            $filename = $file->getBasename();

            @unlink( $file->getPathname() );

          }

        }

        return $this;

      }

    } // class

  }
