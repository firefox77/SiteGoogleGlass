<form role="search" method="get" class="puremag-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
<label>
    <span class="screen-reader-text"><?php echo esc_html_x( 'Search for:', 'label', 'puremag' ); ?></span>
    <input type="search" class="puremag-search-field" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'puremag' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
</label>
<input type="submit" class="puremag-search-submit" value="<?php echo esc_attr_x( 'Search', 'submit button', 'puremag' ); ?>" />
</form>