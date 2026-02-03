<?php
declare(strict_types=1);

namespace Eshop\Controllers;

use Eshop\Mapper\OrderMapper;
use Eshop\Model\Order;
use Eshop\Repository\OrderRepository;

class OrderController extends JsonController
{
	private OrderRepository $orders;

	public function __construct()
	{
		$this->orders = new OrderRepository(new OrderMapper());
	}

	public function createAction(): array
	{
		$orderData = $this->getJsonBody();

		$order = Order::createNew(
			(int)$orderData['product_id'],
			$orderData['total_price'],
			$orderData['client_name'],
			$orderData['client_email'],
			$orderData['client_phone'],
			$orderData['client_address'],
		);

		$orderId = $this->orders->add($order);

		return [
			'ok' => true,
			'orderId' => $orderId,
		];
	}

	public function listAction(): array
	{
		$orders = $this->orders->getAll();

		$items = [];

		foreach ($orders as $order)
		{
			$items[] = $order->toArray();
		}

		return [
			'ok' => true,
			'items' => $items,
		];
	}
}