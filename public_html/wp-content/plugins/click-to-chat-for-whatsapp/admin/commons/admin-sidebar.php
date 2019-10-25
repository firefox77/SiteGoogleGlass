<?php
/**
 * sidebar in admin area - plugin settings page.
 * 
 * @uses at settings_page.php
 * plan to use in sp_customize_styles.php
 * 
 */

if ( ! defined( 'ABSPATH' ) ) exit;

?>



<div class="wca-plugin">

        <div class="col s10 offset-s2 offset-m3 offset-xl2">
            <div class="card blue-grey darken-1" style="margin-bottom: 0;">
                <div class="card-content white-text">
                    <span class="card-title">Click - WordPress Plugin for WhatsApp</span>
                    <br>
                    <p>Add your own Style - Custom HTML, Image / GIF</p>
                    <br>
                    <p>Predefined Styles</p><br>
                    <b><a target="_blank" href="https://www.holithemes.com/plugins/click/style-6/">Style-6</a></b><br><br>
                    <b><a target="_blank" href="https://www.holithemes.com/plugins/click/style-7/">Style-7</a></b><br><br>
                    <b><a target="_blank" href="https://www.holithemes.com/plugins/click/style-8/">Style-8</a></b><br><br>
                    <br>
                    <p>WooCommerce</p>
                    <br>
                    <p>WhatsApp Chat</p>
                    <br>
                    <p>WhatsApp Group chat</p>
                    <br>
                    <p>WhatsApp Share</p>
                    <br>
                    <p>Google Analytics, FB Analytics, FB Pixel</p>
                    <br>
                    <p>Predefined text</p>
                    <br>
                    <p>Placeholders - {{product}}, {{title}}, {{url}}</p>
                    <br>
                    <p>Different styles based on Device - Mobile / Desktop</p>
                    <br>
                    <p>Different positions based on Device - Mobile / Desktop</p>
                    <br>
                    <p>Hide on Selected Days in a Week</p>
                    <br>
                    <p>Hide on Selected time range</p>
                    <br>
                    <p>Display Floating Style only after user scroll selected px of screen</p>
                    <br>
                    <p>Hide based on category, post id, post type</p>
                    <br>
                    <p>Shortcodes</p>
                    <br>
                    <p>Animations</p>
                    <br>
                    <p>Seperate Pre-filled text for WooCommerce single product pages</p>
                    <br>
                    <p>much more ... </p>

                </div>
                <div class="card-action">
                    <a target="_blank" href="https://www.holithemes.com/go/click"><?php _e( 'Documentation/ Demo' , 'click-to-chat-for-whatsapp' ) ?></a>
                    <!-- todo - update the link -->
                    <a target="_blank" href="https://www.holithemes.com/shop/"><?php _e( 'BUY' , 'click-to-chat-for-whatsapp' ) ?></a>
                </div>
            </div>
            <small class="admin_sidebar_hide_option" onclick="ccw_hide_admin_sidebar_card()" style="cursor: pointer;">Hide this card</small>
        </div>

</div>