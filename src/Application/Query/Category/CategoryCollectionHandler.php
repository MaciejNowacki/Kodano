<?php

declare(strict_types=1);

namespace App\Application\Query\Category;

use App\Application\Response\CategoryResponse;
use App\Domain\Entity\Category;
use App\Domain\Repository\CategoryRepositoryInterface;
use Exception;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class CategoryCollectionHandler
{

    public function __construct(
        private CategoryRepositoryInterface $repository,
    )
    {
    }

    /**
     * @param CategoryCollectionQuery $query
     * @return CategoryResponse[]
     */
    public function __invoke(CategoryCollectionQuery $query): array
    {
        $result = $this->repository->getAll();

        return array_map(static fn(Category $entity) => CategoryResponse::fromEntity($entity), $result);
    }
}