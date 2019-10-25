<?php
/**
 * The footer sidebar containing three footer columns.
 *
 * @package WordPress
 * @subpackage Crimson_Rose
 * @since 1.01
 * @author Chris Baldelomar <chris@webplantmedia.com>
 * @copyright Copyright (c) 2018, Chris Baldelomar
 * @link https://webplantmedia.com/product/crimson-rose-wordpress-theme/
 * @license http://www.gnu.org/licenses/gpl-2.0.html
 */

if ( ! $footer = crimson_rose_display_sidebar_footer() ) {
	return;
}
$column = 1;
?>

<aside id="tertiary" class="footer-widget-area">
	<?php if ( $footer[1] ) : ?>
		<div class="footer-column-<?php echo esc_attr( $column ); ?>">
			<?php dynamic_sidebar( 'footer-1' ); ?>
		</div>
	<?php endif; ?>
	<?php $column++; ?>

	<?php if ( $footer[2] ) : ?>
		<div class="footer-column-<?php echo esc_attr( $column ); ?>">
			<?php dynamic_sidebar( 'footer-2' ); ?>
		</div>
	<?php endif; ?>
	<?php $column++; ?>

	<?php if ( $footer[3] ) : ?>
		<div class="footer-column-<?php echo esc_attr( $column ); ?>">
			<?php dynamic_sidebar( 'footer-3' ); ?>
		</div>
	<?php endif; ?>
</aside><!-- #secondary -->
