<?php
/**
 * Namespace
 */
namespace Wsklad\Data;

/**
 * Only WordPress
 */
defined('ABSPATH') || exit;

/**
 * Dependencies
 */

use Exception;
use Wsklad\Abstracts\DataAbstract;
use Wsklad\Data\Interfaces\StorageInterface;
use Wsklad\Data\Storages\StorageAccounts;

/**
 * Class Storage
 *
 * @package Wsklad\Data
 */
class Storage implements StorageInterface
{
	/**
	 * Contains an array of default supported data storages
	 *
	 * Format of object name => class name
	 * Example: 'key' => 'StorageUniqueName'
	 *
	 * You can also pass something like key_<type> for codes storage and
	 * that type will be used first when available, if a store is requested like
	 * this and doesn't exist, then the store would fall back to 'key'.
	 * Ran through PREFIX `_data_storages`.
	 *
	 * @var array
	 */
	private $storages =
	[
		'account' => StorageAccounts::class,
	];

	/**
	 * Contains an instance of the data store class that we are working with
	 *
	 * @var Storage
	 */
	private $instance = null;

	/**
	 * Contains the name of the current data store's class name
	 *
	 * @var string
	 */
	private $current_class_name = '';

	/**
	 * The object type this store works with
	 *
	 * @var string
	 */
	private $current_object_type;

	/**
	 * Tells Storage which object (configurations, etc) store we want to work with
	 *
	 * @param string $object_type Name of object
	 *
	 * @throws Exception When validation fails
	 */
	public function __construct($object_type)
	{
		if(empty($object_type))
		{
			throw new Exception('Invalid $object_type. Storage by object type is not found.');
		}

		$this->set_current_object_type($object_type);

		// hook
		$this->set_storages(apply_filters('wsklad_data_storages', $this->get_storages()));

		if(!array_key_exists($object_type, $this->get_storages()))
		{
			throw new Exception('Invalid data storage. Storage by key type is not found.');
		}

		// hook
		$storage = apply_filters('wsklad_data_storages_' . $object_type, $this->storages[$object_type]);

		if(is_object($storage))
		{
			if(!$storage instanceof StorageInterface)
			{
				throw new Exception('Invalid data storage. Interface error.');
			}

			$this->current_class_name = get_class($storage);
			$this->instance = $storage;
		}
		else
		{
			if(!class_exists($storage))
			{
				throw new Exception('Invalid data storage. Storage class is not exists.');
			}

			$this->current_class_name = $storage;
			$this->instance = new $storage();
		}
	}

	/**
	 * @return string
	 */
	public function get_current_object_type()
	{
		return $this->current_object_type;
	}

	/**
	 * @param string $current_object_type
	 */
	public function set_current_object_type($current_object_type)
	{
		$this->current_object_type = $current_object_type;
	}

	/**
	 * @return array
	 */
	protected function get_storages()
	{
		return $this->storages;
	}

	/**
	 * @param array $storages
	 */
	protected function set_storages($storages)
	{
		$this->storages = $storages;
	}

	/**
	 * Only store the object type to avoid serializing the data storage instance
	 *
	 * @return array
	 */
	public function __sleep()
	{
		return ['object_type'];
	}

	/**
	 * Re-run the constructor with the object type
	 *
	 * @throws Exception When validation fails
	 */
	public function __wakeup()
	{
		$this->__construct($this->current_object_type);
	}

	/**
	 * Loads a data storage
	 *
	 * @param string $object_type Name of object
	 *
	 * @return Storage
	 * @throws Exception When validation fails
	 */
	public static function load($object_type)
	{
		return new Storage($object_type);
	}

	/**
	 * Returns the class name of the current data storage
	 *
	 * @return string
	 */
	public function get_current_class_name()
	{
		return $this->current_class_name;
	}

	/**
	 * Reads an object from the data storage
	 *
	 * @param DataAbstract $data Data instance
	 */
	public function read(&$data)
	{
		$this->instance->read($data);
	}

	/**
	 * Create an object in the data storage
	 *
	 * @param DataAbstract $data Data instance
	 */
	public function create(&$data)
	{
		$this->instance->create($data);
	}

	/**
	 * Update an object in the data storage
	 *
	 * @param DataAbstract $data Data instance
	 */
	public function update(&$data)
	{
		$this->instance->update($data);
	}

	/**
	 * Delete an object from the data storage
	 *
	 * @param DataAbstract $data Data instance
	 * @param array $args Array of args to pass to the delete method
	 */
	public function delete(&$data, $args = [])
	{
		$this->instance->delete($data, $args);
	}

	/**
	 * Data storage can define additional functions (for example,
	 * generator have some helper methods for increasing or decreasing usage).
	 * This passes through to the instance if that function exists.
	 *
	 * @param string $method Method
	 * @param mixed $parameters Parameters
	 *
	 * @return mixed
	 */
	public function __call($method, $parameters)
	{
		if(is_callable(array($this->instance, $method)))
		{
			$object = array_shift($parameters);
			$parameters = array_merge(array(&$object), $parameters);

			return $this->instance->$method(...$parameters);
		}

		return false;
	}
}
