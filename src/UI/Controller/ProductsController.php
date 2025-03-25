<?php

declare(strict_types=1);

namespace App\UI\Controller;

use App\Application\Command\Product\AssignProductToCategoryCommand;
use App\Application\Command\Product\CreateProductCommand;
use App\Application\Command\Product\DeleteProductCommand;
use App\Application\Query\Product\ProductCollectionQuery;
use App\Application\Request\Product\AssignProductToCategoryRequest;
use App\Application\Request\Product\CreateProductRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/products', name: 'products')]
class ProductsController extends AbstractController
{
    public function __construct(
        private MessageBusInterface $messageBus
    )
    {
    }

    #[Route(name: 'post', methods: ['POST'])]
    final public function postAction(
        #[MapRequestPayload] CreateProductRequest $request
    ): JsonResponse
    {
        $result = $this->messageBus->dispatch(new CreateProductCommand($request->getName(), $request->getPrice(), $request->getCategoryIds()))->last(HandledStamp::class)->getResult();

        return $this->json(
            $result,
            Response::HTTP_OK
        );
    }

    #[Route('/{productId}', name: 'delete', methods: ['DELETE'])]
    final public function deleteAction(
        int $productId
    ): JsonResponse
    {
        $this->messageBus->dispatch(new DeleteProductCommand($productId));

        return $this->json(
            null,
            Response::HTTP_NO_CONTENT
        );
    }

    #[Route(path: '/{productId}/categories', name: 'patch', methods: ['PATCH'])]
    final public function patchAction(
        #[MapRequestPayload] AssignProductToCategoryRequest $request,
        int                                                 $productId
    ): JsonResponse
    {
        $result = $this->messageBus->dispatch(new AssignProductToCategoryCommand($productId, $request->getCategoryIds()))->last(HandledStamp::class)->getResult();

        return $this->json(
            $result,
            Response::HTTP_OK
        );
    }

    #[Route(name: 'cget', methods: ['GET'])]
    final public function cgetAction(): JsonResponse
    {
        $result = $this->messageBus->dispatch(new ProductCollectionQuery())->last(HandledStamp::class)->getResult();

        return $this->json(
            $result,
            Response::HTTP_OK
        );
    }
}