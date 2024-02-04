<?php declare(strict_types=1);

namespace App\Exception;

use App\Exception\Common\AppException;

final class AssessmentQuestionsFormCreationFailed extends AppException
{
    public static function assessmentNotFoundById(int $assessmentId): self
    {
        return new self(sprintf('Assessment with ID %d could not be found.', $assessmentId));
    }
}
