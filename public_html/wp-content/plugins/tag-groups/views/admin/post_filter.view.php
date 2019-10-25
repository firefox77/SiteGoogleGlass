<select name="tg_filter_posts_value">
  <option value=""><?php
  _e( 'Filter by tag group', 'tag-groups' ); ?></option>
  <?php
  foreach ( $data as $term_group => $label ) {
    printf( '<option value="%s"%s>%s</option>', $term_group, ( '' != $current_term_group && $term_group == $current_term_group ) ? ' selected="selected"' : '', htmlentities( $label, ENT_QUOTES, "UTF-8" ) );
  }
  ?>
</select>
<script>
jQuery(document).ready(function(){
  jQuery('#cat').hide();
});
</script>
