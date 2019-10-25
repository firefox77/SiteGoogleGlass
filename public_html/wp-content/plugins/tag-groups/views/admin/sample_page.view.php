<p>
  <?php printf( __( '%s created this sample page in the Setup Wizard of the <b>Tag Groups</b> plugin. You can safely edit and delete it or keep it for future reference.', 'tag-groups' ), $author_display_name ) ?>
</p>

<p>
  <?php _e( 'The following shortcodes use a variety of parameters so that you can get an idea of the options. Feel free to generate a new sample page with more features after upgrading the plugin.', 'tag-groups' ) ?>
</p>

<p>
  <?php _e( 'Please find links to the documentation in the Tag Groups settings.', 'tag-groups' ) ?>
</p>
<hr />


<?php if ( ! $premium_shortcodes ) : // Base plan doesn't have themes ?>

  <h2><?php _e( 'Tabbed Tag Cloud', 'tag-groups' ) ?></h2>
  <p>
    [tag_groups_cloud custom_title="We have {count} posts for this tag." hide_empty=0 hide_empty_tabs=1] 
  </p>
  <hr />

  <h2><?php _e( 'Accordion Tag Cloud', 'tag-groups' ) ?></h2>
  <p>
    [tag_groups_accordion separator="|" prepend="#" hide_empty=0 mouseover=1 heightstyle=content hide_empty_content=1]
  </p>
  <hr />

  <h2><?php _e( 'Alphabetical Tag Cloud', 'tag-groups' ) ?></h2>
  <p>
    [tag_groups_alphabet_tabs exclude_letters="äöüß" hide_empty=0]
  </p>
  <hr />

<?php else: ?>

  <h2><?php _e( 'Tabbed Tag Cloud', 'tag-groups' ) ?></h2>
  <p>
    [tag_groups_cloud div_class="tag-groups-theme-green" append="{count}" custom_title="We have {count} posts for this tag." hide_empty=0 hide_empty_tabs=1] 
  </p>
  <hr />

  <h2><?php _e( 'Accordion Tag Cloud', 'tag-groups' ) ?></h2>
  <p>
    [tag_groups_accordion separator="|" prepend="#" hide_empty=0 mouseover=1 heightstyle=content hide_empty_content=1]
  </p>
  <hr />

  <h2><?php _e( 'Alphabetical Tag Cloud', 'tag-groups' ) ?></h2>
  <p>
    [tag_groups_alphabet_tabs exclude_letters="äöüß" hide_empty=0]
  </p>
  <hr />

  <h2><?php _e( 'Shuffle Box', 'tag-groups' ) ?></h2>
  <p>
    [tag_groups_shuffle_box prepend="{" append="}" custom_title="{count} posts for all groups" hide_empty=0]
  </p>
  <hr />

  <h2><?php _e( 'Table Tag Cloud', 'tag-groups' ) ?></h2>
  <p>
    [tag_groups_table table_class="tag-groups-theme-slategray" prepend="#" append="{count}" hide_empty=0 hide_empty_columns=1]
  </p>
  <hr />

  <h2><?php _e( 'Combined Tag Cloud', 'tag-groups' ) ?></h2>
  <p>
    [tag_groups_combined_cloud hide_empty=0]
  </p>
  <hr />

<?php endif; ?>


<?php if ( $premium_shortcodes && $tag_groups_premium_fs_sdk->is_plan_or_trial('premium') ) : ?>

  <h2><?php _e( 'Dynamic Post Filter With Toggles', 'tag-groups' ) ?></h2>
  <p><?php _e( 'The post filter works best if you use the same tags that were assigned to tag groups with published posts.', 'tag-groups' ) ?></p>
  <p>
    [tag_groups_dpf_toggle_messages]
  </p>
  <p>
    [tag_groups_dpf_toggle_menu operator="IN AND" persistent_filter=20 pager=1 display_amount=1 transition=fade accordion=1 div_class=dpf_toggle_menu_dark caching_time=10 default_show_posts=1]
  </p>
  <p>
    [tag_groups_dpf_toggle_body div_class=dpf_toggle_menu_dark]
  </p>

<?php endif; ?>

<div style="clear:both;"></div>
<p>Created by <a href="https://chattymango.com" >Chatty Mango</a></p>
