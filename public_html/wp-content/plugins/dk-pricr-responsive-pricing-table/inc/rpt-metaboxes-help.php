<?php 

/* Hooks the metabox. */
add_action('admin_init', 'dmb_rpts_add_help', 1);
function dmb_rpts_add_help() {
	add_meta_box( 
		'rpt_pricing_table_help', 
		'<span class="dashicons dashicons-editor-code"></span> '.__('Shortcode', RPT_TXTDM ), 
		'dmb_rpts_help_display', // Below
		'rpt_pricing_table', 
		'side', 
		'high'
	);
}


/* Displays the metabox. */
function dmb_rpts_help_display() { ?>

	<div class="dmb_side_block">
		<p>
			<?php 
				global $post;
				$slug = '';
				$slug = $post->post_name;
				$shortcode = '<span style="display:inline-block;border:solid 2px lightgray; background:white; padding:0 8px; font-size:13px; line-height:25px; vertical-align:middle;">[rpt name="'.$slug.'"]</span>';
				$shortcode_unpublished = "<span style='display:inline-block;color:#849d3a'>" . /* translators: Leave HTML tags */ __("<strong>Publish</strong> your pricing table before you can see you shortcode.", RPT_TXTDM ) . "</span>";
				echo ($slug != '') ? $shortcode : $shortcode_unpublished;
			?>
		</p>
		<p>
			<?php /* translators: Leave HTML tags */ _e('To display your Pricing Table on your site, copy-paste the <strong>[Shortcode]</strong> above in your post/page.', RPT_TXTDM ) ?>
		</p>	
	</div>

	<div class="dmb_side_block">
		<div class="dmb_help_title">
			Get support
		</div>
		<a target="_blank" href="https://wpdarko.com/ask-for-support/">Submit a ticket</a><br/>
		<a target="_blank" href="https://wpdarko.com/docs/guide-responsive-pricing-table/">View documentation</a>
	</div>

<?php } ?>