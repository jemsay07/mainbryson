<?php
/**
 * 
 */
namespace Inc\Pages;

use \Inc\Api\SettingsApi;
use \Inc\Base\BaseController;
use \Inc\Api\Callbacks\AdminCallbacks;
use \Inc\Api\Callbacks\ManagerCallbacks;

class Dashboard extends BaseController
{
	public $settings;

	public $callbacks;

	public $callback_mngr;

	public $pages = array();

	public function register(){

		$this->settings = new SettingsApi();

		$this->callbacks = new AdminCallbacks();

		$this->callback_mngr = new ManagerCallbacks();

		$this->setPages();

		// $this->setSubPages();

		$this->setSettings();

		$this->setSections();

		$this->setFields();

		$this->settings->addPages( $this->pages )->withSubPage( 'Dashboard' )->register();
	}

	public function setPages(){
		$this->pages = array(
			array(
				'page_title' => 'Main Bryson Plugins', 
				'menu_title' => 'Main Bryson', 
				'capability' => 'manage_options', 
				'menu_slug' => 'main_bryson_plugin', 
				'callback' =>  array( $this->callbacks, 'adminDashboard' ),
				'icon_url' => 'dashicons-smiley', 
				'position' => 110
			)
		);
	}
	public function setSettings()
	{
		$args = array(
			array(
				'option_group' => 'main_bryson_settings',
				'option_name'  => 'main_bryson_plugin',
				'callback'	   => true,
			)
		);

		$this->settings->setSettings( $args );
	}

	public function setSections()
	{
		$args = array(
			array(
				'id' => 'main_bryson_admin_index',
				'title'  => 'Settings Manager',
				'callback'	   => array( $this->callback_mngr, 'AdminSectionManager' ),
				'page'	=> 'main_bryson_plugin'
			)
		);

		$this->settings->setSections( $args );
	}

	public function setFields() 
	{

		$args = array();

		foreach ( $this->managers as $key =>  $val ) {
			$args[] = array( 
				'id' => $key,
				'title'  => $val,
				'callback'	   => array( $this->callback_mngr, 'checkboxField' ),
				'page'	=> 'main_bryson_plugin',
				'section'	=> 'main_bryson_admin_index',
				'args'	=> array(
					'option_name' 	=> 'main_bryson_plugin',
					'label_for' 	=> $key,
					'class' 	=> 'ui-toggle',
				)
			);
		}

		$this->settings->setFields( $args );
	}
}