<?php declare(strict_types=1);

namespace App\Service;

use App\Entity\Answer;
use App\Entity\Assessment;
use App\Entity\Result;
use App\Exception\ResultSubmissionFailed;
use App\Repository\ResultRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Uid\Factory\UuidFactory;

final readonly class ResultSubmissionService
{
    public function __construct(
        private UuidFactory $uuidFactory,
        private ResultRepository $resultRepository,
    )
    {
    }

    public function submit(Assessment $assessment, array $submissionData): void
    {
        $answers = array_reduce(
            array_values($submissionData),
            fn (array $carry, array $answers) => [...$carry, ...$answers],
            [],
        );

        $hasInvalidAnswers = array_reduce(
            $answers,
            fn (bool $carry, Answer $answer): bool => $carry || !$answer->isValid(),
            false
        );

        if (empty($answers)) {
            throw ResultSubmissionFailed::noAnswersSubmitted($assessment->uuidAsString());
        }

        $result = new Result(
            $this->uuidFactory->create(),
            $assessment,
            new ArrayCollection($answers),
            !$hasInvalidAnswers,
            new DateTimeImmutable()
        );

        $this->resultRepository->persist($result);
        $this->resultRepository->flush();
    }
}
