<?php

declare(strict_types=1);

namespace Eshop\Mapper;

use DateTime;
use Eshop\Enums\OrderStatus;
use Eshop\Model\Order;
use Exception;

class OrderMapper implements MapperInterface
{
	public function map(array $row): Order
	{
		$dateCreated = DateTime::createFromFormat('Y-m-d H:i:s', (string)$row['date_created']);
		$dateModified = $row['date_modified']
			? DateTime::createFromFormat('Y-m-d H:i:s', (string)$row['date_modified'])
			: $row['date_modified'];

		if ($dateCreated === false || $dateModified === false)
		{
			throw new Exception('Invalid order date format.');
		}

		return Order::fromDatabase(
			(int)$row['id'],
			(int)$row['product_id'],
			(string)$row['total_price'],
			$row['client_name'],
			$row['client_email'],
			$row['client_phone'],
			$row['client_address'],
			OrderStatus::from($row['status']),
			$dateCreated,
			$dateModified
		);
	}
}