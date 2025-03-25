<?php

declare(strict_types=1);

namespace App\Application\Response;

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
}