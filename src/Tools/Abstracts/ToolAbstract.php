<?php namespace Wsklad\Tools\Abstracts;

defined('ABSPATH') || exit;

use Wsklad\Exceptions\Exception;

/**
 * ToolAbstract
 *
 * @package Wsklad\Tools
 */
abstract class ToolAbstract
{
	/**
	 * @var string Unique tool id
	 */
	private $id = '';

	/**
	 * @var string Name
	 */
	private $name = '';

	/**
	 * @var string Description
	 */
	private $description = '';

	/**
	 * @var string Schema Author
	 */
	private $author = 'WC1C team';

	/**
	 * @throws Exception
	 *
	 * @return mixed
	 */
	abstract public function init();

	/**
	 * Set tool id
	 *
	 * @param $id
	 *
	 * @return $this
	 */
	public function setId($id)
	{
		$this->id = $id;

		return $this;
	}

	/**
	 * Get tool id
	 *
	 * @return string
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param string $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}

	/**
	 * @return string
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * @param string $description
	 */
	public function setDescription($description)
	{
		$this->description = $description;
	}

	/**
	 * @return string
	 */
	public function getAuthor()
	{
		return $this->author;
	}

	/**
	 * @param string $author
	 */
	public function setAuthor($author)
	{
		$this->author = $author;
	}
}