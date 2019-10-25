<?php
/**
 * @uses ccw.php - initilaze at init
 * adds floatings style using add_action - wp_footer 
 * 
 * get values, check things ..
 * include styles.php and 
 *  styles.php includes selected style template
 *      from commons/styles-list
 * 
 * @package ccw
 * @since 1.4  -  merge of chatbot.php, chatbot-mobile.php
 */



if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'HT_CCW_Chat' ) ) :
    
class HT_CCW_Chat {


    // constructor
    public function __construct() {
        $this->floating_device();
    }

    /**
     * add_action - wp_footer
     *
     * @uses this class contructor
     */
    public function floating_device() {
        add_action( 'wp_footer', array( $this, 'chat' ) );
    }




    /**
	 * Display - styles
	 * @uses - add_action hook - wp_footer
	 * @since 1.0
	 */
    function chat() {

        // similar - ht_ccw()->variables->get_option['enable'];
        $values = ht_ccw()->variables->get_option;
        
        $enable = $values['enable'];
        $num = $values['number'];
        $val = $values['input_placeholder'];
        // $val_form_db = $values['input_placeholder'];
        // $val = __( $val_form_db, 'click-to-chat-for-whatsapp' );

        $position = $values['position'];

        // $style = $values['style'];


        // Analytics
        $google_analytics = '';
        $ga_category = '';
        $ga_action = '';
        $ga_label = '';



        if ( isset( $values['google_analytics'] ) ) {
            $google_analytics = 'true';

            $ht_ccw_ga = get_option( 'ht_ccw_ga' );

            $ga_category = $ht_ccw_ga['ga_category'];
            $ga_action = $ht_ccw_ga['ga_action'];
            $ga_label = $ht_ccw_ga['ga_label'];

        }


        $fb_analytics = '';
        $fb_event_name = '';
        $p1_value = '';
        $p2_value = '';
        $p3_value = '';
        $p1_name = '';
        $p2_name = '';
        $p3_name = '';

        if ( isset( $values['fb_analytics'] ) ) {
            $fb_analytics = 'true';

            $ht_ccw_fb = get_option( 'ht_ccw_fb' );

            $fb_event_name = $ht_ccw_fb['fb_event_name'];
            $p1_value = $ht_ccw_fb['p1_value'];
            $p2_value = $ht_ccw_fb['p2_value'];
            $p3_value = $ht_ccw_fb['p3_value'];
            $p1_name = $ht_ccw_fb['p1_name'];
            $p2_name = $ht_ccw_fb['p2_name'];
            $p3_name = $ht_ccw_fb['p3_name'];
        }

        $page_title = esc_html( get_the_title() );

        /**
         * pass values to JavaScript 
         * 
         * @var string google_analytics - is enable
         * @var string fb_analytics  - is enable
         * 
         */
        $ht_ccw_var = array(
            'page_title' => $page_title,


            'google_analytics' => $google_analytics,
            'ga_category' => $ga_category,
            'ga_action' => $ga_action,
            'ga_label' => $ga_label,


            'fb_analytics' => $fb_analytics,
            
            'fb_event_name' => $fb_event_name,
            'p1_value' => $p1_value,
            'p2_value' => $p2_value,
            'p3_value' => $p3_value,
            'p1_name' => $p1_name,
            'p2_name' => $p2_name,
            'p3_name' => $p3_name,

            );

        // push values to $ht_ccw_var
        // if ( 'php' == $device_based_on ) {
        //     $ht_ccw_var['php_ismobile'] = '2';
        // }

        wp_localize_script( 'ccw_app', 'ht_ccw_var', $ht_ccw_var );



        // enable
        if( 1 == $enable ) {
            return;
        }
        
        // $ccw_option_values =  get_option('ccw_options');
        
        $this_page_id = get_the_ID();
        $pages_list_tohide = $values['list_hideon_pages'];
        $pages_list_tohide_array = explode(',', $pages_list_tohide);
        
        
        if( ( is_single() || is_page() ) && in_array( $this_page_id, $pages_list_tohide_array ) ) {
            return;
        }
        
        
        if ( is_single() && isset( $values['hideon_posts'] ) ) {
            return;
        }
        
        if ( is_page() && isset( $values['hideon_page'] ) ) {
            if ( ( !is_home() ) && ( !is_front_page() ) ) {
                return;
            }
        }
        
        if ( is_home() && isset( $values['hideon_homepage'] ) ) {
            return;
        }
        
        if ( is_front_page() && isset( $values['hideon_frontpage'] ) ) {
            return;
        }
        
        if ( is_category() && isset( $values['hideon_category'] ) ) {
            return;
        }
        
        if ( is_archive() && isset( $values['hideon_archive'] ) ) {
            return;
        }
        
        if ( is_404() && isset( $values['hideon_404'] ) ) {
            return;
        }


        // Hide styles on this catergorys - list
        $list_hideon_cat = $values['list_hideon_cat'];

        // avoid calling foreach, explode when hide on categorys list is empty
        if( $list_hideon_cat ) {

            //  Get current post Categorys list and create an array for that..
            $current_categorys_array = array();
            $current_categorys = get_the_category();
            foreach ( $current_categorys as $category ) {
                $current_categorys_array[] = strtolower($category->name);
            }

            $list_hideon_cat_array = explode(',', $list_hideon_cat);
        
            foreach ( $list_hideon_cat_array as $category ) {
                $category_trim = trim($category);
                if ( in_array( strtolower($category_trim), $current_categorys_array ) ) {
                    return;
                }
            }
        }
        

        // require_once HT_CCW_PLUGIN_DIR .'inc/commons/positions.php';

        if( 1 == $position ) {
            $p1 = 'bottom:'.$values['position-1_bottom'];
            $p2 = 'right:'.$values['position-1_right'];
        } elseif( 2 == $position ) {
            $p1 = 'bottom:'.$values['position-2_bottom'];
            $p2 = 'left:'.$values['position-2_left'];
        } elseif( 3 == $position ) {
            $p1 = 'top:'.$values['position-3_top'];
            $p2 = 'left:'.$values['position-3_left'];
        } elseif( 4 == $position ) {
            $p1 = 'top:'.$values['position-4_top'];
            $p2 = 'right:'.$values['position-4_right'];
        }



        require_once HT_CCW_PLUGIN_DIR .'inc/commons/styles.php';

    }

}


// $chatbot = new CCW_Chatbot();
    

//  add_action( 'wp_head', 'chatbot' );
//  add_action( 'wp_footer', array( $chatbot, 'chatbot' ) );

endif; // END class_exists check