<?php
/**
 * Content Widget: Jetpack Testimonials for widgetized pages.
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
 * Class: Jetpack Testimonials
 *
 * @since Crimson_Rose 1.01
 *
 * @see Crimson_Rose_Widget
 */
class Crimson_Rose_Content_Widget_Jetpack_Testimonials extends Crimson_Rose_Widget {
	/**
	 * __construct
	 *
	 * @since Crimson_Rose 1.01
	 *
	 * @return void
	 */
	public function __construct() {
		$this->widget_id          = 'crimson-rose-content-widget-jetpack-testimonials';
		$this->widget_description = esc_html__( 'Displays Jetpack testimonials on your widgetized page.', 'crimson-rose' );
		$this->widget_name        = esc_html__( 'Crimson Rose: Jetpack Testimonials', 'crimson-rose' );
		$this->settings           = array(
			'title'             => array(
				'type'     => 'text',
				'std'      => esc_html__( 'THOUSANDS OF HAPPY CUSTOMERS AND COUNTING', 'crimson-rose' ),
				'label'    => esc_html__( 'Title:', 'crimson-rose' ),
				'sanitize' => 'text',
			),
			'display_signature' => array(
				'type'     => 'checkbox',
				'std'      => 1,
				'label'    => esc_html__( 'Display Signature:', 'crimson-rose' ),
				'sanitize' => 'checkbox',
			),
			'signature_icon'    => array(
				'type'     => 'select',
				'std'      => 'heart',
				'label'    => esc_html__( 'Icon to display before signature:', 'crimson-rose' ),
				'options'  => array(
					'short-dash'  => esc_html__( 'Short Dash', 'crimson-rose' ),
					'medium-dash' => esc_html__( 'Medium Dash', 'crimson-rose' ),
					'long-dash'   => esc_html__( 'Long Dash', 'crimson-rose' ),
					'heart'       => esc_html__( 'Heart', 'crimson-rose' ),
					''            => esc_html__( 'None', 'crimson-rose' ),
				),
				'sanitize' => 'text',
			),
			'columns'           => array(
				'type'     => 'select',
				'std'      => '2',
				'label'    => esc_html__( 'Columns:', 'crimson-rose' ),
				'options'  => array(
					'1' => esc_html__( '1', 'crimson-rose' ),
					'2' => esc_html__( '2', 'crimson-rose' ),
				),
				'sanitize' => 'text',
			),
			'showposts'         => array(
				'type'        => 'number',
				'std'         => 0,
				'step'        => 1,
				'min'         => 0,
				'label'       => esc_html__( 'Number of testimonials to display:', 'crimson-rose' ),
				'description' => esc_html__( 'Set to zero to display all.', 'crimson-rose' ),
				'sanitize'    => 'number',
			),
			'order'             => array(
				'type'     => 'select',
				'std'      => 'asc',
				'label'    => esc_html__( 'Order:', 'crimson-rose' ),
				'options'  => array(
					'asc'  => esc_html__( 'ASC', 'crimson-rose' ),
					'desc' => esc_html__( 'DESC', 'crimson-rose' ),
				),
				'sanitize' => 'text',
			),
			'orderby'           => array(
				'type'     => 'select',
				'std'      => 'date',
				'label'    => esc_html__( 'Order By:', 'crimson-rose' ),
				'options'  => array(
					'date'   => esc_html__( 'Date', 'crimson-rose' ),
					'title'  => esc_html__( 'Title', 'crimson-rose' ),
					'author' => esc_html__( 'Author', 'crimson-rose' ),
					'rand'   => esc_html__( 'Random', 'crimson-rose' ),
				),
				'sanitize' => 'text',
			),
			'style'             => array(
				'type'     => 'select',
				'std'      => 'plain',
				'label'    => esc_html__( 'Box Style:', 'crimson-rose' ),
				'options'  => array(
					'plain'  => esc_html__( 'Plain', 'crimson-rose' ),
					'border' => esc_html__( 'Border', 'crimson-rose' ),
				),
				'sanitize' => 'text',
			),
			'height'            => array(
				'type'     => 'number',
				'std'      => 370,
				'step'     => 1,
				'min'      => 0,
				'max'      => 1000,
				'label'    => esc_html__( 'Height of testimonials:', 'crimson-rose' ),
				'sanitize' => 'number',
			),
			'padding_top'       => array(
				'type'     => 'number',
				'std'      => 40,
				'step'     => 1,
				'min'      => 0,
				'max'      => 300,
				'label'    => esc_html__( 'Top padding of widget:', 'crimson-rose' ),
				'sanitize' => 'number',
			),
			'padding_bottom'    => array(
				'type'     => 'number',
				'std'      => 40,
				'step'     => 1,
				'min'      => 0,
				'max'      => 300,
				'label'    => esc_html__( 'Bottom padding of widget:', 'crimson-rose' ),
				'sanitize' => 'number',
			),
			'margin_bottom'     => array(
				'type'     => 'number',
				'std'      => 80,
				'step'     => 1,
				'min'      => 0,
				'max'      => 300,
				'label'    => esc_html__( 'Bottom margin of widget:', 'crimson-rose' ),
				'sanitize' => 'number',
			),
			'panels'            => array(
				array(
					'title'  => esc_html__( 'Slider Settings', 'crimson-rose' ),
					'fields' => array(
						'slider_mode'      => array(
							'type'     => 'select',
							'std'      => 'horizontal',
							'label'    => esc_html__( 'Transition Effect:', 'crimson-rose' ),
							'options'  => array(
								'horizontal' => esc_html__( 'Slide', 'crimson-rose' ),
								'fade'       => esc_html__( 'Fade', 'crimson-rose' ),
							),
							'sanitize' => 'text',
						),
						'slider_pause'     => array(
							'type'     => 'number',
							'std'      => 9,
							'step'     => 1,
							'min'      => 1,
							'max'      => 100,
							'label'    => esc_html__( 'Speed of the slideshow change in seconds:', 'crimson-rose' ),
							'sanitize' => 'number',
						),
						'slider_auto'      => array(
							'type'     => 'checkbox',
							'std'      => 1,
							'label'    => esc_html__( 'Auto start slider transitions?', 'crimson-rose' ),
							'sanitize' => 'checkbox',
						),
						'slider_autohover' => array(
							'type'     => 'checkbox',
							'std'      => 1,
							'label'    => esc_html__( 'Pause slideshow when hovering?', 'crimson-rose' ),
							'sanitize' => 'checkbox',
						),
						'slider_controls'  => array(
							'type'     => 'checkbox',
							'std'      => 1,
							'label'    => esc_html__( 'Show slide control?', 'crimson-rose' ),
							'sanitize' => 'checkbox',
						),
						'slider_pager'     => array(
							'type'     => 'checkbox',
							'std'      => 1,
							'label'    => esc_html__( 'Show slide pagination?', 'crimson-rose' ),
							'sanitize' => 'checkbox',
						),
					),
				),
			),
		);

		parent::__construct();
	}

