<?php 

	if ( !wp_next_scheduled ( 'cau_set_schedule_mail' ) ) {
		echo '<div id="message" class="error"><p><b>'.__('Companion Auto Update was not able to set the event for sending you emails, please re-activate the plugin in order to set the event', 'companion-auto-update').'.</b></p></div>';
	}

	global $cau_db_version;

	if ( get_site_option( 'cau_db_version' ) != $cau_db_version ) {
		echo '<div id="message" class="error"><p><b>'.__('Database Update', 'companion-auto-update').' &ndash;</b> '.__('It seems like something went wrong while updating the database, please re-activate this plugin', 'companion-auto-update').'.</p></div>';
	}

	if( isset( $_POST['submit'] ) ) {

		check_admin_referer( 'cau_save_settings' );

		global $wpdb;
		$table_name = $wpdb->prefix . "auto_updates"; 

		if( isset( $_POST['plugins'] ) ) $plugins = sanitize_text_field( $_POST['plugins'] ); else $plugins = '';
		if( isset( $_POST['themes'] ) ) $themes = sanitize_text_field( $_POST['themes'] ); else $themes = '';
		if( isset( $_POST['minor'] ) ) $minor = sanitize_text_field( $_POST['minor'] ); else $minor = '';
		if( isset( $_POST['major'] ) ) $major = sanitize_text_field( $_POST['major'] ); else $major = '';
		if( isset( $_POST['translations'] ) ) $translations = sanitize_text_field( $_POST['translations'] ); else $translations = '';
		if( isset( $_POST['cau_send'] ) ) $send = sanitize_text_field( $_POST['cau_send'] ); else $send = '';
		if( isset( $_POST['cau_send_update'] ) ) $sendupdate = sanitize_text_field( $_POST['cau_send_update'] ); else $sendupdate = '';
		if( isset( $_POST['wpemails'] ) ) $wpemails = sanitize_text_field( $_POST['wpemails'] ); else $wpemails = '';
		$email 			= sanitize_text_field( $_POST['cau_email'] );

		$wpdb->query( $wpdb->prepare( "UPDATE $table_name SET onoroff = %s WHERE name = 'plugins'", $plugins ) );
		$wpdb->query( $wpdb->prepare( "UPDATE $table_name SET onoroff = %s WHERE name = 'themes'", $themes ) );
		$wpdb->query( $wpdb->prepare( "UPDATE $table_name SET onoroff = %s WHERE name = 'minor'", $minor ) );
		$wpdb->query( $wpdb->prepare( "UPDATE $table_name SET onoroff = %s WHERE name = 'major'", $major ) );
		$wpdb->query( $wpdb->prepare( "UPDATE $table_name SET onoroff = %s WHERE name = 'translations'", $translations ) );
		$wpdb->query( $wpdb->prepare( "UPDATE $table_name SET onoroff = %s WHERE name = 'email'", $email ) );
		$wpdb->query( $wpdb->prepare( "UPDATE $table_name SET onoroff = %s WHERE name = 'send'", $send ) );
		$wpdb->query( $wpdb->prepare( "UPDATE $table_name SET onoroff = %s WHERE name = 'sendupdate'", $sendupdate ) );
		$wpdb->query( $wpdb->prepare( "UPDATE $table_name SET onoroff = %s WHERE name = 'wpemails'", $wpemails ) );

		echo '<div id="message" class="updated"><p><b>'.__( 'Settings saved.' ).'</b></p></div>';

	}

	if( isset( $_GET['welcome'] ) ) {

		echo '<div class="welcome-to-cau welcome-bg">
			<h2>'.__( 'Welcome to Companion Auto Update', 'companion-auto-update' ).'</h2>
			<div class="welcome-column welcome-column-first welcome-column-half">
				<h3>'.__( 'You\'re set and ready to go', 'companion-auto-update' ).'</h3>
				<p>'.__( 'The plugin is all set and ready to go with the recommended settings, but if you\'d like you can change them below.' ).'</p>
			</div><div class="welcome-column welcome-column-quarter">
				<h3>'.__( 'Get Started' ).'</h3>
				<ul>
					<li><a href="'.cau_url( 'pluginlist' ).'">'.__( 'Select plugins', 'companion-auto-update' ).'</a></li>
					<li><a href="'.cau_url( 'schedule' ).'">'.__( 'Advanced settings', 'companion-auto-update' ).'</a></li>
				</ul>
			</div><div class="welcome-column welcome-column-quarter">
				<h3>'.__( 'More Actions' ).'</h3>
				<ul>
					<li><a href="http://codeermeneer.nl/cau_poll/" target="_blank">'.__('Give feedback', 'companion-auto-update').'</a></li>
					<li><a href="https://translate.wordpress.org/projects/wp-plugins/companion-auto-update/" target="_blank">'.__( 'Help us translate', 'companion-auto-update' ).'</a></li>
		
				</ul>
			</div>
		</div>';
	}

	?>

