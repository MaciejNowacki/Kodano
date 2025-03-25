<?php

declare(strict_types=1);

namespace App\Application\Query\Product;

readonly class ProductByIdQuery
{
    public function __construct(
        private int $productId
    )
    {
    }

    public function getProductId(): int
    {
        return $this->productId;
    }
}