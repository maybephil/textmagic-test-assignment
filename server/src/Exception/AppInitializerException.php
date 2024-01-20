<?php declare(strict_types=1);

namespace App\Exception;

final class AppInitializerException extends AppException
{
    public static function initialDataFileNotFound(string $fileName): self
    {
        return new self(sprintf('Initial data file "%d" could not be found.', $fileName));
    }

    private function __construct(string $message)
    {
        parent::__construct($message);
    }
}
