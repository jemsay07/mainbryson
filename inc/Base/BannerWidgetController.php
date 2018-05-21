<?php

/**
 * @package Bryson
 */
namespace Inc\Base;

use \Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use \Inc\Api\Callbacks\BannerCallbacks;
use \Inc\Api\Callbacks\AdminCallbacks;

class BannerWidgetController extends BaseController
{
	
	public $settings;
	public $callbacks;
	public $banner_callbacks;
	public $subpages = array();

	public function register(){

		if ( ! $this->activated('banner_manager') ) return;

		$this->settings = new SettingsApi();

		$this->callbacks = new AdminCallbacks();

		$this->banner_callbacks = new BannerCallbacks();

		$this->setSubPages();

		$this->setSettings();

		$this->setSections();

		$this->setFields();

		$this->settings->addSubPages( $this->subpages )->register();

		$this->storeCustomPostTypes();

		if ( ! empty( $this->custom_post_types ) ) {
			add_action( 'init', array( $this, 'registerBanner' ) );
		}
	}

	public function setSubPages(){
		$this->subpages = array(
			array(
				'parent_slug' => 'main_bryson_plugin',
				'page_title' => 'Custom Banner',
				'menu_title' => 'Banner Manager',
				'capability' => 'manage_options',
				'menu_slug' => 'mb_banner',
				'callback' =>  array( $this->callbacks, 'adminBanner' ),
			)
		);
	}

	public function setSettings(){
		$args = array(
			array(
				'option_group' => 'mb_banner_settings',
				'option_name'  => 'mb_banner',
				'callback'	   => array( $this->banner_callbacks, 'bannerSanitize' ),
			)
		);
		$this->settings->setSettings($args);
	}

	public function setSections()
	{
		$args = array(
			array(
				'id' => 'mb_banner_index',
				'title'  => 'Banner Manager',
				'callback'	   => array( $this->banner_callbacks, 'bannerSectionManager' ),
				'page'	=> 'mb_banner'
			)
		);

		$this->settings->setSections( $args );
	}

	public function setFields(){
		$args = array(
			array( 
				'id' => 'post_type',
				'title'  => 'Custom Post Type ID',
				'callback'	   => array( $this->banner_callbacks, 'textField' ),
				'page'	=> 'mb_banner',
				'section'	=> 'mb_banner_index',
				'args'	=> array(
					'option_name' 	=> 'mb_banner',
					'label_for' 	=> 'post_type',
					'placeholder'	=> 'eg. Product',
				)
			),
		);
	}

	public function storeCustomPostTypes(){
		$options = get_option('mb_banner') ?: array();

		
	}

}