<div style="margin: 50px 0 0;">
  <ul style="list-style:disc; margin-left:20px;">
  <li><?php _e( 'On the following pages we will guide you through the basic settings that you need for the most common features.', 'tag-groups' ) ?></li>
    <li><?php _e( 'You can later make changes or fine-tune the details in the Tag Groups settings.', 'tag-groups' ) ?></li>
    <li><?php _e( 'Feel free to abort the Setup Wizard any time and continue on your own path. You can also launch it again at a later time.', 'tag-groups' ) ?></li>
    <?php if ( ! $is_premium ) : ?>
      <li><?php _e( 'The wizard will offer more options after upgrading to premium.', 'tag-groups' ) ?></li>
    <?php endif; ?>
  </ul>
  <div class="chatty-mango-settings-container">
    <form method="POST" action="<?php echo $setup_wizard_next_link ?>">
      <input type="submit" value="<?php _e( 'Start' ) ?>" class="button button-primary tag-groups-wizard-submit">
    </form>
  </div>
</div>
