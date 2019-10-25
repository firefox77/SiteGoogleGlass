<?php
/**
 * CSS Mixins for css/css-theme.php
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
 * Rem units.
 *
 * @since Crimson_Rose 1.01
 *
 * @param string $property
 * @param int    $pixel
 * @return string
 */
function crimson_rose_css_set_unit( $property, $pixel ) {
	if ( ! is_int( $pixel ) && ! is_numeric( $pixel ) ) {
		return $property . ': ' . $pixel . ';';
	}

	$default_font_size = 16;

	$css = '';
	$em  = round( ( $pixel / $default_font_size ), 6 );

	switch ( $property ) {
		default:
			$css  = $property . ': ' . $pixel . 'px;';
			$css .= $property . ': ' . $em . 'rem;';
			break;
	}

	return $css;
}
