<?php
/**
 * This will be the function deactivation for mainbryson plugins
 * 
 * @package Main Bryson
 */
namespace Inc\Base;

class Deactivate
{
	
	public static function deactivate()
	{
		flush_rewrite_rules();
	}
}