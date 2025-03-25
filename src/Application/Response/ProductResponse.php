<?php

declare(strict_types=1);

namespace App\Application\Response;

use App\Domain\Entity\Category;
use App\Domain\Entity\Product;

readonly class ProductResponse
{
    public function __construct(
        private int    $id,
        private string $name,
        private float  $price,
        private array  $categories
    )
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getCategories(): array
    {
        return $this->categories;
    }

    public static function fromEntity(Product $entity): static
    {
        return new static(
            $entity->getId(),
            $entity->getName(),
            $entity->getPrice(),
            array_map(static fn(Category $category) => new CategoryResponse($category->getId(), $category->getCode()), $entity->getCategories()->toArray())
        );
    }
}