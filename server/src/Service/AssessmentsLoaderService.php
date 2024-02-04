<?php declare(strict_types=1);

namespace App\Service;

use App\Entity\Answer;
use App\Entity\Assessment;
use App\Entity\Question;
use App\Exception\AssessmentsLoadingFailed;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Uid\Factory\UuidFactory;

final readonly class AssessmentsLoaderService
{
    public function __construct(
        private string $assessmentsDataFilePath,
        private EntityManagerInterface $em,
        private UuidFactory $uuid,
    )
    {
    }

    public function load(): void
    {
        $assessments = $this->readAssessmentsData();

        foreach ($assessments as $assessmentData) {
            $assessment = new Assessment(
                $this->uuid->create(),
                $assessmentData['name'],
                $assessmentData['description'],
                new DateTimeImmutable(),
            );

            $this->em->persist($assessment);

            foreach ($assessmentData['questions'] as $questionData) {
                $question = new Question(
                    $this->uuid->create(),
                    $assessment,
                    $questionData['description'],
                    new DateTimeImmutable(),
                );

                $this->em->persist($question);

                foreach ($questionData['answers'] as $answerData) {
                    $answer = new Answer(
                        $this->uuid->create(),
                        $question,
                        $answerData['description'],
                        $answerData['isValid'],
                        new DateTimeImmutable(),
                    );

                    $this->em->persist($answer);
                }
            }
        }

        $this->em->flush();
    }

    private function readAssessmentsData(): array
    {
        if (!file_exists($this->assessmentsDataFilePath)) {
            throw AssessmentsLoadingFailed::initialDataFileNotFound($this->assessmentsDataFilePath);
        }

        return json_decode(
            file_get_contents($this->assessmentsDataFilePath),
            true,
        );
    }
}
