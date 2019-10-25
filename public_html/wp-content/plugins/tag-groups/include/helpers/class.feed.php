<?php
/**
* @package     Tag Groups
* @author      Christoph Amthor
* @copyright   2018 Christoph Amthor (@ Chatty Mango, chattymango.com)
* @license     GPL-3.0+
*/

/*
Initial code from: https://bavotasan.com/2010/display-rss-feed-with-php/

#####################
# Typical workflow: #
#####################

$rss = new TagGroups_Feed();
$rss->debug(false);
$rss->url( 'https://...' );
$cache = $rss->cache_get();
if ($cache !== false) {
echo $cache;
} else {
echo $rss->load()->parse()->render();
}

*/

if ( ! class_exists('TagGroups_Feed') ) {

  class TagGroups_Feed {

    private $rss;

    private $url;

    private $posts_url;

    private $feed = array();

    private $cache;

    private $debug = false;

    private $limit = 5;

    public $expired = false;


    /**
    * instantiation of DOMDocument and ChattyMango_Cache
    *
    * @param void
    * @return void
    */
    public function __construct() {

      // experimental solution for "DOMDocument::load(): I/O warning : failed to load external entity" server errors
      libxml_disable_entity_loader( false );

      $this->rss = new DOMDocument();

      if ( class_exists( 'ChattyMango_Cache' ) ) {
        
        $this->cache = new ChattyMango_Cache();
        $this->cache
        ->type( get_option( 'tag_group_object_cache', ChattyMango_Cache::WP_OPTIONS ) )
        // ->path( WP_CONTENT_DIR . '/chatty-mango/cache/' )
        ->lifetime( 60 * 60 * 6 )
        ->serve_old_cache( true );

      }

    }


    /**
    * Turns debugging on.
    *
    * @param void
    * @return object $this
    */
    public function debug( $debug = true ) {

      $this->debug = $debug;

      return $this;

    }


    /**
    * Sets length of description
    *
    * @param int $limit
    * @return object $this
    */
    public function limit( $length ) {

      $this->limit = $length;

      return $this;

    }


    /**
    * sets the URL where we can find the feed
    *
    * @param string $url
    * @return object $this
    */
    public function url( $url ) {

      $this->url = $url;

      if ( isset( $this->cache ) ) {

        $this->cache->key( $url );

      }

      return $this;
    }


    /**
    * sets the URL where we can find the posts
    *
    * @param string $posts_url
    * @return object $this
    */
    public function posts_url( $posts_url ) {

      $this->posts_url = $posts_url;

      return $this;
    }


    /**
    * tries to read the rendered feed content from the cache, returns false if not possible
    *
    * @param void
    * @return bool|string
    */
    public function cache_get() {

      if ( isset( $this->cache ) ) {

        $data = $this->cache->get();

        $this->expired = $this->cache->expired;

        return $data;

      } else {

        return false;

      }

    }


    /**
    * saves rendered content to the cache
    *
    * @param string $data
    * @return bool success?
    */
    private function cache_set( $data ) {

      if ( isset( $this->cache ) ) {

        return $this->cache->set( $data );

      } else {

        return false;

      }

    }


    /**
    * purges data (of this feed) from the cache
    *
    * @param void
    * @return object $this
    */
    public function cache_purge() {

      if ( isset( $this->cache ) ) {

        return $this->cache->purge();

      } else {

        return false;

      }

    }



    /**
    * loads the content from the feed
    *
    * @param string $url
    * @return object $this
    */
    public function load() {

      $this->rss->load( $this->url );

      return $this;
    }


    /**
    * parses the feed data to retrieve items and relevant fields
    *
    * @param void
    * @return object $this
    */
    public function parse() {

      foreach ( $this->rss->getElementsByTagName('item') as $node ) {

        $item = array (
          'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
          'desc' => $node->getElementsByTagName('description')->item(0)->nodeValue,
          'link' => $node->getElementsByTagName('link')->item(0)->nodeValue,
          'date' => $node->getElementsByTagName('pubDate')->item(0)->nodeValue,
        );

        // multiple categories and tags
        $cats = $node->getElementsByTagName('category');

        $item['categories'] = array();

        for ( $i = 0; $i < $cats->length; $i++ ) {

          $item['categories'][] = $cats->item($i)->nodeValue;

        }

        array_push( $this->feed, $item );

      }

      return $this;

    }


    /**
    * Renders the feed to HTML
    *
    * @param int $limit maximum number of feed items
    * @param bool $return true: return output as string, false: echo output
    * @return string
    */
    public function render( $limit = 5, $return = true ) {

      $html = '';

      for( $x = 0; $x < $limit; $x++ ) {

        if ( isset( $this->feed[$x] ) ) {

          $title = str_replace(' & ', ' &amp; ', $this->feed[$x]['title']);

          $link = $this->feed[$x]['link'];

          $description = $this->truncate_string_at_word( $this->feed[$x]['desc'], $this->limit );

          $date = date('d F Y', strtotime($this->feed[$x]['date']));

          $html .= '<tr><th class="check-column" scope="row" style="padding:30px 10px 10px;"><em>'.$date.'</em>
          <p><small><b>' . implode( $this->feed[$x]['categories'], ', ' ) . '</b></small></p>
          </th>
          <td style="padding:10px 10px 10px;"><h3><a href="'.$link.'" title="'.$title.'" target="_blank">'.$title.'</a></h3>' .
          '<p>'.$description.'</p></td></tr>';


        }

      }

      if ( !empty( $html ) ) {

        $this->cache_set( $html );

      } else {

        /*
        * Fallback: Ask user to go directly to the posts.
        */
        $html = '<tr><td colspan=2 style="text-align:center;">' . sprintf( __( 'Please visit <a %s>%s</a>.', 'tag-groups' ), ' href="' . $this->posts_url . '" target="_blank" ', $this->posts_url ) . '</td></tr>';

        if ( $this->debug ) {

          error_log( 'Feed is empty: ' . $this->url );

        }

      }

      if ( $return ) {

        return $html;

      } else {

        echo $html;

      }

    }


    /**
    *
    *
    * modified from https://wp-mix.com/php-truncate-text-word/
    */
    private function truncate_string_at_word( $string, $limit, $break = ". ", $pad = " ..." ) {

      if (mb_strlen($string) <= $limit) return $string;

      if (false !== ($max = mb_strpos($string, $break, $limit))) {

        if ($max < mb_strlen($string) - 1) {

          $string = mb_substr($string, 0, $max) . $pad;

        }

      }

      return $string;

    }

  } // class

}
