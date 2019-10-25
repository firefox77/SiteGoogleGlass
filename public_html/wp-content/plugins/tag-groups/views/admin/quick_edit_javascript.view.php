<script>
function set_inline_tag_group_selected(termGroupsSelectedJson, nonce) {
  var termGroupsSelected = JSON.parse(termGroupsSelectedJson);
  inlineEditTax.revert();
  var tagGroupsSelectElement = document.getElementById('term-group-option');
  var nonceInput = document.getElementById('tag-groups-option-nonce');
  nonceInput.value = nonce;
  for (i = 0; i < tagGroupsSelectElement.options.length; i++) {
    if (termGroupsSelected.indexOf(parseInt(tagGroupsSelectElement.options[i].value)) > -1) {
      tagGroupsSelectElement.options[i].setAttribute("selected", "selected");
    } else {
      tagGroupsSelectElement.options[i].removeAttribute("selected");
    }
    if (i + 1 == tagGroupsSelectElement.options.length) callSumoSelect();
  }
}

function callSumoSelect() {
  setTimeout(function() {
    jQuery('#term-group-option').SumoSelect({
      search: true,
      forceCustomRendering: true,
      <?php if ( class_exists( 'TagGroups_Premium_Group' ) && $tag_groups_premium_fs_sdk->is_plan_or_trial('premium') ) : ?>
      selectAll: true,
      captionFormatAllSelected: '<?php _e( 'all {0} selected', 'tag-groups' ) ?>',
      captionFormat: '<?php _e( '{0} selected', 'tag-groups' ) ?>',
      <?php endif; ?>
    });
  }, 50);
}
</script>
