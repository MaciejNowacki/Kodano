<?php

declare(strict_types=1);

namespace App\Application\Request\Product;

class AssignProductToCategoryRequest
{
    /**
     * @var int[]|null
     */
    public ?array $categoryIds = [];

    /**
     * @return int[]|null
     */
    public function getCategoryIds(): ?array
    {
        return $this->categoryIds;
    }
}