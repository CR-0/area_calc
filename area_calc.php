<?php
/**
 * @package area_calc
 * @version 1.0
 */
/*
Plugin Name: Alan Hesaplama
Plugin URI: #
Description: Cam Balkon alan hesaplama ve fiyat çıkarma eklentisi.
Author: Caner O.
Version: 1.0
Author URI: #
*/
function area_calc_shortcode($atts, $content = null)
{

	//$atts = shortcode_atts( array('one' => 'default content'),$atts );
	include( plugin_dir_path(__FILE__) . 'public_view.php');
	return null;
}
add_shortcode('area-calc', 'area_calc_shortcode');

function calc_settings_page()
{
    add_menu_page(
        'Cam Balkon Alan Hesaplama',
        'Alan Hesaplama',
        'manage_options',
        plugin_dir_path(__FILE__) . 'admin_view.php',
		null,//function
		null,//icon
        20
    );
}
add_action('admin_menu', 'calc_settings_page');

function calc_settings()
{
	register_setting('area_calc','area_calc-one',array("default"=>"[{'name':'Sample','price':10}]"));
	register_setting('area_calc','area_calc-two',array("default"=>"{'width':10,'heigth':10}"));
}
add_action('admin_init','calc_settings');

?>
