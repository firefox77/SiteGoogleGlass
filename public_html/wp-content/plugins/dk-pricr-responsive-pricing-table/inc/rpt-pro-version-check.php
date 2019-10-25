<?php

/* Checks for PRO version. */
add_action( 'admin_init', 'rpt_free_pro_check' );
function rpt_free_pro_check() {

    if (is_plugin_active('responsive-pricing-table-pro/rpt_pro.php')) {

        /* Shows admin notice. */
        add_action('admin_notices', 'rpt_free_pro_notice');
        function rpt_free_pro_notice(){
          echo '<div class="updated"><p><span class="dashicons dashicons-unlock"></span> Responsive Pricing Table <strong>PRO</strong> was activated and is now taking over the Free version.</p></div>';
        }
        
        /* Deactivates free version. */
        deactivate_plugins( RPT_PATH.'/rpt.php' );

    }

}

?>