	/**
	 * Widget function.
	 *
	 * @see WP_Widget
	 * @access public
	 * @param array $args
	 * @param array $instance
	 * @return void
	 */
	function widget( $args, $instance ) {
		wp_enqueue_script( 'bx2slider' );

		extract( $args );

		$o = $this->sanitize( $instance );

		$style             = array();
		$testimonial_style = array();
		$classes[]         = 'content-jetpack-testimonial';

		if ( ! empty( $o['margin_bottom'] ) ) {
			$style[] = 'margin-bottom:' . $o['margin_bottom'] . 'px;';
		}

		if ( ! empty( $o['padding_top'] ) ) {
			$style[] = 'padding-top:' . $o['padding_top'] . 'px;';
		}

		if ( ! empty( $o['padding_bottom'] ) ) {
			$style[] = 'padding-bottom:' . $o['padding_bottom'] . 'px;';
		}

		if ( ! empty( $o['style'] ) ) {
			$classes[] = 'box-style-' . $o['style'];
		}

		if ( ! empty( $o['height'] ) ) {
			$testimonial_style[] = 'height:' . $o['height'] . 'px;';
		}

		$options['showposts'] = $this->settings['showposts']['std'];
		$options['order']     = $this->settings['order']['std'];
		$options['orderby']   = $this->settings['orderby']['std'];

		$options['post_type'] = 'jetpack-testimonial'; /* Force this post type. */

		$query = new WP_Query( $options );

		$testimonial_index_number = 1;
		$column                   = 0;
		$testimonials             = array();
		$notice                   = '';
		?>

		<?php if ( $query->have_posts() ) : ?>
			<?php
			/* open .jetpack-testimonial-shortcode */

			// Construct the loop...
			while ( $query->have_posts() ) {
				$query->the_post();
				$post_id   = get_the_ID();
				$temp      = '<div class="testimonial-entry-wrapper" style="' . esc_attr( implode( '', $testimonial_style ) ) . '">';
					$temp .= '<div class="testimonial-entry">';
						// Featured image.
						$class = ' no-testimonial-image';
				if ( $image = $this->get_testimonial_thumbnail_link( $post_id ) ) {
					$temp .= $image;
					$class = ' has-testimonial-image';
				}

						$temp     .= '<div class="testimonial-entry-content-wrapper' . esc_attr( $class ) . '">';
							$temp .= '<div class="testimonial-entry-content">' . get_the_excerpt() . '</div>';

				if ( $o['display_signature'] ) {
					switch ( $o['signature_icon'] ) {
						case 'short-dash':
							$icon = '&#8211; ';
							break;
						case 'medium-dash':
							$icon = '&#8212; ';
							break;
						case 'long-dash':
							$icon = '&#8213; ';
							break;
						case 'heart':
							$icon = '<i class="genericons-neue genericons-neue-heart"></i>';
							break;
						default:
							$icon = '';
							break;
					}

					$temp     .= '<div class="testimonial-entry-signature">';
						$temp .= $icon . '<span class="testimonial-signature">' . get_the_title() . '</span>';
					$temp     .= '</div>';
				}
						$temp .= '</div><!-- close .testimonial-entry-content-wrapper -->';
					$temp     .= '</div><!-- close .testimonial-entry -->';

					$temp         .= '<footer class="entry-footer">';
						$temp     .= '<div class="entry-footer-meta"><span class="edit-link">';
							$temp .= sprintf(
								'<a class="post-edit-link" href="%1$s">%2$s <span class="screen-reader-text">%3$s</span></a>',
								esc_url( get_edit_post_link( $post_id ) ),
								esc_html__( 'Edit', 'crimson-rose' ),
								get_the_title()
							);
						$temp     .= '</span></div>';
					$temp         .= '</footer><!-- .entry-footer -->';

				$temp .= '</div><!-- close .testimonial-entry-wrapper -->';

				$testimonials[ $column ][] = $temp;
				$mod                       = $testimonial_index_number % $o['columns'];
				if ( 0 === $mod ) {
					$column++;
				}
				$testimonial_index_number++;
			} /* end of while loop. */
			?>
		<?php endif; ?>

		<?php $before_widget = str_replace( 'class="content-widget', 'class="content-widget full-width-bar', $before_widget ); ?>
		<?php echo $before_widget; /* WPCS: XSS OK. HTML output. */ ?>

			<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>" style="<?php echo esc_attr( implode( '', $style ) ); ?>">
				<div class="site-boundary">
					<?php if ( ! empty( $o['title'] ) ) : ?>
						<?php echo $before_title . esc_html( $o['title'] ) . $after_title; /* WPCS: XSS OK. HTML output. */ ?>
					<?php endif; ?>

					<?php if ( ! empty( $testimonials ) ) : ?>

						<div class="testimonial-slider" data-sliderauto="<?php echo esc_attr( $o['slider_auto'] ); ?>" data-slidermode="<?php echo esc_attr( $o['slider_mode'] ); ?>" data-sliderpause="<?php echo esc_attr( $o['slider_pause'] ); ?>" data-sliderautohover="<?php echo esc_attr( $o['slider_autohover'] ); ?>" data-slidercontrols="<?php echo esc_attr( $o['slider_controls'] ); ?>" data-sliderpager="<?php echo esc_attr( $o['slider_pager'] ); ?>">
							<?php
							foreach ( $testimonials as $slide ) :
								$size = sizeof( $slide );
								?>
								<div class="testimonial-slide testimonial-slide-size-<?php echo esc_attr( $size ); ?>">
									<div class="grid">
										<?php foreach ( $slide as $key => $testimonial ) : ?>
											<?php if ( $size == 1 ) : ?>
												<div class="grid__col grid__col--2-of-2 testimonial-position-<?php echo esc_attr( $key ); ?>">
													<?php echo $testimonial; /* WPCS: XSS OK. HTML output. */ ?>
												</div>
											<?php else : ?>
												<div class="grid__col grid__col--1-of-2 testimonial-position-<?php echo esc_attr( $key ); ?>">
													<?php echo $testimonial; /* WPCS: XSS OK. HTML output. */ ?>
												</div>
											<?php endif; ?>
										<?php endforeach; ?>
									</div>
								</div>
							<?php endforeach; ?>
						</div>

						<script type="text/javascript">
							/* <![CDATA[ */
							( function($) {
								'use strict';

								$(document).ready(function(){
									var $slider = $('#<?php echo esc_attr( $this->id ); ?> .testimonial-slider');
									var sliderauto = $slider.data('sliderauto');
									var slidermode = $slider.data('slidermode');
									var sliderpause = $slider.data('sliderpause');
									var sliderautohover = $slider.data('sliderautohover');
									var slidercontrols = $slider.data('slidercontrols');
									var sliderpager = $slider.data('sliderpager');

									slidermode = typeof slidermode === 'undefined' ? 'horizontal' : slidermode;
									sliderpause = typeof sliderpause === 'undefined' ? 9000 : ( 1000 * sliderpause );
									sliderauto = sliderauto == 1 ? true : false;
									sliderautohover = sliderautohover == 1 ? true : false;
									slidercontrols = slidercontrols == 1 ? true : false;
									sliderpager = sliderpager == 1 ? true : false;

									$slider.bx2Slider({
										auto: sliderauto,
										nextText: '<i class="genericons-neue genericons-neue-expand genericons-neue-rotate-270"></i>',
										prevText: '<i class="genericons-neue genericons-neue-expand genericons-neue-rotate-90"></i>',
										mode: slidermode,
										pause: sliderpause,
										autoHover: sliderautohover,
										controls: slidercontrols,
										pager: sliderpager,
										onSliderResize: function() {
											if ( sliderauto ) {
												var $el = $(this);
												var $e = $el.find('.testimonial-entry-content-wrapper').first();
												var check = $e.css('position');
												if ( 'static' == check ) {
													$slider.stopAuto();
												}
												else {
													$slider.startAuto();
												}
											}
										}
									});
								});
							} )( jQuery );
							/* ]]> */
						</script>

					<?php else : ?>

						<?php if ( ! crimson_rose_is_jetpack_activated() ) : ?>
							<p><center><em><?php echo esc_html__( 'Activate Jetpack and enable testimonials.', 'crimson-rose' ); ?></em></center></p>
						<?php else : ?>
							<p><center><em><?php echo esc_html__( 'Your Testimonial Archive currently has no entries. You can start creating them on your dashboard.', 'crimson-rose' ); ?></em></center></p>
						<?php endif; ?>

					<?php endif; ?>
				</div><!-- .site-boundary -->
			</div><!-- .content-jetpack-testimonial -->

		<?php echo $after_widget; /* WPCS: XSS OK. HTML output. */ ?>

		<?php
		wp_reset_postdata();
	}

	/**
	 * Display the featured image if it's available
	 *
	 * @since Crimson_Rose 1.01
	 *
	 * @param int $post_id
	 * @return string
	 */
	private function get_testimonial_thumbnail_link( $post_id ) {
		if ( has_post_thumbnail( $post_id ) ) {
			/**
			 * Change the thumbnail size for the Testimonial CPT.
			 *
			 * @module custom-content-types
			 *
			 * @since 3.4.0
			 *
			 * @param string|array $var Either a registered size keyword or size array.
			 */
			return '<div class="testimonial-featured-image">' . get_the_post_thumbnail( $post_id, 'thumbnail' ) . '</div>';
		}
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

add_action( 'widgets_init', array( 'Crimson_Rose_Content_Widget_Jetpack_Testimonials', 'register' ) );
