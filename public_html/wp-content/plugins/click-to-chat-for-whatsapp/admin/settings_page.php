<?php
/**
* options page
* content of this page load / continue at admin_page.php
*
* @package ccw
* @subpackage Administration
* @since 1.0
*/

if ( ! defined( 'ABSPATH' ) ) exit;

?>

<div class="wrap">

    <?php settings_errors(); ?>
    
    <div class="row">

        <div class="col s12 m12 xl6 options">
            <form action="options.php" method="post" class="col s12">
                <?php settings_fields( 'ccw_settings_group' ); ?>
                <?php do_settings_sections( 'ccw_options_settings' ) ?>
                <?php submit_button() ?>
            </form>
        </div>
        
        <div class="col s12 m12 xl6 admin_sidebar">
          <div class="wca_card" style="display: none;">
            <?php include_once 'commons/admin-sidebar.php'; ?>
          </div>
        </div>    

    </div>
        
    <hr> <br> <br>


    <div class="row">

    <div class="col s12 m12 l12 xl9">
    
    <div class="row">
    
        
        <div class="col s12 m6">
          <div class="card blue-grey darken-1">
            <div class="card-content white-text">
              <span class="card-title"><?php _e( 'Plugin Review' , 'click-to-chat-for-whatsapp' ) ?></span>
              <br>
              <p><?php _e( 'If you like the plugin, Support the Developers' , 'click-to-chat-for-whatsapp' ) ?></p>
              <br>
              <p><?php _e( 'By giving 5 Star rating' , 'click-to-chat-for-whatsapp' ) ?></p>
            </div>
            <div class="card-action">
              <a target="_blank" href="https://wordpress.org/support/plugin/click-to-chat-for-whatsapp/reviews/#new-post"><?php _e( '' , 'click-to-chat-for-whatsapp' ) ?>Plugin Review</a>
            </div>
          </div>
        </div>

    
        <div class="col s12 m6">
          <div class="card blue-grey darken-1">
            <div class="card-content white-text">
              <span class="card-title"><?php _e( 'Click - premium plugin' , 'click-to-chat-for-whatsapp' ) ?></span>
              <br>
              <p><?php _e( 'Add your own style' , 'click-to-chat-for-whatsapp' ) ?></p>
              <br>
              <p><?php _e( 'WooCommerce' , 'click-to-chat-for-whatsapp' ) ?></p>
            </div>
            <div class="card-action">
              <a target="_blank" href="https://www.holithemes.com/plugins/click/"><?php _e( '' , 'click-to-chat-for-whatsapp' ) ?>HoliThemes Click</a>
            </div>
          </div>
        </div>

        
    </div>

    </div>


</div>