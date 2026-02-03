<?php
declare(strict_types=1);

namespace Eshop\Mapper;

use DateTime;
use Eshop\Model\Product;
use Exception;

class ProductMapper implements MapperInterface
{
	public function map(array $row): Product
	{
		$dateCreated = DateTime::createFromFormat('Y-m-d H:i:s', (string)$row['date_created']);
		$dateModified = DateTime::createFromFormat('Y-m-d H:i:s', (string)$row['date_modified']);

		if ($dateCreated === false || $dateModified === false)
		{
			throw new Exception('Invalid product date format.');
		}

		return new Product(
			(int)$row['id'],
			$row['name'],
			$row['description_short'],
			$row['description_long'],
			(string)$row['price'],
			(bool)$row['is_active'],
			$dateCreated,
			$dateModified
		);
	}
}
