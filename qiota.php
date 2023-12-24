<?php

/**
 * @package Qiota
 */

/*
Plugin Name: Qiota
Plugin URI: https://qiota.com/
Description: integrate qiota step by step in just a few clicks
Version: 0.1
Requires at least: 6.4.2
Requires PHP: 7.4.26
Author: Maxime BRETON
License: GPLv2 or later
Text Domain: qiota
*/

if (!function_exists( 'add_action' )) {
	echo 'Hello everybody! I\'m just a WP plugin, not much I can do when called directly.';
	exit;
}

define('QIOTA_VERSION', '0.1');
define('QIOTA__MINIMUM_WP_VERSION', '6.4.2');
define('QIOTA__PLUGIN_DIR', plugin_dir_path( __FILE__ ));

register_activation_hook(__FILE__, array( 'Qiota', 'plugin_activation'));
register_deactivation_hook(__FILE__, array( 'Qiota', 'plugin_deactivation'));

if (is_admin() || (defined( 'WP_CLI' ) && WP_CLI )) {
	require_once(QIOTA__PLUGIN_DIR . 'class.qiota-admin.php');
	add_action('init', array( 'QiotaAdmin', 'init' ));
}