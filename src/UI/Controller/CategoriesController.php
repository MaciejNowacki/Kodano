<?php

declare(strict_types=1);

namespace App\UI\Controller;

use App\Application\Query\Category\CategoryCollectionQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/categories', name: 'categories')]
class CategoriesController extends AbstractController
{
    public function __construct(
        private MessageBusInterface $messageBus
    )
    {
    }

    #[Route(name: 'cget', methods: ['GET'])]
    final public function cgetAction(): JsonResponse
    {
        $result = $this->messageBus->dispatch(new CategoryCollectionQuery())->last(HandledStamp::class)->getResult();

        return $this->json(
            $result,
            Response::HTTP_OK
        );
    }
}