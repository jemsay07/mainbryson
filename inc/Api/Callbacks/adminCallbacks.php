<?php
/**
 * 
 */
namespace Inc\Api\Callbacks;

class AdminCallbacks
{
	public function adminDashboard(){
		return require_once( MB_PLUGIN_PATH . "/templates/dashboard.php");
	}

	public function adminBanner(){
		return require_once( MB_PLUGIN_PATH . "/templates/banner.php");
	}

	public function adminLinkAlt(){
		return require_once( MB_PLUGIN_PATH . "/templates/link_alt.php");
	}

	public function adminSite(){
		return require_once( MB_PLUGIN_PATH . "/templates/sites.php");
	}
	
	/*public function sampleTextExample(){

		$val = esc_attr( get_option( 'text_example' ) );

		echo '<input type="text" class="regular-text" name="text_example" value="' . $val . '" placeholder="Write Something Here!">';
	}
	
	public function sampleFirstName(){

		$val = esc_attr( get_option( 'first_name' ) );

		echo '<input type="text" class="regular-text" name="text_example" value="' . $val . '" placeholder="Write your first name !">';
	}*/
}