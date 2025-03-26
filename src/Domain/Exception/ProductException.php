<?php

declare(strict_types=1);

namespace App\Domain\Exception;

use Exception;

class ProductException extends Exception
{
    public const PRODUCT_NOT_FOUND = 'PRODUCT_NOT_FOUND';
    public const VALIDATION_ERROR = 'VALIDATION_ERROR';
}