<?php
/**
 * Widget base class.
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
 * Class: Widget base.
 *
 * @since Crimson_Rose 1.01
 *
 * @see WP_Widget
 */
class Crimson_Rose_Widget extends WP_Widget {

	public $widget_description;
	public $widget_id;
	public $widget_name;
	public $settings;
	public $control_ops;
	public $selective_refresh = true;

	/**
	 * __construct
	 *
	 * @since Crimson_Rose 1.01
	 *
	 * @return void
	 */
	public function __construct() {
		$widget_ops = array(
			'classname'                   => $this->widget_id,
			'description'                 => $this->widget_description,
			'customize_selective_refresh' => $this->selective_refresh,
		);

		parent::__construct( $this->widget_id, $this->widget_name, $widget_ops, $this->control_ops );

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'wp_ajax_crimson_rose_post_lookup', array( &$this, 'post_lookup_callback' ) );
	}

	/**
	 * Echo post title and id for ajax request. Used in widget for searching
	 * for post by title.
	 *
	 * @since Crimson_Rose 1.01
	 *
	 * @return void
	 */
	public function post_lookup_callback() {
		global $wpdb; /* get access to the WordPress database object variable. */

		// get names of all businesses.
		$request   = '%' . $wpdb->esc_like( stripslashes( sanitize_text_field( $_POST['request'] ) ) ) . '%'; /* escape for use in LIKE statement. */
		$post_type = stripslashes( sanitize_text_field( $_POST['post_type'] ) );

		$sql = "
			select
				ID,
				post_title
			from
				$wpdb->posts
			where
				post_title like %s
				and post_type='%s'
				and post_status='publish'
			order by
				post_title ASC
			limit
				0,30
		";

		$sql = $wpdb->prepare( $sql, $request, $post_type );

		$results = $wpdb->get_results( $sql );

		// copy the business titles to a simple array.
		$titles = array();
		$i      = 0;
		foreach ( $results as $r ) {
			$titles[ $i ]['label'] = $r->post_title . ' (' . $r->ID . ')';
			$titles[ $i ]['value'] = $r->ID;
			$i++;
		}

		if ( empty( $titles ) ) {
			$titles[0]['label'] = 'No results found in post type "' . $post_type . '."';
			$titles[0]['value'] = '0';
		}

		echo json_encode( $titles ); /* encode into JSON format and output. */

		die(); /* stop "0" from being output. */
	}

	/**
	 * Enqueue Scripts
	 *
	 * @since Crimson_Rose 1.01
	 *
	 * @param string $hook_suffix
	 * @return void
	 */
	public function enqueue_scripts( $hook_suffix ) {
		if ( 'widgets.php' !== $hook_suffix ) {
			return;
		}
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_style( 'crimson-rose-admin-widgets', get_parent_theme_file_uri() . '/css/admin/admin-widgets.css', array(), CRIMSON_ROSE_VERSION );

		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_script( 'jquery-ui' );
		wp_enqueue_script( 'jquery-ui-autocomplete' );
		wp_enqueue_script( 'jquery-ui-accordion' );

		wp_enqueue_script( 'crimson-rose-admin-widgets', get_template_directory_uri() . '/js/admin/admin-widgets.js', array(), CRIMSON_ROSE_VERSION, true );
		wp_enqueue_script( 'crimson-rose-post-select', get_template_directory_uri() . '/js/admin/admin-post-select.js', array(), CRIMSON_ROSE_VERSION, true );
	}

	/**
	 * Sanitize options.
	 *
	 * @since Crimson_Rose 1.01
	 *
	 * @param array $instance
	 * @return array
	 */
	function sanitize( $instance ) {
		if ( ! $this->settings ) {
			return $instance;
		}

		if ( isset( $instance['repeater'] ) && is_array( $instance['repeater'] ) ) {
			$repeater_instances = $instance['repeater'];
			unset( $instance['repeater'] );
			// turn on to test default widget settings.
			/* $repeater_instances = $this->settings['repeater']['default']; */
		} else {
			if ( isset( $this->settings['repeater']['default'] ) ) {
				$repeater_instances = $this->settings['repeater']['default'];
			} else {
				$repeater_instances[1] = array();
			}
		}

		foreach ( $this->settings as $key => $setting ) {
			if ( $key == 'panels' ) {
				foreach ( $setting as $panel ) {
					foreach ( $panel['fields'] as $panel_field_key => $panel_field_setting ) {
						$value                        = $this->default_sanitize_value( $panel_field_key, $instance, $panel_field_setting );
						$instance[ $panel_field_key ] = $this->sanitize_instance( $panel_field_setting, $value, 'display' );
					}
				}
			} elseif ( $key == 'repeater' ) {
				foreach ( $repeater_instances as $repeater_count => $repeater_instance ) {
					foreach ( $setting['fields'] as $repeater_field_key => $repeater_field_setting ) {
						$value = $this->default_sanitize_value( $repeater_field_key, $repeater_instance, $repeater_field_setting );
						$instance['repeater'][ $repeater_count ][ $repeater_field_key ] = $this->sanitize_instance( $repeater_field_setting, $value, 'display' );
					}
				}
			} else {
				$value = $this->default_sanitize_value( $key, $instance, $setting );
				// turn on to test default widget settings.
				/* $value = $setting['std']; */
				$instance[ $key ] = $this->sanitize_instance( $setting, $value, 'display' );
			}
		}

		return $instance;
	}

	/**
	 * Check if default value needs to be returned.
	 *
	 * @since Crimson_Rose 1.01
	 *
	 * @param string $key
	 * @param array  $instance
	 * @param array  $setting
	 * @return array
	 */
	function default_sanitize_value( $key, $instance, $setting ) {
		if ( array_key_exists( $key, $instance ) ) {
			return $instance[ $key ];
		} else {
			return $setting['std'];
		}
	}

	/**
	 * Properly save user input.
	 *
	 * @since Crimson_Rose 1.01
	 *
	 * @param string $key
	 * @param array  $instance
	 * @param array  $setting
	 * @return mixed
	 */
	function default_update_value( $key, $instance, $setting ) {
		if ( array_key_exists( $key, $instance ) ) {
			return $instance[ $key ];
		} else {
			if ( $setting['type'] == 'checkbox' ) {
				return 0;
			} else {
				return $setting['std'];
			}
		}
	}

	/**
	 * Update
	 *
	 * @since Crimson_Rose 1.01
	 *
	 * @param array $new_instance
	 * @param array $old_instance
	 * @return array
	 */
	function update( $new_instance, $old_instance ) {
		$instance       = array();
		$repeater_count = 0;

		if ( ! $this->settings ) {
			return $instance;
		}

		if ( isset( $new_instance['repeater'] ) && is_array( $new_instance['repeater'] ) ) {
			$repeater_instances = $new_instance['repeater'];
			unset( $new_instance['repeater'] );
		} else {
			if ( isset( $this->settings['repeater']['default'] ) ) {
				$repeater_instances = $this->settings['repeater']['default'];
			} else {
				$repeater_instances[1] = array();
			}
		}

		foreach ( $this->settings as $key => $setting ) {
			if ( $key == 'panels' ) {
				foreach ( $setting as $panel ) {
					foreach ( $panel['fields'] as $panel_field_key => $panel_field_setting ) {
						$value                        = $this->default_update_value( $panel_field_key, $new_instance, $panel_field_setting );
						$instance[ $panel_field_key ] = $this->sanitize_instance( $panel_field_setting, $value );
					}
				}
			} elseif ( $key == 'repeater' ) {
				foreach ( $repeater_instances as $repeater_instance ) {
					$repeater_count++;
					foreach ( $setting['fields'] as $repeater_field_key => $repeater_field_setting ) {
						$value = $this->default_update_value( $repeater_field_key, $repeater_instance, $repeater_field_setting );
						$instance['repeater'][ $repeater_count ][ $repeater_field_key ] = $this->sanitize_instance( $repeater_field_setting, $value );
					}
				}
			} else {
				$value            = $this->default_update_value( $key, $new_instance, $setting );
				$instance[ $key ] = $this->sanitize_instance( $setting, $value );
			}
		}

		return $instance;
	}

	/**
	 * Sanitize Instance
	 *
	 * @since Crimson_Rose 1.01
	 *
	 * @param array  $setting
	 * @param mixed  $new_value
	 * @param string $action
	 * @return mixed
	 */
	function sanitize_instance( $setting, $new_value, $action = 'update' ) {
		if ( ! isset( $setting['sanitize'] ) ) {
			return $new_value;
		}

		$value = '';

		switch ( $setting['sanitize'] ) {
			case 'html':
				$value = wp_kses_post( $new_value );
				break;

			case 'multicheck':
				$value = maybe_serialize( $new_value );
				break;

			case 'checkbox':
				$value = $new_value == 1 ? 1 : 0;
				break;

			case 'text':
				$value = sanitize_text_field( $new_value );
				break;

			case 'absint':
				$value = absint( $new_value );
				break;

			case 'number':
				$value = intval( $new_value );
				break;

			case 'number_blank':
				if ( $new_value === '' ) {
					$value = '';
				} else {
					$value = intval( $new_value );
				}
				break;

			case 'color':
				$value = sanitize_hex_color( $new_value );
				break;

			case 'url':
				$value = esc_url_raw( $new_value );

				if ( $action == 'display' ) {
					$value = $this->sanitize_url_for_customizer( $new_value );
				}
				break;

			case 'background_size':
				$value = $this->sanitize_background_size( $new_value );
				break;

			case 'ids':
			case 'post_ids':
				$value = $this->sanitize_ids( $new_value );
				break;

			case 'slugs':
				$value = $this->sanitize_slugs( $new_value );
				break;

			default:
				$value = $new_value;
				break;
		}

		return $value;
	}

	/**
	 * This functions provides the big picture logic
	 * for displaying each type of user input field.
	 *
	 * @since Crimson_Rose 1.01
	 *
	 * @param array $instance
	 * @return void
	 */
	function form( $instance ) {

		if ( ! $this->settings ) {
			return;
		}
		$display_panels   = false;
		$display_repeater = false;
		$panel_count      = 0;

		if ( isset( $instance['repeater'] ) && is_array( $instance['repeater'] ) ) {
			$repeater_instances = $instance['repeater'];
			unset( $instance['repeater'] );
		} else {
			if ( isset( $this->settings['repeater']['default'] ) ) {
				$repeater_instances = $this->settings['repeater']['default'];
			} else {
				$repeater_instances[1] = array();
			}
		}
		?>

		<div id="<?php echo esc_attr( $this->id ); ?>" class="widget-inner-container ui-theme-override">
			<?php

			foreach ( $this->settings as $key => $setting ) {

				if ( 'repeater' == $key ) {
					$display_repeater = true;

					$this->display_before_panel_repeater();

					foreach ( $repeater_instances as $repeater_instance ) {

						$this->display_before_panel( $setting['title'] );

						$panel_count++;
						foreach ( $setting['fields'] as $key => $repeater_setting ) {
							$this->display_settings( $repeater_instance, $key, $repeater_setting, $display_repeater, $panel_count );
						}

						$this->display_after_panel( $display_repeater );
					}

					$this->display_after_panel_repeater( $panel_count );
				} elseif ( 'panels' == $key ) {
					$display_panels = true;

					$this->display_before_panels();

					foreach ( $setting as $s ) {

						$this->display_before_panel( $s['title'] );

						foreach ( $s['fields'] as $key => $panel_setting ) {
							$this->display_settings( $instance, $key, $panel_setting );
						}

						$this->display_after_panel();
					}

					$this->display_after_panels();
				} else {
					$this->display_settings( $instance, $key, $setting );
				}
			}

			?>
		</div>

		<?php if ( $display_repeater ) : ?>
				<?php $selector = '#' . esc_attr( $this->id ) . ' .panel-repeater-container'; ?>
				<script type="text/javascript">
					/* <![CDATA[ */
					( function( $ ) {
						"use strict";
						$(document).ready(function($){
							$('#widgets-right <?php echo esc_attr( $selector ); ?>').accordion({
								header: '.widget-panel-title',
								heightStyle: 'content',
								collapsible: true,
								active: false
							});

							widgetPanelRepeaterButtons( $('<?php echo esc_attr( $selector ); ?>') );
							widgetPanelMoveRefresh( $('<?php echo esc_attr( $selector ); ?>') );
						});
					} )( jQuery );
					/* ]]> */
				</script>
		<?php endif; ?>

		<?php if ( $display_panels ) : ?>
				<?php $selector = '#' . esc_attr( $this->id ) . ' .panel-container'; ?>
				<script type="text/javascript">
					/* <![CDATA[ */
					( function( $ ) {
						"use strict";
						$(document).ready(function($){
							$('#widgets-right <?php echo esc_attr( $selector ); ?>').accordion({
								header: '.widget-panel-title',
								heightStyle: 'content',
								collapsible: true,
								active: false
							});
						});
					} )( jQuery );
					/* ]]> */
				</script>
		<?php endif; ?>

		<?php
	}

	/**
	 * Display HTML before panels start
	 *
	 * @since Crimson_Rose 1.01
	 *
	 * @return void
	 */
	public function display_before_panels() {
		?>
		<div class="panel-container">
		<?php
	}

	/**
	 * Display HTML after panels start
	 *
	 * @since Crimson_Rose 1.01
	 *
	 * @return void
	 */
	public function display_after_panels() {
		?>
		</div>
		<?php
	}

	/**
	 * Display HTML before panel repeater start
	 *
	 * @since Crimson_Rose 1.01
	 *
	 * @return void
	 */
	public function display_before_panel_repeater() {
		?>
		<div class="panel-repeater-container">
		<?php
	}

	/**
	 * Display HTML after panel repeater start
	 *
	 * @since Crimson_Rose 1.01
	 *
	 * @param int $panel_count
	 * @return void
	 */
	public function display_after_panel_repeater( $panel_count ) {
		?>
		</div>
		<input type="hidden" id="widget-panel-repeater-count" value="<?php echo esc_attr( $panel_count ); ?>" />
		<a href="#" class="button-secondary widget-panel-repeater" onclick="widgetPanelRepeater( '<?php echo esc_attr( $this->id ); ?>' ); return false;"><?php esc_html_e( 'Add New Item', 'crimson-rose' ); ?></a>
		<?php
	}

	/**
	 * Display HTML before panel start
	 *
	 * @since Crimson_Rose 1.01
	 *
	 * @param string $title
	 * @return void
	 */
	public function display_before_panel( $title ) {
		?>
		<div class="widget-panel">
			<h3 class="widget-panel-title"><?php echo esc_html( $title ); ?></h3>
			<div class="widget-panel-body">
		<?php
	}

	/**
	 * Display HTML after panel start
	 *
	 * @since Crimson_Rose 1.01
	 *
	 * @param bool $display_repeater
	 * @return void
	 */
	public function display_after_panel( $display_repeater = false ) {
		?>
			</div>

			<?php if ( $display_repeater ) : ?>

			<a onclick="widgetPanelMoveUp( this ); return false;" href="#" class="dashicons-before dashicons-arrow-up-alt2 panel-move panel-move-up panel-button"></a>
			<a onclick="widgetPanelMoveDown( this ); return false;" href="#" class="dashicons-before dashicons-arrow-down-alt2 panel-move panel-move-down panel-button"></a>
			<a onclick="widgetPanelDelete( this ); return false;" href="#" class="dashicons-before dashicons-no panel-delete panel-button"></a>
			<span class="panel-delete-final">
				<?php echo esc_html__( 'Delete Slide?', 'crimson-rose' ); ?>
				<a href="#" onclick="widgetPanelDeleteYes( this ); return false;"><?php echo esc_html__( 'Yes', 'crimson-rose' ); ?></a>
				<a href="#" onclick="widgetPanelDeleteNo( this ); return false;"><?php echo esc_html__( 'No', 'crimson-rose' ); ?></a>
			</span>

			<?php endif; ?>
		</div>
		<?php
	}

	/**
	 * Display Setting
	 *
	 * @since Crimson_Rose 1.01
	 *
	 * @param array  $instance
	 * @param string $key
	 * @param array  $setting
	 * @param bool   $display_repeater
	 * @param int    $count
	 * @return void
	 */
	public function display_settings( $instance, $key, $setting, $display_repeater = false, $count = 1 ) {
		$value = array_key_exists( $key, $instance ) ? $instance[ $key ] : $setting['std'];

		if ( $display_repeater ) {
			$field_id   = $this->get_field_id( 'repeater' ) . '-' . $count . '-' . $key;
			$field_name = $this->get_field_name( 'repeater' ) . '[' . $count . ']' . '[' . $key . ']';
		} else {
			$field_id   = $this->get_field_id( $key );
			$field_name = $this->get_field_name( $key );
		}

		switch ( $setting['type'] ) {
			case 'description':
				?>
				<p class="description"><?php echo $value; /* WPCS: XSS OK. HTML output */ ?></p>
				<?php
				break;

			case 'text':
				?>
				<p>
					<label for="<?php echo esc_attr( $field_id ); ?>"><?php echo esc_html( $setting['label'] ); ?></label>
					<input class="widefat" id="<?php echo esc_attr( $field_id ); ?>" name="<?php echo esc_attr( $field_name ); ?>" type="text" value="<?php echo esc_attr( $value ); ?>" />
					<?php if ( isset( $setting['description'] ) ) : ?>
						<span class="description"><?php echo esc_html( $setting['description'] ); ?></span>
					<?php endif; ?>
				</p>
				<?php
				break;

			case 'image':
				wp_enqueue_media();
				wp_enqueue_script( 'crimson-rose-widget-image', get_template_directory_uri() . '/js/admin/admin-image.js', array( 'jquery' ), '', true );
				$id_prefix = $this->get_field_id( '' );
			?>
				<p style="margin-bottom: 0;">
					<label for="<?php echo esc_attr( $field_id ); ?>"><?php echo esc_html( $setting['label'] ); ?></label>
				</p>

				<div class="image-sel-container" style="margin-top: 3px;">
					<div class="image-sel-preview">
						<style type="text/css">
							.image-sel-preview img { max-width: 100%; border: 1px solid #e5e5e5; padding: 2px; margin-bottom: 5px; height: auto; }
						</style>
						<?php if ( ! empty( $value ) ) : ?>
						<img src="<?php echo esc_url( $value ); ?>" alt="">
						<?php endif; ?>
					</div>

					<input type="text" class="widefat image-sel-value" id="<?php echo esc_attr( $field_id ); ?>" name="<?php echo esc_attr( $field_name ); ?>"value="<?php echo esc_attr( $value ); ?>" placeholder="http://" style="margin-bottom:5px;" />
					<a href="#" class="button-secondary image-sel-add" onclick="imageWidget.uploader( this ); return false;"><?php esc_html_e( 'Choose Image', 'crimson-rose' ); ?></a>
					<?php
					$a_style = '';
					if ( empty( $value ) ) {
						$a_style = 'display:none;';
					}
					?>
					<a href="#" style="display:inline-block;margin:5px 0 0 3px;<?php echo esc_attr( $a_style ); ?>" class="image-sel-remove" onclick="imageWidget.remove( this ); return false;"><?php esc_html_e( 'Remove', 'crimson-rose' ); ?></a>
				</div>
				<?php if ( isset( $setting['description'] ) ) : ?>
					<span class="description"><?php echo esc_html( $setting['description'] ); ?></span>
				<?php endif; ?>
			<?php
				break;

			case 'checkbox':
				?>
				<p>
					<label for="<?php echo esc_attr( $field_id ); ?>">
						<input type="checkbox" id="<?php echo esc_attr( $field_id ); ?>" name="<?php echo esc_attr( $field_name ); ?>" type="text" value="1" <?php checked( 1, esc_attr( $value ) ); ?>/>
						<?php echo esc_html( $setting['label'] ); ?>
					</label>
					<?php if ( isset( $setting['description'] ) ) : ?>
						<span class="description"><?php echo esc_html( $setting['description'] ); ?></span>
					<?php endif; ?>
				</p>
				<?php
				break;

			case 'multicheck':
				$value = maybe_unserialize( $value );

				if ( ! is_array( $value ) ) {
					$value = array();
				}
				?>
				<p><?php echo esc_attr( $setting['label'] ); ?></p>
				<p>
					<?php foreach ( $setting['options'] as $id => $label ) : ?>
						<label for="<?php echo esc_attr( sanitize_title( $label ) ); ?>-<?php echo esc_attr( $id ); ?>">
							<input type="checkbox" id="<?php echo esc_attr( sanitize_title( $label ) ); ?>-<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $field_name ); ?>[]" value="<?php echo esc_attr( $id ); ?>" 
																	<?php
																	if ( in_array( $id, $value ) ) :
										?>
										checked="checked"<?php endif; ?>/>
							<?php echo esc_attr( $label ); ?><br />
						</label>
					<?php endforeach; ?>
					<?php if ( isset( $setting['description'] ) ) : ?>
						<span class="description"><?php echo esc_html( $setting['description'] ); ?></span>
					<?php endif; ?>
				</p>
				<?php
				break;

			case 'select':
				?>
				<p>
					<label for="<?php echo esc_attr( $field_id ); ?>"><?php echo esc_html( $setting['label'] ); ?></label>
					<select class="widefat" id="<?php echo esc_attr( $field_id ); ?>" name="<?php echo esc_attr( $field_name ); ?>">
						<?php foreach ( $setting['options'] as $key => $label ) : ?>
							<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $key, $value ); ?>><?php echo esc_attr( $label ); ?></option>
						<?php endforeach; ?>
					</select>
					<?php if ( isset( $setting['description'] ) ) : ?>
						<span class="description"><?php echo esc_html( $setting['description'] ); ?></span>
					<?php endif; ?>
				</p>
				<?php
				break;

			case 'page':
				$pages = get_pages( 'sort_order=ASC&sort_column=post_title&post_status=publish' );
				?>
				<p>
					<label for="<?php echo esc_attr( $field_id ); ?>"><?php echo esc_html( $setting['label'] ); ?></label>
					<select class="widefat" id="<?php echo esc_attr( $field_id ); ?>" name="<?php echo esc_attr( $field_name ); ?>">
						<option value="" <?php selected( '', $value ); ?>><?php echo esc_html__( 'No Page', 'crimson-rose' ); ?></option>
						<?php foreach ( $pages as $page ) : ?>
							<option value="<?php echo esc_attr( $page->ID ); ?>" <?php selected( $page->ID, $value ); ?>><?php echo esc_attr( $page->post_title ); ?></option>
						<?php endforeach; ?>
					</select>
					<?php if ( isset( $setting['description'] ) ) : ?>
						<span class="description"><?php echo esc_html( $setting['description'] ); ?></span>
					<?php endif; ?>
				</p>
				<?php
				break;

			case 'post':
				$post_type = 'post';
				if ( isset( $setting['post_type'] ) && ! empty( $setting['post_type'] ) && post_type_exists( $setting['post_type'] ) ) {
					$post_type = $setting['post_type'];
				}
				?>
				<p>
					<label for="<?php echo esc_attr( $field_id ); ?>"><?php echo esc_html( $setting['label'] ); ?></label>
					<input class="widefat post-autocomplete-select" id="<?php echo esc_attr( $field_id ); ?>" data-autocomplete-type="multi" data-autocomplete-taxonomy="" data-autocomplete-lookup="post" data-autocomplete-post-type="<?php echo esc_attr( $post_type ); ?>" name="<?php echo esc_attr( $field_name ); ?>" type="text" value="<?php echo esc_attr( $value ); ?>" />
					<?php if ( isset( $setting['description'] ) ) : ?>
						<span class="description"><?php echo esc_html( $setting['description'] ); ?></span>
					<?php endif; ?>
				</p>
				<script type="text/javascript">
					/* <![CDATA[ */
					jQuery(document).ready(function($){
						$('#<?php echo esc_attr( $field_id ); ?>').postAutoCompleteSelect();
					});
					/* ]]> */
				</script>
				<?php
				break;

			case 'number':
				?>
				<p>
					<label for="<?php echo esc_attr( $field_id ); ?>"><?php echo esc_html( $setting['label'] ); ?></label>
					<input class="widefat" id="<?php echo esc_attr( $field_id ); ?>" name="<?php echo esc_attr( $field_name ); ?>" type="number" step="<?php echo esc_attr( $setting['step'] ); ?>" 
															<?php
															if ( isset( $setting['min'] ) ) :
										?>
										 min="<?php echo esc_attr( $setting['min'] ); ?>" <?php endif; ?> <?php
											if ( isset( $setting['max'] ) ) :
											?>
											 max="<?php echo esc_attr( $setting['max'] ); ?>" <?php endif; ?> value="<?php echo esc_attr( $value ); ?>" />
					<?php if ( isset( $setting['description'] ) ) : ?>
						<span class="description"><?php echo esc_html( $setting['description'] ); ?></span>
					<?php endif; ?>
				</p>
				<?php
				break;

			case 'textarea':
				?>
				<p>
					<label for="<?php echo esc_attr( $field_id ); ?>"><?php echo esc_html( $setting['label'] ); ?></label>
					<?php $rows = isset( $setting['rows'] ) ? $setting['rows'] : 3; ?>
					<textarea class="widefat" id="<?php echo esc_attr( $field_id ); ?>" name="<?php echo esc_attr( $field_name ); ?>" rows="<?php echo esc_attr( $rows ); ?>"><?php echo esc_html( $value ); ?></textarea>
					<?php if ( isset( $setting['description'] ) ) : ?>
						<span class="description"><?php echo esc_html( $setting['description'] ); ?></span>
					<?php endif; ?>
				</p>
				<?php
				break;

			case 'colorpicker':
					wp_enqueue_script( 'wp-color-picker' );
					wp_enqueue_style( 'wp-color-picker' );
				?>
				<p style="margin-bottom: 0;">
					<label for="<?php echo esc_attr( $field_id ); ?>"><?php echo esc_html( $setting['label'] ); ?></label>
				</p>
				<div class="color-picker-wrapper">
					<input type="text" class="widefat color-picker" id="<?php echo esc_attr( $field_id ); ?>" name="<?php echo esc_attr( $field_name ); ?>" data-default-color="<?php echo esc_attr( $setting['std'] ); ?>" value="<?php echo esc_attr( $value ); ?>" />
					<script type="text/javascript">
						/* <![CDATA[ */
						( function( $ ){
							$( document ).ready( function() {
								$('#widgets-right #<?php echo esc_attr( $field_id ); ?>').wpColorPicker({
									change: _.throttle( function() { /* For Customizer */
										$(this).trigger( 'change' );
									}, 3000 )
								});
							} );
						}( jQuery ) );
						/* ]]> */
					</script>
				</div>
				<?php if ( isset( $setting['description'] ) ) : ?>
					<span class="description"><?php echo esc_html( $setting['description'] ); ?></span>
				<?php endif; ?>
				<p></p>
				<?php
				break;

			case 'category':
				$categories_dropdown = wp_dropdown_categories(
					array(
						'name'            => $this->get_field_name( 'category' ),
						'selected'        => $value,
						'show_option_all' => esc_html__( 'All Categories', 'crimson-rose' ),
						'show_count'      => true,
						'orderby'         => 'slug',
						'hierarchical'    => true,
						'class'           => 'widefat',
						'echo'            => false,
					)
				);
				?>

				<label for="<?php echo esc_attr( $field_id ); ?>"><?php echo esc_html( $setting['label'] ); ?></label>
				<?php echo $categories_dropdown; /* WPCS: XSS OK. HTML output. */ ?>

				<?php
				break;

			default:
				do_action( 'crimson_rose_widget_type_' . $setting['type'], $this, $key, $setting, $instance );
				break;
		}
	}

	/**
	 * Helper method to go from hex to rgb color.
	 *
	 * @since Crimson_Rose 1.01
	 *
	 * @param string $colour
	 * @return array
	 */
	function hex2rgb( $colour ) {
		if ( $colour[0] == '#' ) {
				$colour = substr( $colour, 1 );
		}
		if ( strlen( $colour ) == 6 ) {
				list( $r, $g, $b ) = array( $colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5] );
		} elseif ( strlen( $colour ) == 3 ) {
				list( $r, $g, $b ) = array( $colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2] );
		} else {
				return false;
		}
		$r = hexdec( $r );
		$g = hexdec( $g );
		$b = hexdec( $b );
		return array(
			'red'   => $r,
			'green' => $g,
			'blue'  => $b,
		);
	}

	/**
	 * Convert post_ids string to array of ints.
	 *
	 * @since Crimson_Rose 1.01
	 *
	 * @param string $post_ids
	 * @return array
	 */
	private function sanitize_ids_array( $post_ids ) {
		$post_ids = explode( ',', $post_ids );

		if ( is_array( $post_ids ) && ! empty( $post_ids ) ) {
			$post_ids_array = array();
			foreach ( $post_ids as $key => $value ) {
				$value = absint( $value );

				if ( ! empty( $value ) ) {
					$post_ids_array[] = $value;
				}
			}

			if ( ! empty( $post_ids_array ) ) {
				return $post_ids_array;
			}
		}

		return array();
	}

	/**
	 * Wrapper function to sanitize string of comma delimited ids.
	 *
	 * @since Crimson_Rose 1.01
	 *
	 * @param mixed $post_ids
	 * @return string
	 */
	private function sanitize_ids( $post_ids ) {
		$post_ids_array = $this->sanitize_ids_array( $post_ids );

		$post_ids = implode( ',', $post_ids_array );

		if ( ! empty( $post_ids ) ) {
			return $post_ids;
		}

		return '';
	}

	/**
	 * Comma delimited post slugs string to array
	 *
	 * @since Crimson_Rose 1.01
	 *
	 * @param string $post_ids
	 * @return array
	 */
	private function sanitize_slugs_array( $post_ids ) {
		$post_ids = explode( ',', $post_ids );

		if ( is_array( $post_ids ) && ! empty( $post_ids ) ) {
			$post_ids_array = array();
			foreach ( $post_ids as $key => $value ) {
				$value = sanitize_title( $value );

				if ( ! empty( $value ) ) {
					$post_ids_array[] = $value;
				}
			}

			if ( ! empty( $post_ids_array ) ) {
				return $post_ids_array;
			}
		}

		return array();
	}

	/**
	 * Wrapper function to sanitize post slugs in comma delimited string.
	 *
	 * @since Crimson_Rose 1.01
	 *
	 * @param string $post_ids
	 * @return string
	 */
	private function sanitize_slugs( $post_ids ) {
		$post_ids_array = $this->sanitize_slugs_array( $post_ids );

		$post_ids = implode( ',', $post_ids_array );

		if ( ! empty( $post_ids ) ) {
			return $post_ids;
		}

		return '';
	}

	/**
	 * Sanitize URL. This fixes a link bug in the Customizer.
	 *
	 * @since Crimson_Rose 1.01
	 *
	 * @param string $value
	 * @return string
	 */
	function sanitize_url_for_customizer( $value ) {
		if ( is_customize_preview() || is_preview() ) {
			// fixes obscure bug when admin panel is ssl and front end is not ssl.
			$value = preg_replace( '/^https?:/', '', $value );
		}

		return $value;
	}

	/**
	 * Sanitize background size
	 *
	 * @since Crimson_Rose 1.01
	 *
	 * @param mixed $value
	 * @return mixed
	 */
	function sanitize_background_size( $value ) {
		$whitelist = $this->options_background_size();

		if ( array_key_exists( $value, $whitelist ) ) {
			return $value;
		}

		return '';
	}

	/**
	 * Background size CSS options
	 *
	 * @since Crimson_Rose 1.01
	 *
	 * @return array
	 */
	function options_background_size() {
		return array(
			'cover'      => esc_html__( 'Cover', 'crimson-rose' ),
			'contain'    => esc_html__( 'Contain', 'crimson-rose' ),
			'stretch'    => esc_html__( 'Stretch', 'crimson-rose' ),
			'fit-width'  => esc_html__( 'Fit Width', 'crimson-rose' ),
			'fit-height' => esc_html__( 'Fit Height', 'crimson-rose' ),
			'auto'       => esc_html__( 'Auto', 'crimson-rose' ),
		);
	}

	/**
	 * Get CSS background size options
	 *
	 * @since Crimson_Rose 1.01
	 *
	 * @param string $value
	 * @return array
	 */
	function get_background_size( $value ) {
		switch ( $value ) {
			case 'stretch':
				$value = '100% 100%';
				break;
			case 'fit-width':
				$value = '100% auto';
				break;
			case 'fit-height':
				$value = 'auto 100%';
				break;
		}

		return $value;
	}
}
