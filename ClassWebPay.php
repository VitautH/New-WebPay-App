<?
/*
Plugin Name: Web Pay API
Description: Онлайн платежи
Version: 1.0
Author: Vitaut Hryharovich
Author URI: http://oncore.by/
Plugin URI: http://oncore.by
*/
function register_session() {

    if ( ! session_id() ) {
        session_start();
    }

}

add_action( 'init', 'register_session' );
define('ClassWebPay_DIR', plugin_dir_path(__FILE__));
define('ClassWebPay_URL', plugin_dir_url(__FILE__));
function ClassWebPay_load(){
    require_once(ClassWebPay_DIR.'Load.php');


}
ClassWebPay_load();
