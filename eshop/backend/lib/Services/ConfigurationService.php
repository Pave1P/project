<?php
declare(strict_types=1);

namespace Eshop\Services;

use Exception;

class ConfigurationService
{
	/**
	 * @throws Exception
	 */
	public static function getLocalOption(string $optionName): string
	{
		/** @var array $config */
		static $config = null;

		if ($config === null)
		{
			$masterConfig = require_once BACKEND_ROOT . '/config/config.php';

			if (file_exists(BACKEND_ROOT . '/config/config.local.php'))
			{
				$localConfig = require_once BACKEND_ROOT . '/config/config.local.php';
			}
			else
			{
				$localConfig = [];
			}

			$config = array_merge($masterConfig, $localConfig);
		}

		if (array_key_exists($optionName, $config))
		{
			return $config[$optionName];
		}

		throw new Exception("Unknown option: $optionName");
	}
}