<div class="cau-column-wide">
	
	<form method="POST">

	<table class="form-table">
		<tr>
			<th scope="row"><?php _e('Auto Updater', 'companion-auto-update');?></th>
			<td>
				<fieldset>

					<?php

					global $wpdb;
					$table_name = $wpdb->prefix . "auto_updates"; 

					$cau_configs = $wpdb->get_results( "SELECT * FROM $table_name" );

					echo '<p><input id="'.$cau_configs[0]->name.'" name="'.$cau_configs[0]->name.'" type="checkbox"';
					if( $cau_configs[0]->onoroff == 'on' ) echo 'checked';
					echo '/> <label for="'.$cau_configs[0]->name.'">'.__('Auto update plugins?', 'companion-auto-update').'</label></p>';

					echo '<p><input id="'.$cau_configs[1]->name.'" name="'.$cau_configs[1]->name.'" type="checkbox"';
					if( $cau_configs[1]->onoroff == 'on' ) echo 'checked';
					echo '/> <label for="'.$cau_configs[1]->name.'">'.__('Auto update themes?', 'companion-auto-update').'</label></p>';


					echo '<p><input id="'.$cau_configs[2]->name.'" name="'.$cau_configs[2]->name.'" type="checkbox"';
					if( $cau_configs[2]->onoroff == 'on' ) echo 'checked';
					echo '/> <label for="'.$cau_configs[2]->name.'">'.__('Auto update minor core updates?', 'companion-auto-update').' <code class="majorMinorExplain">4.0.0 > 4.0.1</code></label></p>';


					echo '<p><input id="'.$cau_configs[3]->name.'" name="'.$cau_configs[3]->name.'" type="checkbox"';
					if( $cau_configs[3]->onoroff == 'on' ) echo 'checked';
					echo '/> <label for="'.$cau_configs[3]->name.'">'.__('Auto update major core updates?', 'companion-auto-update').' <code class="majorMinorExplain">4.0.0 > 4.1.0</code></label></p>';

					echo '<p><input id="'.$cau_configs[8]->name.'" name="'.$cau_configs[8]->name.'" type="checkbox"';
					if( $cau_configs[8]->onoroff == 'on' ) echo 'checked';
					echo '/> <label for="'.$cau_configs[8]->name.'">'.__('Auto update translation files?', 'companion-auto-update').'</label></p>';

					?>

				</fieldset>
			</td>
		</tr>
	</table>

	<div class="cau_spacing"></div>

	<h2 class="title"><?php _e( 'Email Notifications', 'companion-auto-update' );?></h2>
	<p><?php _e( 'Email notifications are send once a day, you can choose what notifications to send below.', 'companion-auto-update' );?></p>

	<?php
	if( $cau_configs[4]->onoroff == '' ) $toemail = get_option('admin_email'); 
	else $toemail = $cau_configs[4]->onoroff;
	?>

	<table class="form-table">
		<tr>
			<th scope="row"><?php _e( 'Update available', 'companion-auto-update' );?></th>
			<td>
				<p>
					<input id="cau_send" name="cau_send" type="checkbox" <?php if( $cau_configs[5]->onoroff == 'on' ) { echo 'checked'; } ?> />
					<label for="cau_send"><?php _e('Send me emails when an update is available.', 'companion-auto-update');?></label>
				</p>
			</td>
		</tr>
		<tr>
			<th scope="row"><?php _e( 'Successful update', 'companion-auto-update' );?></th>
			<td>
				<p>
					<input id="cau_send_update" name="cau_send_update" type="checkbox" <?php if( $cau_configs[6]->onoroff == 'on' ) { echo 'checked'; } ?> />
					<label for="cau_send_update"><?php _e('Send me emails when something has been updated.', 'companion-auto-update');?></label>
				</p>
			</td>
		</tr>
		<tr>
			<th scope="row"><?php _e( 'Email Address' );?></th>
			<td>
				<p>
					<label for="cau_email"><?php _e('To', 'companion-auto-update');?>:</label>
					<input type="text" name="cau_email" id="cau_email" class="regular-text" placeholder="<?php echo get_option('admin_email'); ?>" value="<?php echo esc_html( $toemail ); ?>" />
				</p>

				<p class="description"><?php _e('Seperate email addresses using commas.', 'companion-auto-update');?></p>
			</td>
		</tr>
	</table>

	<div class="cau_spacing"></div>

	<h2 class="title"><?php _e('Core notifications', 'companion-auto-update');?></h2>
	<p><?php _e('Core notifications are handled by WordPress and not by this plugin. You can only disable them, changing your email address in the settings above will not affect these notifications.', 'companion-auto-update');?></p>

	<table class="form-table">
		<tr>
			<th scope="row"><?php _e('Core notifications', 'companion-auto-update');?></th>
			<td>
				<p>
					<input id="wpemails" name="wpemails" type="checkbox" <?php if( $cau_configs[9]->onoroff == 'on' ) { echo 'checked'; } ?> />
					<label for="wpemails"><?php _e( 'By default WordPress sends an email when a core update has occurred. Uncheck this box to disable these emails.', 'companion-auto-update' );?></label>
				</p>
			</td>
		</tr>
	</table>

	<?php wp_nonce_field( 'cau_save_settings' ); ?>	

	<?php submit_button(); ?>

	</form>

</div><div class="cau-column-small">

	<div class="welcome-to-cau love-bg cau-show-love cau-dashboard-box">
		<h3><?php _e( 'Like our plugin?', 'companion-auto-update' ); ?></h3>
		<p><?php _e('Companion Auto Update is free to use. It has required a great deal of time and effort to develop and you can help support this development by making a small donation.<br />You get useful software and we get to carry on making it better.', 'companion-auto-update'); ?></p>
		<a href="https://wordpress.org/support/plugin/companion-auto-update/reviews/#new-post" target="_blank" class="cau-button rate-button">
			<span class="dashicons dashicons-star-filled"></span> 
			<?php _e('Rate us (5 stars?)', 'companion-auto-update'); ?>
		</a>
		<a href="<?php echo cau_donateUrl(); ?>" target="_blank" class="cau-button donate-button">
			<span class="dashicons dashicons-heart"></span> 
			<?php _e('Donate to help development', 'companion-auto-update'); ?>
		</a>
		<p style="font-size: 12px; color: #BDBDBD;">Donations via PayPal. Amount can be changed.</p>
	</div>

</div>
