<?php

declare(strict_types=1);

namespace App\Application\Exception;

use App\Domain\Exception\ProductException;
use Exception;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Throwable;

class ValidateException extends Exception
{
    private ConstraintViolationListInterface $constraintViolationList;

    public function __construct(ConstraintViolationListInterface $constraintViolationList, $message = ProductException::VALIDATION_ERROR, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->constraintViolationList = $constraintViolationList;
    }

    public function getConstraintViolationList(): ConstraintViolationListInterface
    {
        return $this->constraintViolationList;
    }
}