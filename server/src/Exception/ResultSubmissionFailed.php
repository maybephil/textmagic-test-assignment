<?php declare(strict_types=1);

namespace App\Exception;

use App\Exception\Common\AppException;

final class ResultSubmissionFailed extends AppException
{
    public static function noAnswersSubmitted(string $assessmentUuid): self
    {
        return new self("No answers were submitted for assessment with UUID: $assessmentUuid");
    }
}
