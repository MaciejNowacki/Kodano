<?php

declare(strict_types=1);

namespace App\UI\Controller;

use App\Application\Command\Product\CreateProductCommand;
use App\Application\Exception\ValidateException;
use App\Application\Request\Product\CreateProductRequest;
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
            $dto = $this->messageBus->dispatch(new CreateProductCommand($request->getName(), $request->getPrice(), $request->getCategoryId()))->last(HandledStamp::class)->getResult();
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
            $dto,
            Response::HTTP_OK
        );
    }
}