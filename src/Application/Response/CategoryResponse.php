<?php

declare(strict_types=1);

namespace App\Application\Response;

use App\Domain\Entity\Category;

readonly class CategoryResponse
{
    public function __construct(
        private int    $id,
        private string $code
    )
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public static function fromEntity(Category $entity): static
    {
        return new static(
            $entity->getId(),
            $entity->getCode()
        );
    }
}