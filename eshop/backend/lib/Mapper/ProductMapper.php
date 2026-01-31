<?php

declare(strict_types=1);

namespace Eshop\Mapper;

use DateTime;
use Eshop\Model\Product;
use Exception;

class ProductMapper
{
	public function map(array $row): Product
	{
		$dateCreate = DateTime::createFromFormat('Y-m-d H:i:s', (string)$row['date_create']);
		$dateModified = DateTime::createFromFormat('Y-m-d H:i:s', (string)$row['date_modified']);

		if ($dateCreate === false || $dateModified === false) {
			throw new Exception('Invalid product date format.');
		}

		return new Product(
			(int)$row['id'],
			$row['name'],
			$row['description_short'],
			$row['description_long'],
			(string)$row['price'],
			(bool)$row['is_active'],
			$dateCreate,
			$dateModified
		);
	}
}
