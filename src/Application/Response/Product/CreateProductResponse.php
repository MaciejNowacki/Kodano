<?php

declare(strict_types=1);

namespace App\Application\Response\Product;

use DateTimeInterface;

readonly class CreateProductResponse
{
    public function __construct(
        private int               $id,
        private string            $name,
        private float             $price,
        private DateTimeInterface $createdAt,
        private ?DateTimeInterface $updatedAt
    )
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }
}