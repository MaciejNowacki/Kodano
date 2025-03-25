<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Product;

interface ProductRepositoryInterface
{
    public function insert(Product $entity): void;

    public function getById(int $id): ?Product;
}