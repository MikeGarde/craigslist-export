<?php
/*
Plugin Name: craigslist export
Plugin URI: https://github.com/MikeGarde/craigslist-export
Description: Export post-type to craigslist
Author: Jeff & Mike
Text Domain: cle
Version: 0.1
*/

register_activation_hook( __FILE__, array('craigslist_export_settings', 'activate') );

class craigslist_export_settings {
	function __construct() {
		add_action('admin_menu', array(&$this, 'admin_menu'));
		require_once('debug.php');
	}
	function activate() {
		add_option('cle_username', '');
		add_option('cle_password', '');
		add_option('cle_accountID', '');
		add_option('cle_post_type', '');
		add_option('cle_associations', 'a:0:{}');
	}
	function admin_menu() {
		add_options_page('craigslist export settings',
						'craigslist export',
						'manage_options',
						'craigslist_export_settings',
						array($this, 'settings_page'));
	}
	function settings_page() {
		wp_enqueue_script('jquery');
        wp_register_style('craigslist_export_css', plugins_url('view/css/style.css', __FILE__) );
        wp_enqueue_style( 'craigslist_export_css' );

		$cle['username'] = get_option('cle_username');
		$cle['password'] = get_option('cle_password');
		$cle['accountID'] = get_option('cle_accountID');
		$cle['post_type'] = get_option('cle_post_type');
		$cle['associations'] = unserialize(get_option('cle_associations'));

		$post_types = get_post_types('', 'objects');
		foreach ($post_types as $key => $value ) {
			$select_post_type[$key] = $value->labels->name;
		}
		unset($post_types);

		require_once('view/settings.php');
	}
}
new craigslist_export_settings;


function craigslist_save_settings() {
	//global $wpdb;

	$refresh = (get_option('cle_post_type') != $_POST['post_type']) ? true : false;

	update_option('cle_username', $_POST['username']);
	update_option('cle_password', $_POST['password']);
	update_option('cle_accountID', $_POST['accountID']);
	update_option('cle_post_type', $_POST['post_type']);

	$result = 'Settings Saved';

	echo json_encode(array(	'result'  => $result,
							'refresh' => $refresh));
	die();
}
add_action('wp_ajax_craigslistSaveSettings', 'craigslist_save_settings');