<?php
/**
 * This is the style for this plugins
 * 
 * @package Main Bryson
 */
namespace Inc\Base;

class MainBrysonEnqueue
{
	
	function register()
	{
		add_action( 'admin_enqueue_scripts', array( $this,'__wp_enqueue' ) );
	}

	public function __wp_enqueue(){
		wp_enqueue_style( 'mainBrysonPluginStyle', MB_PLUGIN_URL . 'assets/css/mainbryson.css' );
		wp_enqueue_script( 'mainBrysonPluginScript', MB_PLUGIN_URL . 'assets/js/mainbryson.js' );
	}
}