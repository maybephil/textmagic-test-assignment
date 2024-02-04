<?php declare(strict_types=1);

namespace App\Exception\Common;

use DomainException;

abstract class AppException extends DomainException
{
    protected final function __construct(string $message)
    {
        parent::__construct($message);
    }
}
