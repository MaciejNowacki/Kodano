<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Category;

interface CategoryRepositoryInterface
{
    public function insert(Category $entity): void;

    public function getByIds(array $ids): array;

    public function getAll(): array;
}