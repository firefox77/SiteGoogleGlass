<div class="tg_premium_promotion_main_box">
  <h1><?php _e( 'Get more features', 'tag-groups' ) ?></h1>
  <p><?php printf( __( 'The <b>Tag Groups</b> plugin can be extended by <a %s>Tag Groups Premium</a>, which offers you many more useful features to take your tags to the next level:', 'tag-groups' ), 'href="https://chattymango.com/tag-groups-premium/?pk_campaign=tg&pk_kwd=dashboard" target="_blank"' ) ?></p>
  <ul style="list-style:disc;">
    <li style="padding:0 1em; margin-left:1em;"><?php _e( 'The <b>Shuffle Box</b>, a filterable tag cloud: Filter your tags live by group or by name with a nifty animation. See the image below.', 'tag-groups' ) ?></li>
    <li style="padding:0 1em; margin-left:1em;"><?php _e( 'A <b>tag input tool</b> on the post edit screen allows you to work with tags on two levels: first select the group, and then choose among the tags of that group.', 'tag-groups' ) ?></li>
    <li style="padding:0 1em; margin-left:1em;"><?php _e( '<b>Color coding</b> minimizes the risk of accidentally creating a new tag with a typo: New tags are green, tags that changed their groups are yellow.', 'tag-groups' ) ?></li>
    <li style="padding:0 1em; margin-left:1em;"><?php _e( '<b>Control new tags:</b> Optionally restrict the creation of new tags or prevent moving tags to another group on the post edit screen. These restrictions can be overridden per user role.', 'tag-groups' ) ?></li>
    <li style="padding:0 1em; margin-left:1em;"><?php _e( '<b>Bulk-add tags:</b> If you often need to insert the same set of tags, simply join them in one group and insert them with the push of a button.', 'tag-groups' ) ?></li>
    <li style="padding:0 1em; margin-left:1em;"><?php _e( 'The option to add each term to <b>multiple groups</b>.', 'tag-groups' ) ?></li>
    <li style="padding:0 1em; margin-left:1em;"><?php _e( '<b>Filter posts</b> on the front end by tag group through a URL parameter.', 'tag-groups' ) ?></li>
    <li style="padding:0 1em; margin-left:1em;"><?php _e( '<b>Dynamic Post Filter</b>: While visitors choose from available tags, the list shows posts that match these tags. Tags are organized under groups, which allows for useful logical operators. (e.g. show products that are red OR blue (group "color") AND have a size of M OR XL OR XXL.)', 'tag-groups' ) ?></li>
    <li style="padding:0 1em; margin-left:1em;"><?php _e( 'Display <b>post tags</b> segmented into groups under you posts.', 'tag-groups' ) ?></li>
    <li style="padding:0 1em; margin-left:1em;"><?php _e( '<b>New tag clouds:</b> Display your tags in a table or tags from multiple groups combined into one tag cloud.', 'tag-groups' ) ?></li>
  </ul>
  <p><?php printf( __( 'See the complete <a %1$s>feature comparison</a> or check out the <a %2$s>demos</a>.', 'tag-groups' ), 'href="https://chattymango.com/tag-groups-base-premium-comparison/?pk_campaign=tg&pk_kwd=dashboard" target="_blank"', 'href="https://demo.chattymango.com/tag-groups-premium-demo-page/?pk_campaign=tg&pk_kwd=dashboard" target="_blank"' ) ?></p>
  <?php if ( ! $tag_groups_premium_fs_sdk->is_paying() ) : ?>
    <div class="tg_premium_promotion_call_to_action">
      <span style="float:right; margin: 0 10px;"><a href="<?php echo admin_url( 'admin.php?page=tag-groups-settings-pricing&trial=true' ) ?>" class="tg_premium_promotion_call_to_action_button"><?php _e( 'Try Premium', 'tag-groups' ) ?></a></span>
      <h3>
        <?php _e( 'Start your 7-day free trial!', 'tag-groups' ) ?><br/>
        <?php _e( 'All features. Cancel anytime.', 'tag-groups' ) ?>
      </h3>
    </div>
  <?php endif; ?>
</div>
<div class="tg_premium_promotion_right_image_box">
  <img src="<?php echo TAG_GROUPS_PLUGIN_URL ?>/assets/images/cm-tgp-icon-200x200.png" alt="Tag Groups Premium icon" class="tg_premium_promotion_logo"/>
</div>

<div class="tg_premium_promotion_right_image_box">
  <img src="<?php echo TAG_GROUPS_PLUGIN_URL ?>/assets/images/tgp-meta-box.png" alt="Tag Groups Meta Box" title="Replace the default tag meta box with one that understands your tag groups!" class="tg_premium_promotion_right_image"/>
  <div class="tg_premium_promotion_right_image_box_caption"><?php _e( 'Replace the default tag meta box with one that understands your tag groups!', 'tag-groups' ) ?></div>
</div>

<div class="tg_premium_promotion_bottom_image_box">
  <a href="https://chattymango.com/tag-groups-premium/?pk_campaign=tg&pk_kwd=dashboard" target="_blank">
    <img src="<?php echo TAG_GROUPS_PLUGIN_URL ?>/assets/images/tgp-dpf-toggles.png" class="tg_premium_promotion_bottom_image" />
  </a>
  <div class="tg_premium_promotion_bottom_image_box_caption"><?php _e( 'Visitors can search your posts by group and tags.', 'tag-groups' ) ?></div>
</div>

<div class="tg_premium_promotion_bottom_image_box">
  <a href="https://chattymango.com/tag-groups-premium/?pk_campaign=tg&pk_kwd=dashboard" target="_blank">
    <img src="<?php echo TAG_GROUPS_PLUGIN_URL ?>/assets/images/tag-groups-premium-shuffle-box-animated-800.gif" class="tg_premium_promotion_bottom_image" />
  </a>
  <div class="tg_premium_promotion_bottom_image_box_caption"><?php _e( 'Display a tag cloud that can filter tags by tag name and by group.', 'tag-groups' ) ?></div>
</div>
