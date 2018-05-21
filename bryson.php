<?php
/**
 * Plugin Name: Main Bryson Plugin
 * Description: Customized Plugin for Zapport blogs only. Display the link alternative, give some user roles, can create a customize banner that have a shortcodes on it and this plugin have a sync for all the site that already input. This plugins is for private used only. Please <strong>DO NOT DEACTIVATE OR DELETE OR DO ANYTHING WITH THIS PLUGIN</strong>. PLEASE ASK BRY, JEM OR R.C BEFORE YOU DO ANYTHING WITH THIS PLUGIN. Thank You
 * Version: 2.0.0
 * License: GPLv2 or later
 * Text Domain: mainbryson
 */

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
Copyright 2005-2015 Automattic, Inc.
 */

if ( ! defined('ABSPATH')  ) {
	exit;
}

if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}

//Path directory
define('MB_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

//URL directory
define('MB_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

//Base URL
define('MB_PLUGIN', plugin_basename( __FILE__ ) );

//Plugin Activation
function mainbryson_activate(){
	Inc\Base\Activate::activate();
}
register_activation_hook( __FILE__ , 'mainbryson_activate' );

//Plugin Deactivation
function mainbryson_deactivate(){
	Inc\Base\Deactivate::deactivate();
}
register_activation_hook( __FILE__ , 'mainbryson_deactivate' );

if ( class_exists( 'Inc\\Init' ) ){
	Inc\Init::register_services();
}
