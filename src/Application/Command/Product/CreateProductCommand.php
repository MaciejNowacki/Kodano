<?php

declare(strict_types=1);

namespace App\Application\Command\Product;

use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\LessThan;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\Type;

readonly class CreateProductCommand
{
    public function __construct(
        #[Type('string'), NotBlank, NotNull, Length(max: 255)] private ?string                   $name = null,
        #[Type('float'), NotBlank, NotNull, Positive, LessThan(99999999)] private ?float         $price = null,
        /** @var null|int[] */ #[Type('array'), NotBlank, NotNull, Count(min: 1)] private ?array $categoryIds = [],
    )
    {
    }

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