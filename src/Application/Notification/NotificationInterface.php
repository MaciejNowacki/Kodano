<?php

declare(strict_types=1);

namespace App\Application\Notification;

interface NotificationInterface
{
    public function notify(string $title, string $message): void;
}