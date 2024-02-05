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
        private SubmissionGradingService $gradingService,
    )
    {
    }

    public function submit(Assessment $assessment, array $submissionData): void
    {
        /** @var Answer[] $answers */
        $answers = array_reduce(
            array_values($submissionData),
            fn (array $carry, array $answers) => [...$carry, ...$answers],
            [],
        );

        $isCorrect = $this->gradingService->gradeCorrectness($answers);

        $result = new Result(
            $this->uuidFactory->create(),
            $assessment,
            new ArrayCollection($answers),
            $isCorrect,
            new DateTimeImmutable()
        );

        $this->resultRepository->persist($result);
        $this->resultRepository->flush();
    }
}
