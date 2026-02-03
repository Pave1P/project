<?php
declare(strict_types=1);

namespace Eshop\Repository;

use Eshop\Mapper\ProductMapper;
use Eshop\Model\Product;
use Eshop\Services\DatabaseService;
use Exception;

class ProductRepository
{

	public function __construct(
		private ProductMapper $mapper,
	) {}

	/**
	 * @return array<int, Product>
	 * @throws Exception
	 */
    public function getAll(?string $category = null): array
    {
		$sql = 'SELECT DISTINCT
					p.id,
					p.name,
					p.description_short,
					p.description_long,
					p.price,
					p.is_active,
					p.user_id,
					p.date_created,
					p.date_modified
				FROM up_product p';

		$types = '';
		$params = [];

		if ($category !== null)
		{
			$sql .= ' INNER JOIN up_category_product pc
						ON pc.product_id = p.id
					  INNER JOIN up_category c
						ON c.id = pc.category_id';
		}

		$sql .= ' WHERE p.is_active = 1';

		if ($category !== null)
		{
			$sql .= ' AND c.slug_code = ?';
			$types = 's';
			$params[] = $category;
		}

		$sql .= ' ORDER BY p.id';

        $result = DatabaseService::dbQuery($sql, $types, $params);

		$products = [];
		while ($row = mysqli_fetch_assoc($result))
		{
			$products[] = $this->mapper->map($row);
		}
		return $products;
    }


	/**
	 * @throws Exception
	 */
	public function getById(int $id): ?Product
    {
		$sqlQuery = 'SELECT DISTINCT
						p.id,
						p.name,
						p.description_short,
						p.description_long,
						p.price,
						p.is_active,
						p.user_id,
						p.date_created,
						p.date_modified
					FROM up_product p
				 	WHERE id = ? AND is_active = true
				 	LIMIT 1';

        $result = DatabaseService::dbQuery($sqlQuery, 'i', [$id]);
        $row = mysqli_fetch_assoc($result);
        return $row ? $this->mapper->map($row) : null;
    }
}
