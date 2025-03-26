<?php

declare(strict_types=1);

namespace App\Application\Command\Product;

use App\Application\Exception\ValidateException;
use App\Application\Notification\NotificationInterface;
use App\Application\Response\ProductResponse;
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
        private NotificationInterface       $notificationService,
    )
    {
    }

    /**
     * @throws ValidateException
     */
    public function __invoke(CreateProductCommand $command): ProductResponse
    {
        $errors = $this->validator->validate($command);

        if ($errors->count()) {
            throw new ValidateException($errors);
        }

        $entity = new Product($command->getName(), $command->getPrice());

        $categories = $this->categoryRepository->getByIds($command->getCategoryIds());

        foreach ($categories as $category) {
            $entity->getCategories()->add($category);
        }

        $this->productRepository->insert($entity);

        $result = ProductResponse::fromEntity($entity);
        $this->notificationService->notify('Created new product', json_encode($result));

        return $result;
    }
}