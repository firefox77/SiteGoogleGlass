<?php
/*
* 	constructing the action menu
*
*   Using .html() instead of .text() to avoid ampersands displaying
*/
?>
<script>
jQuery(document).ready(function () {
  jQuery('<option>').val('assign').html('<?php _e( 'Assign to', 'tag-groups' ) ?>').appendTo("select[name='action']");
  jQuery('<option>').val('assign').html('<?php _e( 'Assign to', 'tag-groups' ) ?>').appendTo("select[name='action2']");
  var sel_top = jQuery("<select name='term-group-top'>").insertAfter("select[name='action']");
  var sel_bottom = jQuery("<select name='term-group-bottom'>").insertAfter("select[name='action2']");
  <?php foreach ( $data as $term_group ) : ?>
  sel_top.append(jQuery("<option>").attr("value", "<?php echo $term_group['term_group'] ?>").html("<?php echo htmlentities( $term_group['label'], ENT_QUOTES, "UTF-8" ) ?>"));
  sel_bottom.append(jQuery("<option>").attr("value", "<?php echo $term_group['term_group'] ?>").html("<?php echo htmlentities( $term_group['label'], ENT_QUOTES, "UTF-8" ) ?>"));
  <?php endforeach; ?>

  <?php if ( isset( $_GET['orderby'] ) && $_GET['orderby'] == 'term_group' ) : ?>
  jQuery('th#term_group').addClass('sorted');
  <?php if ( isset( $_GET['order'] ) && $_GET['order'] == 'asc' ) : ?>
  jQuery('th#term_group').addClass('asc');
  <?php else: ?>
  jQuery('th#term_group').addClass('desc');
  <?php endif; ?>
  <?php else: ?>
  jQuery('th#term_group').addClass('sortable');
  <?php endif; ?>

  jQuery('[name="term-group-top"]').change(function () {
    jQuery('[name="action"]').val('assign');
    jQuery('[name="action2"]').val('assign');
    var selected = jQuery(this).val();
    jQuery('[name="term-group-bottom"]').val(selected);
  });
  jQuery('[name="term-group-bottom"]').change(function () {
    jQuery('[name="action"]').val('assign');
    jQuery('[name="action2"]').val('assign');
    var selected = jQuery(this).val();
    jQuery('[name="term-group-top"]').val(selected);
  });
});
</script>
