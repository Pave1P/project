<?php
declare(strict_types=1);

namespace Eshop\Mapper;

interface MapperInterface
{
    public function map(array $row): ?object;
}