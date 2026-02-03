<?php
declare(strict_types=1);

namespace Eshop\Repository;

use Eshop\Mapper\OrderMapper;
use Eshop\Model\Order;
use Eshop\Services\DatabaseService;

class OrderRepository
{
	private OrderMapper $mapper;
	public function __construct(OrderMapper $mapper)
	{
		$this->mapper = $mapper;
	}

	public function add(Order $order): int
	{
		$sqlQuery =
			'INSERT INTO up_order (
    			product_id,
    			total_price,
				client_name,
				client_email,
				client_phone,
				client_address,
				status,
				date_created,
				date_modified
			)
			VALUES (
				?, ?, ?, ?, ?, ?, ?, ?, ?
			)';

		$types = 'idsssssss';
		$params = [
			$order->productId,
			$order->totalPrice,
			$order->clientName,
			$order->clientEmail,
			$order->clientPhone,
			$order->clientAddress,
			$order->status->value,
			$order->dateCreated->format('Y-m-d H:i:s'),
			$order->dateModified ? $order->dateModified->format('Y-m-d H:i:s') : null,
		];

		$result = DatabaseService::dbExecute($sqlQuery, $types, $params);

		return $result['insert_id'];
	}

	public function getAll(): array
	{
		$sql =
			'SELECT DISTINCT
    			o.id,
    			o.product_id,
    			o.total_price,
				o.client_name,
				o.client_email,
				o.client_phone,
				o.client_address,
				o.status,
				o.date_created,
				o.date_modified
			FROM up_order AS o
			ORDER BY FIELD(o.status, \'pending\', \'paid\', \'sent\', \'completed\', \'cancelled\')';


		$result = DatabaseService::dbQuery($sql);

		$orders = [];
		while ($row = mysqli_fetch_assoc($result))
		{
			$orders[] = $this->mapper->map($row);
		}

		return $orders;
	}
}