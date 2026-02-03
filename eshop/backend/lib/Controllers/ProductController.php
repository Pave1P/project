<?php
declare(strict_types=1);

namespace Eshop\Controllers;

use Eshop\Services\ProductService;

class ProductController extends JsonController
{
    private ProductService $productService;

    public function __construct()
    {
        $this->productService = new ProductService();
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


		$products = $this->productService->getAll($category);

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

		$product = $this->productService->getById($id);

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
