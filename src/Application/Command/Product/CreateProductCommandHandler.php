<?php

declare(strict_types=1);

namespace App\Application\Command\Product;

use App\Application\Exception\ValidateException;
use App\Application\Response\Product\CreateProductResponse;
use App\Domain\Entity\Product;
use App\Domain\Repository\CategoryRepositoryInterface;
use App\Domain\Repository\ProductRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[AsMessageHandler]
readonly class CreateProductCommandHandler
{
    public function __construct(
        private ValidatorInterface          $validator,
        private ProductRepositoryInterface  $productRepository,
        private CategoryRepositoryInterface $categoryRepository,
    )
    {
    }

    /**
     * @throws ValidateException
     */
    public function __invoke(CreateProductCommand $command): CreateProductResponse
    {
        $errors = $this->validator->validate($command);

        if ($errors->count()) {
            $error = $errors->get(0);
            throw new ValidateException('[' . $error->getPropertyPath() . '] ' . $error->getMessage()); // TODO: more details
        }

        $category = $this->categoryRepository->getById($command->getCategoryId());

        if (!$category) {
            throw new ValidateException('Category not found');
        }

        $entity = new Product($command->getName(), $command->getPrice());
        $entity->getCategories()->add($category);

        $this->productRepository->insert($entity);

        return new CreateProductResponse(
            $entity->getId(),
            $entity->getName(),
            $entity->getPrice(),
            $entity->getCreatedAt(),
            $entity->getUpdatedAt()
        );
    }
}