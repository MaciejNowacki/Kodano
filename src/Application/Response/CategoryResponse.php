<?php

declare(strict_types=1);

namespace App\Application\Response;

use App\Domain\Entity\Category;

readonly class CategoryResponse
{
    public function __construct(
        public int    $id,
        public string $code
    )
    {
    }

    public static function fromEntity(Category $entity): static
    {
        return new static(
            $entity->getId(),
            $entity->getCode()
        );
    }
}