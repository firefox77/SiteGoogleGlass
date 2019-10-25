<!-- begin Tag Groups plugin -->
<script>
jQuery(function() {
  if (jQuery.isFunction(jQuery.fn.tabs) ) {
    jQuery( "#<?php echo $id ?>" ).tabs(<?php echo $options_serialized ?>);
  }
});
</script>
<!-- end Tag Groups plugin -->
