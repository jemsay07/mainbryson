<?php
/**
 * 
 * @package Main Bryson
 */
namespace Inc\Base;

use \Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use \Inc\Api\Callbacks\AdminCallbacks;

class SitesController extends BaseController
{
	public $callbacks;

	public $subpages = array();

	public function register(){

		if ( ! $this->activated('site_sync_manager') ) return;

		$this->settings = new SettingsApi();

		$this->callbacks = new AdminCallbacks();

		$this->setSubPages();

		$this->settings->addSubPages( $this->subpages )->register();
	}

	public function setSubPages(){

		$this->subpages = array(
			array(
				'parent_slug' => 'main_bryson_plugin',
				'page_title' => 'Site',
				'menu_title' => 'Site Manager',
				'capability' => 'manage_options',
				'menu_slug' => 'main_bryson_site',
				'callback' =>  array( $this->callbacks, 'adminSite' ),
			)
		);
	}
}