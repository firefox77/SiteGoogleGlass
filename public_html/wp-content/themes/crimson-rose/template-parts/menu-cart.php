<?php
/**
 * Display WooCommerce menu cart.
 *
 * @package WordPress
 * @subpackage Crimson_Rose
 * @since 1.01
 * @author Chris Baldelomar <chris@webplantmedia.com>
 * @copyright Copyright (c) 2018, Chris Baldelomar
 * @link https://webplantmedia.com/product/crimson-rose-wordpress-theme/
 * @license http://www.gnu.org/licenses/gpl-2.0.html
 */

?>

<?php if ( crimson_rose_is_woocommerce_activated() ) : ?>
	<nav class="cart-menu in-menu-bar">
		<ul class="menu">
			<?php do_action( 'crimson_rose_cart' ); ?>
		</ul>
	</nav>
<?php endif; ?>
