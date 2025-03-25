<?php

declare(strict_types=1);

namespace App\Application\Command\Product;

use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Type;

readonly class UpdateProductCommand
{
    public function __construct(
        private int                                                            $id,
        #[Type('string'), NotBlank, NotNull, Length(max: 255)] private ?string $name = null,
        #[Type('float'), NotBlank, NotNull] private ?float                     $price = null,
        #[Type('array'), NotBlank, NotNull, Count(min: 1)] private ?array      $categoryIds = [],
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

    public function getCategoryIds(): ?array
    {
        return $this->categoryIds;
    }

    public function getId(): int
    {
        return $this->id;
    }
}