<?php

declare(strict_types=1);

namespace App\UI\Controller;

use App\Application\Command\Product\AssignProductToCategoryCommand;
use App\Application\Command\Product\CreateProductCommand;
use App\Application\Exception\ValidateException;
use App\Application\Query\Product\ProductCollectionQuery;
use App\Application\Request\Product\CreateProductRequest;
use App\Application\Request\Product\AssignProductToCategoryRequest;
use App\Application\Response\ErrorResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Attribute\Route;
use Throwable;

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
        try {
            $result = $this->messageBus->dispatch(new CreateProductCommand($request->getName(), $request->getPrice(), $request->getCategoryIds()))->last(HandledStamp::class)->getResult();
        } catch (Throwable $e) { // TODO: extract to exception subscriber
            $previous = $e->getPrevious();

            if ($previous instanceof ValidateException) {
                return $this->json(
                    new ErrorResponse(
                        $previous->getMessage()
                    ),
                    Response::HTTP_BAD_REQUEST
                );
            }

            return $this->json(
                new ErrorResponse(
                    'Something went wrong!'
                ),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return $this->json(
            $result,
            Response::HTTP_OK
        );
    }

    #[Route(path: '/{productId}/categories', name: 'patch', methods: ['PATCH'])]
    final public function patchAction(
        #[MapRequestPayload] AssignProductToCategoryRequest $request,
        int                                                 $productId
    ): JsonResponse
    {
        try {
            $result = $this->messageBus->dispatch(new AssignProductToCategoryCommand($productId, $request->getCategoryIds()))->last(HandledStamp::class)->getResult();
        } catch (Throwable $e) { // TODO: exception subscriber
            $previous = $e->getPrevious();

            if ($previous instanceof ValidateException) {
                return $this->json(
                    new ErrorResponse(
                        $previous->getMessage()
                    ),
                    Response::HTTP_BAD_REQUEST
                );
            }

            return $this->json(
                new ErrorResponse(
                    'Something went wrong!'
                ),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return $this->json(
            $result,
            Response::HTTP_OK
        );
    }

    #[Route(name: 'cget', methods: ['GET'])]
    final public function cgetAction(): JsonResponse
    {
        try {
            $result = $this->messageBus->dispatch(new ProductCollectionQuery())->last(HandledStamp::class)->getResult();
        } catch (Throwable) {
            return $this->json(
                new ErrorResponse(
                    'Something went wrong!'
                ),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return $this->json(
            $result,
            Response::HTTP_OK
        );
    }
}