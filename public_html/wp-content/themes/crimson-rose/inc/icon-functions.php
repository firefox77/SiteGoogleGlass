<?php
/**
 * Icon related functions and filters
 *
 * @package WordPress
 * @subpackage Crimson_Rose
 * @since 1.01
 * @author Chris Baldelomar <chris@webplantmedia.com>
 * @copyright Copyright (c) 2018, Chris Baldelomar
 * @link https://webplantmedia.com/product/crimson-rose-wordpress-theme/
 * @license http://www.gnu.org/licenses/gpl-2.0.html
 */

/**
 * Parse social menu
 *
 * @since Crimson_Rose 1.01
 *
 * @param string $item_output
 * @param mixed  $item
 * @param int    $depth
 * @param object $args
 * @return string
 */
function crimson_rose_nav_menu_social_icons( $item_output, $item, $depth, $args ) {
	// Get supported social icons.
	$social_icons = crimson_rose_social_links_icons();
	$known        = false;

	// Change icon inside social links menu if there is supported URL.
	if ( 'social' === $args->theme_location ) {
		foreach ( $social_icons as $attr => $value ) {
			if ( false !== strpos( $item_output, $attr ) ) {
				$item_output = str_replace( '<a ', '<a class="social-logo social-logo__' . esc_attr( $value ) . '" ', $item_output );
				$known       = true;
			}
		}

		if ( ! $known ) {
			$item_output = str_replace( '<a ', '<a class="social-logo social-logo__share" ', $item_output );
		}
	}

	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'crimson_rose_nav_menu_social_icons', 10, 4 );

/**
 * Returns an array of supported social links (URL and icon name).
 *
 * @since Crimson_Rose 1.01
 *
 * @return array $social_links_icons
 */
function crimson_rose_social_links_icons() {
	/*
	 * Supported social links icons.
	 *
	 * amazon
	 * behance
	 * blogger-alt
	 * blogger
	 * codepen
	 * dribbble
	 * dropbox
	 * eventbrite
	 * facebook
	 * feed
	 * flickr
	 * foursquare
	 * ghost
	 * github
	 * google-alt
	 * google-plus-alt
	 * google-plus
	 * google
	 * instagram
	 * linkedin
	 * mail
	 * medium
	 * path-alt
	 * path
	 * pinterest-alt
	 * pinterest
	 * pocket
	 * polldaddy
	 * print
	 * reddit
	 * share
	 * skype
	 * spotify
	 * squarespace
	 * stumbleupon
	 * telegram
	 * tumblr-alt
	 * tumblr
	 * twitch
	 * twitter-alt
	 * twitter
	 * vimeo
	 * whatsapp
	 * WordPress
	 * xanga
	 * youtube
	 */

	$social_links_icons = array(
		'amazon.com'      => 'amazon',
		'behance.net'     => 'behance',
		'blogger.com'     => 'blogger',
		'codepen.io'      => 'codepen',
		'dribbble.com'    => 'dribbble',
		'dropbox.com'     => 'dropbox',
		'eventbrite.com'  => 'eventbrite',
		'facebook.com'    => 'facebook',
		'flickr.com'      => 'flickr',
		'foursquare.com'  => 'foursquare',
		'plus.google.com' => 'google-plus',
		'github.com'      => 'github',
		'instagram.com'   => 'instagram',
		'linkedin.com'    => 'linkedin',
		'mailto:'         => 'mail',
		'medium.com'      => 'medium',
		'path.com'        => 'path',
		'pinterest.com'   => 'pinterest',
		'pscp.tv'         => 'periscope',
		'getpocket.com'   => 'pocket',
		'polldaddy.com'   => 'polldaddy',
		'reddit.com'      => 'reddit',
		'skype.com'       => 'skype',
		'skype:'          => 'skype',
		'spotify.com'     => 'spotify',
		'snapchat.com'    => 'ghost',
		'stumbleupon.com' => 'stumbleupon',
		'telegram.org'    => 'telegram',
		'tumblr.com'      => 'tumblr',
		'twitch.tv'       => 'twitch',
		'twitter.com'     => 'twitter-alt',
		'vimeo.com'       => 'vimeo',
		'whatsapp.com'    => 'whatsapp',
		'wordpress.org'   => 'wordpress',
		'wordpress.com'   => 'wordpress',
		'xanga.com'       => 'xanga',
		'youtube.com'     => 'youtube',
	);

	/**
	 * Filter Crimson Rose social links icons.
	 *
	 * @since Crimson Rose 1.0
	 *
	 * @param array $social_links_icons Array of social links icons.
	 */
	return apply_filters( 'crimson_rose_social_links_icons', $social_links_icons );
}
