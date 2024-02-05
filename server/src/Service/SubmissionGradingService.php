<?php declare(strict_types=1);

namespace App\Service;

use App\Entity\Answer;

final class SubmissionGradingService
{
    /**
     * @param Answer[] $answers
     */
    public function gradeCorrectness(array $answers): bool
    {
        foreach ($answers as $answer) {
            if (!$answer->isCorrect()) {
                return false;
            }
        }

        return true;
    }
}
