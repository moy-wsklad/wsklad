<?php
/**
 * Plugin Name: WSKLAD
 * Plugin URI: https://wsklad.ru
 * Description: Implementation of a mechanism for flexible exchange of various data between Moy Sklad and a site running WordPress.
 * Version: 0.1.0
 * WC requires at least: 4.3
 * WC tested up to: 7.1
 * Requires at least: 5.2
 * Requires PHP: 7.0
 * Text Domain: wsklad
 * Domain Path: /assets/languages
 * Copyright: WSKLAD team © 2019-2022
 * Author: WSKLAD team
 * Author URI: https://wsklad.ru
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 * @package Wsklad
 **/
defined('ABSPATH') || exit;

if(version_compare(PHP_VERSION, '7.0') < 0)
{
	return false;
}

if(false === defined('WSKLAD_PLUGIN_FILE'))
{
	/**
	 * Main instance of Wsklad
	 *
	 * @return Wsklad\Core
	 */
	function wsklad()
	{
		return Wsklad\Core::instance();
	}

	define('WSKLAD_PREFIX', 'wsklad_');
	define('WSKLAD_ADMIN_PREFIX', 'wsklad_admin_');

	define('WSKLAD_PLUGIN_FILE', __FILE__);
	define('WSKLAD_PLUGIN_PATH', plugin_dir_path(WSKLAD_PLUGIN_FILE));
	define('WSKLAD_PLUGIN_URL', plugin_dir_url(__FILE__));
	define('WSKLAD_PLUGIN_NAME', plugin_basename(WSKLAD_PLUGIN_FILE));

	include_once __DIR__ . '/src/Loader.php';

	$loader = new Wsklad\Loader();

	try
	{
		$loader->register();
	}
	catch(Exception $e){}
}