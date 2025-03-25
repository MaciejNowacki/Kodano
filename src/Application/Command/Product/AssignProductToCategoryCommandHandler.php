<?php

declare(strict_types=1);

namespace App\Application\Command\Product;

use App\Application\Exception\ValidateException;
use App\Application\Response\CategoryResponse;
use App\Application\Response\ProductResponse;
use App\Domain\Entity\Category;
use App\Domain\Repository\CategoryRepositoryInterface;
use App\Domain\Repository\ProductRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[AsMessageHandler]
readonly class AssignProductToCategoryCommandHandler
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
    public function __invoke(AssignProductToCategoryCommand $command): ProductResponse
    {
        $errors = $this->validator->validate($command);

        if ($errors->count()) {
            $error = $errors->get(0);
            throw new ValidateException('[' . $error->getPropertyPath() . '] ' . $error->getMessage()); // TODO: more details
        }

        $entity = $this->productRepository->getById($command->getProductId());

        if (!$entity) {
            throw new ValidateException('Invalid product id');
        }

        $entity->getCategories()->clear();

        $categories = $this->categoryRepository->getByIds($command->getCategoryIds());

        foreach ($categories as $category) {
            $entity->getCategories()->add($category);
        }

        $this->productRepository->update($entity);

        return new ProductResponse(
            $entity->getId(),
            $entity->getName(),
            $entity->getPrice(),
            array_map(static fn(Category $category) => new CategoryResponse($category->getId(), $category->getCode()), $entity->getCategories()->toArray())
        );
    }
}