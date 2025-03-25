<?php

declare(strict_types=1);

namespace App\Application\Query\Product;

use App\Application\Response\ProductResponse;
use App\Domain\Repository\ProductRepositoryInterface;
use Exception;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class ProductByIdQueryHandler
{

    public function __construct(
        private ProductRepositoryInterface $repository,
    )
    {
    }

    /**
     * @throws Exception
     */
    public function __invoke(ProductByIdQuery $query): ProductResponse
    {
        $entity = $this->repository->getById($query->getProductId());

        return ProductResponse::fromEntity($entity);
    }
}