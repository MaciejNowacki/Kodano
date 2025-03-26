<?php

declare(strict_types=1);

namespace App\Application\Notification\Handlers;

interface HandlingStrategyInterface
{
    public function handle(string $title, string $message): void;
}