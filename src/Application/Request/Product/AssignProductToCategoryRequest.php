<?php

declare(strict_types=1);

namespace App\Application\Request\Product;

class AssignProductToCategoryRequest
{
    public ?array $categoryIds = [];

    public function getCategoryIds(): ?array
    {
        return $this->categoryIds;
    }
}