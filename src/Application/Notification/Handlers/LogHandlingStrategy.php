<?php

declare(strict_types=1);

namespace App\Application\Notification\Handlers;

use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('notification_handling_strategy')]
readonly class LogHandlingStrategy implements HandlingStrategyInterface
{
    public function __construct(private LoggerInterface $notifyLogger)
    {
    }

    public function handle(string $title, string $message): void
    {
        $this->notifyLogger->info($title . ': ' . $message);
    }
}