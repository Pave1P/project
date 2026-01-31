<?php
declare(strict_types=1);

namespace Eshop\Services;

use Exception;

class DatabaseService
{
	/**
	 * @throws Exception
	 */
	static function getConnection(): false|\mysqli|null
	{
		static $connection = null;

		if ($connection === null)
		{
			$dbHost = ConfigurationService::getLocalOption('DB_HOST');
			$dbName = ConfigurationService::getLocalOption('DB_NAME');
			$dbUser = ConfigurationService::getLocalOption('DB_USER');
			$dbPassword = ConfigurationService::getLocalOption('DB_PASSWORD');

			$connection = mysqli_init();

			$connected = mysqli_real_connect($connection, $dbHost, $dbUser, $dbPassword, $dbName);

			if (!$connected)
			{
				$error = mysqli_connect_errno() . ': ' . mysqli_connect_error();
				throw new Exception($error);
			}

			$encodingResult = mysqli_set_charset($connection, 'utf8mb4');
			if (!$encodingResult)
			{
				throw new Exception(mysqli_error($connection));
			}
		}

		return $connection;
	}

	/**
	 * @throws Exception
	 */
	static function dbQuery(string $sql, string $types = '', array $params = []): \mysqli_result
	{
		$connection = self::getConnection();
		if (!$connection)
		{
			throw new Exception('Database connection is not initialized.');
		}

		$stmt = mysqli_prepare($connection, $sql);

		if (!$stmt)
		{
			throw new Exception(mysqli_error($connection));
		}

		if ($types !== '' && !empty($params))
		{
			mysqli_stmt_bind_param($stmt, $types, ...$params);
		}

		mysqli_stmt_execute($stmt);

		if (mysqli_stmt_errno($stmt) !== 0)
		{
			throw new Exception(mysqli_stmt_error($stmt));
		}

		if (mysqli_stmt_field_count($stmt) === 0)
		{
			throw new Exception('Query does not return a result set.');
		}

		$result = mysqli_stmt_get_result($stmt);

		if (!$result)
		{
			throw new Exception(mysqli_error($connection));
		}

		return $result;
	}

	/**
	 * @return array{affected_rows:int, insert_id:int}
	 * @throws Exception
	 */
	static function dbExecute(string $sql, string $types = '', array $params = []): array
	{
		$connection = self::getConnection();
		if (!$connection)
		{
			throw new Exception('Database connection is not initialized.');
		}

		$stmt = mysqli_prepare($connection, $sql);

		if (!$stmt)
		{
			throw new Exception(mysqli_error($connection));
		}

		if ($types !== '' && !empty($params))
		{
			mysqli_stmt_bind_param($stmt, $types, ...$params);
		}

		mysqli_stmt_execute($stmt);

		if (mysqli_stmt_errno($stmt) !== 0)
		{
			throw new Exception(mysqli_stmt_error($stmt));
		}

		return [
			'affected_rows' => mysqli_stmt_affected_rows($stmt),
			'insert_id' => mysqli_insert_id($connection),
		];
	}
}
