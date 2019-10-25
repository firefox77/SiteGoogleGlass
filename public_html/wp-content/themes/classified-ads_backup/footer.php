<?php
/**
 * The template for displaying the footer
 */
?>
 <footer>
	<div id="footer"> 
		<details class="deklaracia">
			<summary><?php _e('All rights reserved', 'classified-ads'); ?> &copy; <?php bloginfo('name'); ?></summary>
			<p><a href="http://wordpress.org/" title="<?php esc_attr_e( 'WP', 'classified-ads' ); ?>"><?php printf( __( 'Powered by %s', 'classified-ads' ), 'WordPress' ); ?></a></p>
			<p><a href="<?php echo esc_url(__('http://seosthemes.com/', 'classified-ads')); ?>" target="_blank"><?php _e('Theme by SEOS', 'classified-ads'); ?></a></p>	
		</details>
   </div> 
</footer>
<?php wp_footer();?>
</body>
</html>