<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Category;

interface CategoryRepositoryInterface
{
    public function insert(Category $entity): void;

    /**
     * @param int[] $ids
     * @return Category[]
     */
    public function getByIds(array $ids): array;

    /**
     * @return Category[]
     */
    public function getAll(): array;
}