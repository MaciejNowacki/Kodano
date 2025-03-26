<?php

declare(strict_types=1);

namespace App\Application\Notification;

use App\Application\Notification\Handlers\HandlingStrategyInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;
use Throwable;

readonly class NotificationService implements NotificationInterface
{
    public function __construct(
        /** @var HandlingStrategyInterface[] */
        #[TaggedIterator('notification_handling_strategy')]
        private iterable $strategies,
        private LoggerInterface $notifyLogger,
    )
    {
    }

    public function notify(string $title, string $message): void
    {
        /** @var HandlingStrategyInterface $strategy */
        foreach ($this->strategies as $strategy) {
            try {
                $strategy->handle($title, $message);
            } catch (Throwable $e) {
                $this->notifyLogger->error($e->getMessage());
            }
        }
    }
}