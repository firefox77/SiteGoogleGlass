<div class="tg_settings_tabs_content">

  <form method="POST" action="<?php echo esc_url( $_SERVER['REQUEST_URI'] ) ?>">
    <?php echo wp_nonce_field( 'tag-groups-settings', 'tag-groups-settings-nonce', true, false ) ?>
    <p>
      <?php _e( "Here you can choose a theme for the tabbed and the accordion tag cloud. The path to own themes is relative to the <i>uploads</i> folder of your WordPress installation. Leave empty if you don't use any.", 'tag-groups' ) ?>
      <span class="dashicons dashicons-editor-help chatty-mango-help-icon" data-topic="themes"></span>
    </p>

    <div class="chatty-mango-help-container chatty-mango-help-container-themes" style="display:none;">
      <p>
        <?php _e( 'New themes can be created with the <a href="http://jqueryui.com/themeroller/" target="_blank">jQuery UI ThemeRoller</a>:', 'tag-groups' ) ?>
        <ol>
          <li><?php _e( 'On the page "Theme Roller" you can customize all features or pick one set from the gallery. Finish with the "download" button.', 'tag-groups' ) ?></li>
          <li><?php _e( 'On the next page ("Download Builder") you will need to select the version 1.12.x and the components "Widget", "Accordion" and "Tabs". Make sure that before downloading you enter at the bottom as "CSS Scope" <b>.tag-groups-cloud</b> (including the dot).', 'tag-groups' ) ?></li>
          <li><?php _e( 'Then you unpack the downloaded zip file. You will need the "images" folder and the "jquery-ui.theme.min.css" file.', 'tag-groups' ) ?></li>
          <li><?php _e( 'Create a new folder inside your <i>wp-content/uploads</i> folder (for example "my-theme") and copy there these two items.', 'tag-groups' ) ?></li>
          <li><?php _e( 'Enter the name of this new folder (for example "my-theme") below.', 'tag-groups' ) ?>
          </li>
        </ol>
      </p>
    </div>
    <div class="chatty-mango-settings-container">
      <div style="width:50%;min-width:500px;float:left">
        <ul>

          <?php foreach ( $default_themes as $theme ) : ?>
            <li>
              <input type="radio" name="theme" id="tg_<?php echo $theme ?>" value="<?php echo $theme ?>"
              <?php if ( $tag_group_theme == $theme ) : ?> checked<?php endif; ?>
              />&nbsp;
              <label for="tg_ $theme . '"><?php echo $theme ?></label>
            </li>
          <?php endforeach; ?>
          <li>
            <input type="radio" name="theme" value="own" id="tg_own"
            <?php if ( ! in_array( $tag_group_theme, $default_themes ) ) : ?> checked<?php endif; ?>
            />&nbsp;<label for="tg_own">own: /wp-content/uploads/</label><input type="text" id="theme-name" name="theme-name" value="<?php if ( ! in_array( $tag_group_theme, $default_themes ) ) : echo $tag_group_theme; endif; ?>" />
          </li>
          <li>
            <input type="checkbox" name="enqueue-jquery" autocomplete="off" id="tg_enqueue-jquery" value="1"
            <?php if ( $tag_group_enqueue_jquery ) : ?> checked<?php endif; ?>/>&nbsp;
            <label for="tg_enqueue-jquery">
              <?php _e( 'Use jQuery.  (Default is on. Other plugins might override this setting.)', 'tag-groups' ) ?>
            </label>
          </li>
        </ul>
      </div>
      <div style="width: 50%; min-width: 500px; float: left">
        <h4><?php _e( 'Further options', 'tag-groups' ) ?></h4>
        <ul>
          <li>
            <input type="checkbox" name="mouseover" autocomplete="off" id="mouseover" value="1"
            <?php if ( $tag_group_mouseover ) : ?> checked<?php endif; ?>>&nbsp;
            <label for="mouseover"><?php _e( 'Tabs triggered by hovering mouse pointer (without clicking).', 'tag-groups' ) ?></label>
          </li>
          <li>
            <input type="checkbox" name="collapsible" autocomplete="off" id="collapsible" value="1"'
            <?php if ( $tag_group_collapsible ) : ?> checked<?php endif; ?>>&nbsp;
            <label for="collapsible"><?php _e( 'Collapsible tabs (toggle open/close).', 'tag-groups' ) ?></label>
          </li>
          <li>
            <input type="checkbox" name="html_description" autocomplete="off" id="html_description" value="1" ';
            <?php if ( $tag_group_html_description ) : ?> checked<?php endif; ?>>&nbsp;
            <label for="html_description"><?php _e( 'Allow HTML in tag description.', 'tag-groups' ) ?></label>
          </li>
        </ul>
      </div>
      <div style="width: 100%; min-width: 500px; float: left; padding: 20px 0;">
        <input type="hidden" id="action" name="tg_action" value="theme">
        <input class="button-primary" type="submit" name="save" value="<?php _e( "Save Theme Options", "tag-groups" ) ?>" id="submitbutton" />
      </div>
    </div>
  </form>

</div>
