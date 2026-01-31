<?php

declare(strict_types=1);

namespace Eshop\Migration;

use Eshop\Services\DatabaseService;
use Exception;

class Migrator
{
	/**
	 * Запускает весь процесс миграции базы данных.
	 * @throws Exception
	 */
	public static function migrate(): void
	{
		echo "--- Starting Database Migration ---\n";

		$migrationsDir = __DIR__ . '/../../migrations';
		$historyTable = 'migrations';
		$installFile = '2026_01_29_install.sql';

		// --- ШАГ 0: ПОЛУЧАЕМ СОЕДИНЕНИЕ С БД ---
		$mysqli = DatabaseService::getConnection();
		echo "Database connection successful.\n";


		// --- ШАГ 1: ПРОВЕРЯЕМ, СУЩЕСТВУЕТ ЛИ ТАБЛИЦА ИСТОРИИ ---
		$result = $mysqli->query("SHOW TABLES LIKE '$historyTable'");
		$historyTableExists = $result->num_rows > 0;

		$appliedMigrations = [];

		if (!$historyTableExists) {
			echo "History table '$historyTable' not found. This looks like a first run.\n";
			echo "-> Applying install file: $installFile ... ";

			$sql = file_get_contents($migrationsDir . '/' . $installFile);
			if (!$mysqli->multi_query($sql)) {
				throw new Exception("FATAL: Could not execute install file. Error: " . $mysqli->error);
			}
			while ($mysqli->more_results() && $mysqli->next_result()) {} // Очистка

			// Сразу добавляем install-файл в список выполненных
			$appliedMigrations[] = $installFile;
			echo "OK\n";
		}


		// --- ШАГ 2: ПОЛУЧАЕМ СПИСОК УЖЕ ВЫПОЛНЕННЫХ МИГРАЦИЙ ---
		if ($historyTableExists) {
			$result = $mysqli->query("SELECT `migration` FROM `$historyTable`");
			while ($row = $result->fetch_assoc()) {
				$appliedMigrations[] = $row['migration'];
			}
		}
		echo "Found " . count($appliedMigrations) . " applied migrations in history.\n";


		// --- ШАГ 3: ИЩЕМ НОВЫЕ ФАЙЛЫ В ПАПКЕ ---
		$allFiles = scandir($migrationsDir);
		sort($allFiles); // Сортируем, чтобы всегда был правильный порядок

		$newMigrationsToApply = [];
		foreach ($allFiles as $file) {
			if (pathinfo($file, PATHINFO_EXTENSION) === 'sql' && !in_array($file, $appliedMigrations)) {
				$newMigrationsToApply[] = $file;
			}
		}

		if (empty($newMigrationsToApply)) {
			echo "Database is up to date. No new migrations found.\n";
			echo "--- Migration Finished ---\n";
			return;
		}


		// --- ШАГ 4: ВЫПОЛНЯЕМ НОВЫЕ МИГРАЦИИ ---
		echo "Found " . count($newMigrationsToApply) . " new migrations to apply.\n";

		foreach ($newMigrationsToApply as $file) {
			echo "-> Applying: $file ... ";

			$mysqli->begin_transaction();
			try {
				// Выполняем SQL
				$sql = file_get_contents($migrationsDir . '/' . $file);
				if (!$mysqli->multi_query($sql)) {
					throw new Exception($mysqli->error);
				}
				while ($mysqli->more_results() && $mysqli->next_result()) {} // Очистка

				// Записываем в историю
				$stmt = $mysqli->prepare("INSERT INTO `$historyTable` (`migration`) VALUES (?)");
				$stmt->bind_param('s', $file);
				$stmt->execute();
				$stmt->close();

				$mysqli->commit();
				echo "OK\n";
			} catch (Exception $e) {
				$mysqli->rollback();
				throw new Exception("ERROR applying migration '$file'. Rolled back. Reason: " . $e->getMessage());
			}
		}

		echo "--- Migration Finished Successfully ---\n";
	}
}
