<?php

declare(strict_types=1);

namespace App\Application\Request\Product;

class CreateProductRequest
{
    public ?string $name = null;
    public ?float $price = null;
    /**
     * @var int[]|null
     */
    public ?array $categoryIds = [];

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * @return int[]|null
     */
    public function getCategoryIds(): ?array
    {
        return $this->categoryIds;
    }
}