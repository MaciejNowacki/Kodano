<?php

declare(strict_types=1);

namespace App\Application\Command\Product;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Type;

readonly class CreateProductCommand
{
    public function __construct(
        #[Type('string'), NotBlank, NotNull, Length(max: 255)] private ?string $name = null,
        #[Type('float'), NotBlank, NotNull] private ?float                     $price = null,
        #[Type('integer'), NotBlank, NotNull] private ?int                     $categoryId = null,
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

    public function getCategoryId(): ?int
    {
        return $this->categoryId;
    }
}