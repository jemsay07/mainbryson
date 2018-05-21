<?php
/**
 * 
 */
namespace Inc\Base;

class BaseController
{
	
	public $plugin_path;

	public $plugin_url;

	public $plugin;

	public $managers = array();

	public function __construct(){

		// $this->plugin_path = plugin_dir_path(  dirname( __FILE__ ) );
		// $this->plugin_url = plugin_dir_url( dirname( __FILE__, 2 ) );
		// $this->plugin = plugin_basename( dirname( __FILE__, 3 ) ) . '/sample-plugins.php';
	
		$this->managers = array(
			'banner_manager'		=> 'Activate Banner Manager',
			'site_sync_manager'		=> 'Activate Site Sync Manager',
			'user_roles'			=> 'Activate User Roles & Capabalities',
			'link_alt_manager'		=> 'Activate Link Alt Manager',
		);
	}

	public function activated( $key ){

		$key = ( is_string($key) ) ? $key : '';
		
		$option = get_option( 'main_bryson_plugin' );

		return isset( $option[$key] ) ? $option[$key] : false;
	}

}