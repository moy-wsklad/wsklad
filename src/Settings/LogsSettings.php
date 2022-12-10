<?php namespace Wsklad\Settings;

defined('ABSPATH') || exit;

use Wsklad\Settings\Abstracts\SettingsAbstract;

/**
 * LogsSettings
 *
 * @package Wc1c\Settings
 */
class LogsSettings extends SettingsAbstract
{
	/**
	 * LogsSettings constructor.
	 */
	public function __construct()
	{
		$this->setOptionName('logs');
	}
}