<?php

declare(strict_types=1);

namespace App\Application\Command\Product;

use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Type;

readonly class AssignProductToCategoryCommand
{
    public function __construct(
        #[Type('int'), NotBlank, NotNull] private ?int                                           $productId = null,
        /** @var null|int[] */ #[Type('array'), NotBlank, NotNull, Count(min: 1)] private ?array $categoryIds = [],
    )
    {
    }

    public function getProductId(): ?int
    {
        return $this->productId;
    }

    /**
     * @return int[]|null
     */
    public function getCategoryIds(): ?array
    {
        return $this->categoryIds;
    }
}