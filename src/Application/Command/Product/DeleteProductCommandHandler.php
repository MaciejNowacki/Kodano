<?php

declare(strict_types=1);

namespace App\Application\Command\Product;

use App\Application\Exception\NotFoundException;
use App\Domain\Exception\ProductException;
use App\Domain\Repository\ProductRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class DeleteProductCommandHandler
{
    public function __construct(
        private ProductRepositoryInterface $productRepository
    )
    {
    }

    /**
     * @throws NotFoundException
     */
    public function __invoke(DeleteProductCommand $command): void
    {
        $entity = $this->productRepository->getById($command->getProductId());

        if (!$entity) {
            throw new NotFoundException(ProductException::PRODUCT_NOT_FOUND);
        }

        $this->productRepository->delete($entity);
    }
}