<?php
/**
 * Namespace
 */
namespace Wsklad\Abstracts;

/**
 * Only WordPress
 */
defined('ABSPATH') || exit;

/**
 * Dependencies
 */

use Exception;
use RuntimeException;
use Wsklad\Interfaces\SettingsInterface;

/**
 * Class SettingsAbstract
 *
 * @package Wsklad
 */
abstract class SettingsAbstract implements SettingsInterface
{
	/**
	 * Name option prefix in wp_options
	 *
	 * @var string
	 */
	protected $option_name_prefix = 'wsklad_settings_';

	/**
	 * Name option in wp_options
	 *
	 * @var string
	 */
	protected $option_name = '';

	/**
	 * Current data
	 *
	 * @var array
	 */
	private $data = [];

	/**
	 * Set option name with prefix
	 *
	 * @param string $name Option name without prefix
	 */
	public function setOptionName($name)
	{
		$this->option_name = $this->option_name_prefix . $name;
	}

	/**
	 * @return string
	 */
	public function getOptionName()
	{
		return $this->option_name;
	}

	/**
	 * Initializing
	 *
	 * @return void
	 * @throws Exception
	 */
	public function init()
	{
		// get data from wp_options
		$settings = get_site_option($this->getOptionName() , []);

		// hook
		$settings = apply_filters($this->getOptionName() . 'data_init', $settings);

		if(!is_array($settings))
		{
			throw new RuntimeException('init: $settings is not array');
		}

		$settings = array_merge
		(
			$this->getData(),
			$settings
		);

		try
		{
			$this->setData($settings);
		}
		catch(Exception $e)
		{
			throw new RuntimeException('init: exception - ' . $e->getMessage());
		}
	}

	/**
	 * Set setting data - single or all
	 *
	 * @param string|array $setting_data
	 * @param string $setting_key
	 *
	 * @return boolean
	 * @throws Exception|RuntimeException
	 */
	public function set($setting_data = '', $setting_key = '')
	{
		if(empty($setting_key) && !is_array($setting_data))
		{
			return false;
		}

		$current_data = $this->getData();

		if(is_array($setting_data) && empty($setting_key))
		{
			$current_data = array_merge
			(
				$current_data,
				$setting_data
			);
		}
		else
		{
			$current_data[$setting_key] = $setting_data;
		}

		try
		{
			$this->setData($current_data);
		}
		catch(Exception $e)
		{
			throw new RuntimeException('set: exception - ' . $e->getMessage());
		}

		return true;
	}

	/**
	 * Save
	 *
	 * @param $settings_data null|array - optional
	 *
	 * @return bool
	 * @throws Exception|RuntimeException
	 */
	public function save($settings_data = null)
	{
		$current_data = $this->getData();

		if(is_array($settings_data))
		{
			$settings_data = array_merge($current_data, $settings_data);
		}
		else
		{
			$settings_data = $current_data;
		}

		$settings_data = apply_filters($this->getOptionName() . 'data_save', $settings_data);

		try
		{
			$this->setData($settings_data);
		}
		catch(Exception $e)
		{
			throw new RuntimeException('save: exception - ' . $e->getMessage());
		}

		/**
		 * Update in DB
		 */
		return update_option($this->getOptionName(), $settings_data, 'no');
	}

	/**
	 * Get settings - all or single
	 *
	 * @param string $setting_key - optional
	 * @param string $default_return - default data, optional
	 *
	 * @return mixed
	 * @throws RuntimeException
	 */
	public function get($setting_key = '', $default_return = '')
	{
		try
		{
			$data = $this->getData();
		}
		catch(Exception $e)
		{
			throw new RuntimeException('get: exception - ' . $e->getMessage());
		}

		if('' !== $setting_key)
		{
			if(array_key_exists($setting_key, $data))
			{
				return $data[$setting_key];
			}

			return $default_return;
		}

		return $data;
	}

	/**
	 * Get all data
	 *
	 * @return array
	 * @throws Exception
	 */
	private function getData()
	{
		if(!is_array($this->data))
		{
			throw new RuntimeException('get_data: $data is not valid array');
		}

		return $this->data;
	}

	/**
	 * Set all data
	 *
	 * @param $data
	 *
	 * @return void
	 * @throws Exception
	 */
	private function setData($data = [])
	{
		if(!is_array($data))
		{
			throw new RuntimeException('set_data: $data is not valid');
		}

		$this->data = $data;
	}
}