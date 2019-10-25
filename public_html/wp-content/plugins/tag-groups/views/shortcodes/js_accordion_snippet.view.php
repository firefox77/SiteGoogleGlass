<!-- begin Tag Groups plugin -->
<script>
jQuery(function() {
  if (jQuery.isFunction(jQuery.fn.accordion) ) {
    jQuery( "#<?php echo $id ?>" ).accordion(<?php echo $options_serialized ?>);
  }
});
</script>
<!-- end Tag Groups plugin -->
