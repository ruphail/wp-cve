<?php
if ( ! defined( 'ABSPATH' ) ) exit;
add_action('wp_ajax_ajax_backlink', 'xyz_cfm_ajax_backlink');

function xyz_cfm_ajax_backlink() {
	

global $wpdb;

if($_POST){
    
    if (! isset($_POST['_wpnonce']) || ! wp_verify_nonce($_POST['_wpnonce'], 'backlink')) {
        echo 1;
        die();
    }
    if (current_user_can('administrator')) {
        global $wpdb;
        if (isset($_POST)) {
            if (intval($_POST['enable']) == 1) {
                update_option('xyz_credit_link', 'cfm');
                echo "cfm";
            }
            if (intval($_POST['enable']) == - 1) {
                update_option('xyz_cfm_credit_dismiss', "hide");
                echo - 1;
            }
        }
    }
    
	
	
}die;

}

