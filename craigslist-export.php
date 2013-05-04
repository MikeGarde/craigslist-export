<?php
/*
Plugin Name: craigslist export
Plugin URI: https://github.com/MikeGarde/craigslist-export
Description: Export post-type to craigslist
Author: Jeff & Mike
Text Domain: cle
Version: 0.1
*/



class craigslist_export_settings {
	function __construct() {
		add_action('admin_menu', array(&$this, 'admin_menu'));
	}
	function admin_menu () {
		add_options_page('craigslist export settings',
						'craigslist export',
						'manage_options',
						'craigslist_export_settings',
						array($this, 'settings_page'));
	}
	function  settings_page () {
		require_once('view/settings.php');
	}
}
new craigslist_export_settings;
