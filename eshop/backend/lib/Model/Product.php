<?php
declare(strict_types=1);

namespace Eshop\Model;

use DateTime;

class Product
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $descriptionShort,
        public readonly string $descriptionLong,
        public readonly string $price,
        public readonly bool $isActive,
        public readonly DateTime $dateCreated,
        public readonly DateTime $dateModified,
    ) {}

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description_short' => $this->descriptionShort,
            'description_long' => $this->descriptionLong,
            'price' => $this->price,
            'is_active' => $this->isActive,
            'date_created' => $this->dateCreated->format('Y-m-d H:i:s'),
            'date_modified' => $this->dateModified->format('Y-m-d H:i:s'),
        ];
    }
}
