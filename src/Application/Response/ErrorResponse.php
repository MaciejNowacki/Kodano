<?php

declare(strict_types=1);

namespace App\Application\Response;

class ErrorResponse
{
    public function __construct(public string $message, public int $code = 0, public array $details = [])
    {
    }
}