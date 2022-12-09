<?php
/**
 * Namespace
 */
namespace Wsklad\Interfaces;

/**
 * Only WordPress
 */
defined('ABSPATH') || exit;

/**
 * Dependencies
 */

use Exception;

/**
 * Interface InterfaceSettings
 *
 * @package Wsklad\Interfaces
 */
interface SettingsInterface
{
	/**
	 * Initializing
	 *
	 * @return void
	 * @throws Exception
	 */
	public function init();

	/**
	 * Get - all or single
	 *
	 * @param string $setting_key - optional
	 * @param mixed $default_return - default data, optional
	 *
	 * @return mixed
	 * @throws Exception
	 */
	public function get($setting_key = '', $default_return = '');

	/**
	 * Set - all or single
	 *
	 * @param mixed $setting_data - all data, or single
	 * @param string $setting_key - optional
	 *
	 * @return mixed
	 * @throws Exception
	 */
	public function set($setting_data = '', $setting_key = '');

	/**
	 * Save
	 *
	 * @param array $settings_data Data to save
	 *
	 * @return mixed
	 * @throws Exception
	 */
	public function save($settings_data = null);
}