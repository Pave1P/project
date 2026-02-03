<?php
declare(strict_types=1);

namespace Eshop\Services;

use Eshop\Mapper\ProductMapper;
use Eshop\Model\Product;
use Eshop\Repository\ProductRepository;
use Exception;

class ProductService
{
	private ProductRepository $products;

	public function __construct()
	{
		$this->products = new ProductRepository(new ProductMapper());
	}

	/**
	 * @return array<int, Product>
	 * @throws Exception
	 */
	public function getAll(?string $category = null): array
	{
		return $this->products->getAll($category);
	}

	/**
	 * @throws Exception
	 */
	public function getById(int $id): ?Product
	{
		return $this->products->getById($id);
	}
}
