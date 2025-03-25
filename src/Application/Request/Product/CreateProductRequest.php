<?php

declare(strict_types=1);

namespace App\Application\Request\Product;

class CreateProductRequest
{
    public ?string $name = null;
    public ?float $price = null;
    public ?array $categoryIds = [];

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function getCategoryIds(): ?array
    {
        return $this->categoryIds;
    }
}