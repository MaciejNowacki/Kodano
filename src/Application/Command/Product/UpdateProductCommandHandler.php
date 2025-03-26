<?php

declare(strict_types=1);

namespace App\Application\Command\Product;

use App\Application\Exception\NotFoundException;
use App\Application\Exception\ValidateException;
use App\Application\Notification\NotificationInterface;
use App\Application\Response\ProductResponse;
use App\Domain\Exception\ProductException;
use App\Domain\Repository\CategoryRepositoryInterface;
use App\Domain\Repository\ProductRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[AsMessageHandler]
readonly class UpdateProductCommandHandler
{
    public function __construct(
        private ValidatorInterface          $validator,
        private ProductRepositoryInterface  $productRepository,
        private CategoryRepositoryInterface $categoryRepository,
        private NotificationInterface       $notificationService
    )
    {
    }

    /**
     * @throws ValidateException
     * @throws NotFoundException
     */
    public function __invoke(UpdateProductCommand $command): ProductResponse
    {
        $errors = $this->validator->validate($command);

        if ($errors->count()) {
            $error = $errors->get(0);
            throw new ValidateException('[' . $error->getPropertyPath() . '] ' . $error->getMessage()); // TODO: more details
        }

        $entity = $this->productRepository->getById($command->getId());

        if (!$entity) {
            throw new NotFoundException(ProductException::PRODUCT_NOT_FOUND);
        }

        $entity
            ->setName($command->getName())
            ->setPrice($command->getPrice());
        $entity->getCategories()->clear();

        $categories = $this->categoryRepository->getByIds($command->getCategoryIds());

        foreach ($categories as $category) {
            $entity->getCategories()->add($category);
        }

        $this->productRepository->update($entity);

        $result = ProductResponse::fromEntity($entity);
        $this->notificationService->notify('Updated product', json_encode($result));

        return $result;
    }
}