<?php
declare(strict_types=1);

namespace Eshop\Controllers;

use Eshop\Mapper\ProductMapper;
use Eshop\Repository\ProductRepository;

class ProductController extends JsonController
{
	private ProductRepository $products;

	public function __construct()
	{
		$this->products = new ProductRepository(new ProductMapper());
	}


	public function listAction(): array
	{
		$category = null;

		if (array_key_exists('category', $_GET)) {
			$value = $_GET['category'];

			if (!is_string($value) || trim($value) === '' || !preg_match('/^[a-z]+$/i', $value))
			{
				return [
					'ok' => false,
					'error' => 'Invalid category',
				];
			}

			$category = trim($value);
		}


		$products = $this->products->getAll($category);

		$items = [];

		foreach ($products as $product) {
			$items[] = $product->toArray();
		}

		return [
			'ok' => true,
			'items' => $items,
		];
	}

	public function detailAction(string $id): array
	{
		$id = (int)$id;

		if ($id <= 0) {
			return [
				'ok' => false,
				'error' => 'Invalid product id',
			];
		}

		$product = $this->products->getById($id);

		if ($product === null)
		{
			return [
				'ok' => false,
				'error' => 'Product not found',
			];
		}

		return [
			'ok' => true,
			'item' => $product->toArray(),
		];
	}
}
