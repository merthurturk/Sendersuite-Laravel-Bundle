<?php
namespace Sendersuite;

use \Laravel\Config;

/**
 * Main configuration provider for Sendersuite API class.
 *
 * @author Mert Hurturk <mert.hurturk@gmail.com>
 */
class ConfigurationProvider
{
	public function getDefaultConfiguration()
	{
		$defaultConnConfigName = Config::get('sendersuite::config.defaultconnection');
		return Config::get('sendersuite::config.connections.'
			.$defaultConnConfigName);
	}

	public function getConfigurationFor($key)
	{
		return Config::get('sendersuite::config.connections.'.$key);
	}
}