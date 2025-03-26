<?php

declare(strict_types=1);

namespace App\Application\Query\Product;

use App\Application\Response\ProductResponse;
use App\Domain\Entity\Product;
use App\Domain\Repository\ProductRepositoryInterface;
use Exception;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class ProductCollectionHandler
{

    public function __construct(
        private ProductRepositoryInterface $repository,
    )
    {
    }

    /**
     * @param ProductCollectionQuery $query
     * @return ProductResponse[]
     */
    public function __invoke(ProductCollectionQuery $query): array
    {
        $result = $this->repository->getAll();

        return array_map(static fn(Product $entity) => ProductResponse::fromEntity($entity), $result);
    }
}