<?php 

/* Hooks the metabox. */
add_action('admin_init', 'dmb_rpts_add_pro', 1);
function dmb_rpts_add_pro() {
	add_meta_box( 
		'rpt_pricing_table_pro', 
		'<span class="dashicons dashicons-unlock" style="color:#8ea93d;"></span> Get PRO&nbsp;', 
		'dmb_rpts_pro_display', // Below
		'rpt_pricing_table', 
		'side', 
		'high'
	);
}


/* Displays the metabox. */
function dmb_rpts_pro_display() { ?>

	<div class="dmb_side_block">
		<div class="dmb_side_block_title">
			New designs
		</div>
		Choose from different visual layouts.
	</div>

	<div class="dmb_side_block">
		<div class="dmb_side_block_title">
			Plan equalizer
		</div>
		Have your plan heights even out.
	</div>

	<div class="dmb_side_block">
		<div class="dmb_side_block_title">
			Tooltips
		</div>
		Add info bubbles to plan features.
	</div>

	<a class="dmb_big_button_primary dmb_see_pro" target="_blank" href="http://wpdarko.com/items/responsive-pricing-table-pro">
		Check out PRO features&nbsp;
	</a>

	<span style="display:block;margin-top:15px; font-size:12px; color:#0073AA; line-height:20px;">
		<span class="dashicons dashicons-cart"></span> Discount code 
		<strong>7832949</strong> (10% OFF)
	</span>

<?php } ?>