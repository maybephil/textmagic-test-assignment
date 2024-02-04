<?php declare(strict_types=1);

namespace App\Exception;

use App\Exception\Common\AppException;

final class AssessmentsLoadingFailed extends AppException
{
    public static function initialDataFileNotFound(string $fileName): self
    {
        return new self(sprintf('Initial data file "%d" could not be found.', $fileName));
    }
}
