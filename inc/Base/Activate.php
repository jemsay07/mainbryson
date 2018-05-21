<?php
/**
 * This will be the function activation for mainbryson plugins
 * 
 * @package Main Bryson
 */
namespace Inc\Base;

class Activate
{
	public static function activate(){
		flush_rewrite_rules();

		$default = array();

		if ( ! get_option('main_bryson_plugin') ) {
			update_option( 'main_bryson_plugin', $default );
		}
		
		if ( ! get_option('banner_manager') ) {
			update_option( 'banner_manager', $default );
		}
	}
}