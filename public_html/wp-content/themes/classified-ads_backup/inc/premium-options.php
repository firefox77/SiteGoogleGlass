<?php if( ! defined( 'ABSPATH' ) ) exit;

add_action('admin_menu', 'classified_ads_admin_menu');

function classified_ads_admin_menu() {

global $classifiedads_settings_page;

   $classifiedads_settings_page = add_theme_page('Classified Ads Premium', 'Premium Theme ', 'edit_theme_options',  'my-unique-identifier', 'seos_classifiedads_settings_page');

	add_action( 'admin_init', 'register_mysettings' );
}

function register_mysettings() {

}

function seos_classifiedads_settings_page() {
?>
<div class="wrap">

	<form class="theme-options" method="post" action="options.php" accept-charset="ISO-8859-1">
		<?php settings_fields( 'seos-settings-group' ); ?>
		<?php do_settings_sections( 'seos-settings-group' ); ?>
		
		<div class="classified-ads-form">
			<a target="_blank" href="https://seosthemes.com/wordpress-theme-classified-ads/">
				<div class="btn s-red">
					 <?php _e('Buy', 'classified-ads'); ?> <img class="ss-logo" src="<?php echo get_template_directory_uri() . '/img/logo.png'; ?>"/><?php _e(' Now', 'classified-ads'); ?>
				</div>
			</a>
		</div>
		
		<div class="cb-center">	
			<img class="sb-demo" src="<?php echo get_template_directory_uri() . '/img/premium.png'; ?>"/>			
		</div>
		
	</form>
	
</div>
<?php } ?>