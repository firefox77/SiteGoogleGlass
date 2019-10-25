
      <div class="form-field">
        <label for="term-group"><?php _e( 'Tag Groups', 'tag-groups' ) ?></label>

        <select id="term-group" name="term-group<?php if ( class_exists( 'TagGroups_Premium_Group' ) ) echo '[]' ?>"<?php if ( class_exists( 'TagGroups_Premium_Group' ) ) echo ' multiple' ?>>
          <?php if ( ! class_exists( 'TagGroups_Premium_Group' ) ) : ?>
            <option value="0" selected ><?php _e( 'not assigned', 'tag-groups' ) ?></option>
          <?php endif; ?>
          <?php foreach ( $data as $term_group ) : ?>
            <option value="<?php echo $term_group['term_group']; ?>"><?php echo htmlentities( $term_group['label'], ENT_QUOTES, "UTF-8" ); ?></option>
          <?php endforeach; ?>
        </select>
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
        <input type="hidden" name="tag-groups-nonce" id="tag-groups-nonce" value="<?php echo wp_create_nonce( 'tag-groups-nonce' )
        ?>" />
        <input type="hidden" name="new-tag-created" id="new-tag-created" value="1" />
        <input type="hidden" name="tag-groups-taxonomy" id="tag-groups-taxonomy" value="<?php echo $screen->taxonomy; ?>" />
      </div>
