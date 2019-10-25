<?php
/**
*   Using .html() instead of .text() to avoid ambersands displaying
*/
?>

<script>
jQuery(document).ready(function () {
  var sel_filter;
  // check if we have an bulk action menu
  if (jQuery("select[name='term-group-top']").length){
    sel_filter = jQuery("<select id='tag_filter' name='term-filter' style='margin-left: 20px;'>").insertAfter("select[name='term-group-top']");
  } else {
    sel_filter = jQuery("<select id='tag_filter' name='term-filter' style='margin-left: 20px;'>").insertAfter("select[name='action']");
  }
  sel_filter.append(jQuery("<option>").attr("value", "-1").html("<?php
  _e( 'Filter off', 'tag-groups' )
  ?>"));
  <?php foreach ( $data as $term_group ) : ?>
  sel_filter.append(jQuery("<option>").attr("value", "<?php echo $term_group['term_group'] ?>").html("<?php echo htmlentities( $term_group['label'], ENT_QUOTES, "UTF-8" )?>"));
  <?php endforeach; ?>
  jQuery("#tag_filter option[value=<?php echo $tag_filter ?>]").prop('selected', true);
});
</script>
