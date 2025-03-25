<?php

declare(strict_types=1);

namespace App\Application\Command\Product;

readonly class DeleteProductCommand
{
    public function __construct(
        private int $productId,
    )
    {
    }

    public function getProductId(): ?int
    {
        return $this->productId;
    }
}