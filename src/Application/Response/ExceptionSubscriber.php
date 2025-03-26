<?php

declare(strict_types=1);

namespace App\Application\Response;

use App\Application\Exception\NotFoundException;
use App\Application\Exception\ValidateException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Throwable;

readonly class ExceptionSubscriber implements EventSubscriberInterface
{
    private const PROD_ENV = 'prod';
    private const DEFAULT_INTERNAL_ERROR_MESSAGE = 'Internal Server Error';

    public function __construct(private KernelInterface $kernel)
    {
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $this->extractException($event->getThrowable());
        $message = $exception->getMessage();
        $httpCode = $this->mapStatusCode($exception);
        $details = [];

        if ($httpCode === Response::HTTP_INTERNAL_SERVER_ERROR && $this->kernel->getEnvironment() === self::PROD_ENV) {
            $message = self::DEFAULT_INTERNAL_ERROR_MESSAGE;
        }

        if ($exception instanceof ValidateException) {
            foreach ($exception->getConstraintViolationList() as $violation) {
                $details[$violation->getPropertyPath()] = $violation->getMessage();
            }
        }

        $response = new JsonResponse(new ErrorResponse($message, $exception->getCode(), $details));
        $response->setStatusCode($this->mapStatusCode($exception));

        $event->setResponse($response);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException'
        ];
    }

    private function mapStatusCode(Throwable $e): int
    {
        return match (true) {
            $e instanceof ValidateException => Response::HTTP_BAD_REQUEST,
            $e instanceof NotFoundException => Response::HTTP_NOT_FOUND,
            $e instanceof HttpExceptionInterface => $e->getStatusCode(),
            default => Response::HTTP_INTERNAL_SERVER_ERROR
        };
    }

    private function extractException(Throwable $e): Throwable
    {
        while ($e instanceof HandlerFailedException) {
            /** @var Throwable $e */
            $e = $e->getPrevious();
        }

        return $e;
    }
}