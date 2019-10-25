<?php
/**
 * Notice Control for Displaying HTML notices in the Customizer
 * without any need for input.
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
 * Class: Notice Control
 *
 * @since Crimson_Rose 1.01
 *
 * @see WP_Customize_Control
 */
class Crimson_Rose_Notice_Control extends WP_Customize_Control {
	/**
	 * Render Content
	 *
	 * @since Crimson_Rose 1.01
	 *
	 * @return void
	 */
	public function render_content() {
		?>
		<div class="notice-control-wrapper">
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<?php if ( isset( $this->description ) && ! empty( $this->description ) ) : ?>
				<span class="description customize-control-description"><?php echo $this->description; /* WPCS: XSS OK. HTML output. */ ?></span>
			<?php endif; ?>
		</div>
		<?php
	}
}
