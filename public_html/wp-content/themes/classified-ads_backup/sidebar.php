	<?php if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		return;
	}
	?>

	<aside id="secondary" class="widget-area" role="complementary">
			<ul>
					<?php dynamic_sidebar( 'sidebar-1' ); ?>
			</ul>
	</aside>