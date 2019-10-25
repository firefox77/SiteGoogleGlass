<tr class="form-field">
  <th scope="row" valign="top"><label for="tag_widget"><?php _e( 'Tag Groups', 'tag-groups' ) ?></label></th>
  <td>
    <select id="term-group" name="term-group<?php if ( class_exists( 'TagGroups_Premium_Group' ) ) echo '[]' ?>"<?php if ( class_exists( 'TagGroups_Premium_Group' ) ) echo ' multiple' ?>>
      <?php if ( ! class_exists( 'TagGroups_Premium_Group' ) ) : ?>
        <option value="0"
        <?php if ( $tg_term->is_in_group( 0 ) ) : ?>
          selected
        <?php endif; ?> ><?php _e( 'not assigned', 'tag-groups' ) ?></option>
      <?php endif; ?>

      <?php foreach ( $data as $term_group ) : ?>
        <option value="<?php echo $term_group[ 'term_group' ]; ?>"
          <?php if ( $tg_term->is_in_group( $term_group[ 'term_group' ] ) ) : ?>
            selected
          <?php endif; ?> ><?php echo htmlentities( $term_group[ 'label' ], ENT_QUOTES, "UTF-8" ); ?>
        </option>
      <?php endforeach; ?>
    </select>
    <input type="hidden" name="tag-groups-nonce" id="tag-groups-nonce" value="<?php echo wp_create_nonce( 'tag-groups-nonce' )
    ?>" />
    <input type="hidden" name="tag-groups-taxonomy" id="tag-groups-taxonomy" value="<?php echo $screen->taxonomy; ?>" />

    <script>
    jQuery(document).ready(function () {
      jQuery('#term-group').SumoSelect({
        search: true,
        forceCustomRendering: true,
        <?php if ( class_exists( 'TagGroups_Premium_Group' ) && $tag_groups_premium_fs_sdk->is_plan_or_trial('premium') ) : ?>
        triggerChangeCombined: true,
        selectAll: true,
        captionFormatAllSelected: '<?php _e( 'all {0} selected', 'tag-groups' ) ?>',
        captionFormat: '<?php _e( '{0} selected', 'tag-groups' ) ?>',
        <?php endif; ?>
      });
    });
    </script>
    <p>&nbsp;</p>
    <p><a href="<?php echo $tag_group_admin_url ?>"><?php _e( 'Edit tag groups', 'tag-groups' ) ?></a>. (<?php _e( 'Clicking will leave this page without saving.', 'tag-groups' ) ?>)</p>
  </td>
</tr>
