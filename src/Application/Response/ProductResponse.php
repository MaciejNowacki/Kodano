<?php

declare(strict_types=1);

namespace App\Application\Response;

use App\Domain\Entity\Category;
use App\Domain\Entity\Product;

readonly class ProductResponse
{
    public function __construct(
        public int                                  $id,
        public string                               $name,
        public float                                $price,
        /** @var CategoryResponse[] */ public array $categories
    )
    {
    }

    public static function fromEntity(Product $entity): ProductResponse
    {
        return new ProductResponse(
            $entity->getId(),
            $entity->getName(),
            $entity->getPrice(),
            array_map(static fn(Category $category) => new CategoryResponse($category->getId(), $category->getCode()), $entity->getCategories()->toArray())
        );
    }
}