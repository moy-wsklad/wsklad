<?php
/**
 * Namespace
 */
namespace Wsklad\Api\MoySklad\Utils\Http;

/**
 * Only WordPress
 */
defined('ABSPATH') || exit;

/**
 * Class RequestPut
 *
 * @package Wsklad\Api\MoySklad\Utils\Http
 */
class RequestPut extends Request
{
	const METHOD = 'PUT';

	/**
	 * RequestPut constructor.
	 *
	 * @param $uri
	 * @param array $headers
	 * @param null $body
	 * @param string $version
	 */
	public function __construct($uri, $headers = [], $body = null, $version = '1.1')
	{
		parent::__construct($this->getMethod(), $uri, $headers, $body, $version);
	}

	/**
	 * @return string
	 */
	public function getMethod()
	{
		return self::METHOD;
	}
}