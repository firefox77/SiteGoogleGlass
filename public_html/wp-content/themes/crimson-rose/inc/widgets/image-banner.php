<?php
/**
 * Content Widget: Image Banner Widget
 *
 * @package WordPress
 * @subpackage Crimson_Rose
 * @since 1.01
 * @author Chris Baldelomar <chris@webplantmedia.com>
 * @copyright Copyright (c) 2018, Chris Baldelomar
 * @link https://webplantmedia.com/product/crimson-rose-wordpress-theme/
 * @license http://www.gnu.org/licenses/gpl-2.0.html
 */

if ( ! class_exists( 'Crimson_Rose_Widget_Image_Banner_Widget' ) ) :
	/**
	 * Class: Display static content from an specific page.
	 *
	 * @since Crimson_Rose 1.01
	 *
	 * @see Crimson_Rose_Widget
	 */
	class Crimson_Rose_Widget_Image_Banner_Widget extends Crimson_Rose_Widget {
		/**
		 * __construct
		 *
		 * @since Crimson_Rose 1.01
		 *
		 * @return void
		 */
		public function __construct() {
			$this->widget_id          = 'crimson-rose-image-banner';
			$this->widget_cssclass    = 'crimson-rose-image-banner';
			$this->widget_description = esc_html__( 'Display an image banner in your footer or sidebar.', 'crimson-rose' );
			$this->widget_name        = esc_html__( 'Crimson Rose: Image Banner', 'crimson-rose' );
			$this->settings           = array(
				'page'           => array(
					'type'        => 'page',
					'std'         => '',
					'label'       => esc_html__( 'Select Page:', 'crimson-rose' ),
					'description' => esc_html__( 'The post content and featured image will be grabbed from the selected post.', 'crimson-rose' ),
					'sanitize'    => 'text',
				),
				'image_width'    => array(
					'type'        => 'number',
					'std'         => '',
					'step'        => 5,
					'min'         => 100,
					'max'         => 1600,
					'label'       => esc_html__( 'Image Width (in pixels)', 'crimson-rose' ),
					'description' => esc_html__( 'Set custom size for featured image. Leave blank to use large image display.', 'crimson-rose' ),
					'sanitize'    => 'number_blank',
				),
				'image_style'    => array(
					'type'     => 'select',
					'std'      => 'round',
					'label'    => esc_html__( 'Image Style:', 'crimson-rose' ),
					'options'  => array(
						'none'  => esc_html__( 'None', 'crimson-rose' ),
						'round' => esc_html__( 'Round', 'crimson-rose' ),
					),
					'sanitize' => 'text',
				),
				'title_position' => array(
					'type'     => 'select',
					'std'      => 'below',
					'label'    => esc_html__( 'Title Position:', 'crimson-rose' ),
					'options'  => array(
						'above'  => esc_html__( 'Above', 'crimson-rose' ),
						'middle' => esc_html__( 'Middle', 'crimson-rose' ),
						'below'  => esc_html__( 'Below', 'crimson-rose' ),
					),
					'sanitize' => 'text',
				),
				'link'           => array(
					'type'     => 'text',
					'std'      => home_url( '/' ),
					'label'    => esc_html__( 'Link:', 'crimson-rose' ),
					'sanitize' => 'url',
				),
			);

			parent::__construct();
		}

		/**
		 * Widget function.
		 *
		 * @since Crimson_Rose 1.01
		 *
		 * @param array $args
		 * @param array $instance
		 * @return void
		 */
		function widget( $args, $instance ) {
			$o = $this->sanitize( $instance );

			extract( $args );

			$p              = null;
			$featured_image = null;
			if ( ! empty( $o['page'] ) ) {
				$p = get_post( $o['page'] );
			}

			if ( $p ) {
				$size = 'large';
				if ( $o['image_width'] >= 100 ) {
					$size = array( $o['image_width'], 9999 );
				}
				$featured_image = get_the_post_thumbnail( $p->ID, $size );
			}

			echo $before_widget; /* WPCS: XSS OK. HTML output. */

			$class   = array();
			$class[] = 'image-banner-wrapper';
			$class[] = 'image-banner-title-position-' . $o['title_position'];
			$class[] = 'image-banner-style-' . $o['image_style'];
			?>

			<div class="<?php echo esc_attr( implode( ' ', $class ) ); ?>">
				<?php if ( $p ) : ?>
					<?php if ( ! empty( $p->post_title ) && ( $o['title_position'] == 'above' ) ) : ?>
						<?php echo $before_title . esc_html( $p->post_title ) . $after_title; /* WPCS: XSS OK. HTML output. */ ?>
					<?php endif; ?>

					<?php if ( ! empty( $o['link'] ) ) : ?>
						<a class="image-banner-pic" href="<?php echo esc_url( $o['link'] ); ?>">
					<?php else : ?>
						<div class="image-banner-pic">
					<?php endif; ?>

						<?php if ( $featured_image ) : ?>
							<?php echo $featured_image; /* WPCS: XSS OK. HTML output. */ ?>
						<?php endif; ?>

						<?php if ( ! empty( $p->post_title ) && ( $o['title_position'] != 'above' ) ) : ?>
							<?php echo $before_title . '<span>' . esc_html( $p->post_title ) . '</span>' . $after_title; /* WPCS: XSS OK. HTML output. */ ?>
						<?php endif; ?>

					<?php if ( ! empty( $o['link'] ) ) : ?>
						</a>
					<?php else : ?>
						</div>
					<?php endif; ?>

					<?php if ( ! empty( $p->post_content ) ) : ?>
						<div class="image-banner-description">
							<?php echo wpautop( $p->post_content ); /* WPCS: XSS OK. HTML output. */ ?>
						</div>
					<?php endif; ?>
				<?php else : ?>
					<center><em><a href="<?php echo esc_url( admin_url( 'customize.php?autofocus[panel]=widgets' ) ); ?>"><?php echo esc_html__( 'Select a page.', 'crimson-rose' ); ?></a></em></center>
				<?php endif; ?>

				<?php if ( $p && get_edit_post_link( $p->ID ) ) : ?>
					<footer class="entry-footer">
						<?php
							edit_post_link(
								sprintf(
									'%1$s <span class="screen-reader-text">%2$s</span>',
									esc_html__( 'Edit', 'crimson-rose' ),
									get_the_title()
								),
								'<div class="entry-footer-meta"><span class="edit-link">',
								'</span></div>',
								$p->ID
							);
						?>
					</footer><!-- .entry-footer -->
				<?php endif; ?>
			</div>

			<?php echo $after_widget; /* WPCS: XSS OK. HTML output. */ ?>
			<?php
		}

		/**
		 * Registers the widget with the WordPress Widget API.
		 *
		 * @since Crimson_Rose 1.01
		 *
		 * @return void
		 */
		public static function register() {
			register_widget( __CLASS__ );
		}
	}
endif;

add_action( 'widgets_init', array( 'Crimson_Rose_Widget_Image_Banner_Widget', 'register' ) );
