<?php declare(strict_types=1);

namespace App\Service;

use App\Entity\Answer;
use App\Entity\Assessment;
use App\Entity\Config;
use App\Entity\Question;
use App\Exception\AppInitializerException;
use App\Repository\ConfigRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Uid\Factory\UuidFactory;

final readonly class AppInitializerService
{
    private const string KEY_APP_INITIALIZED = 'is_app_initialized';

    public function __construct(
        private string $assessmentsDataFilePath,
        private ConfigRepository $configs,
        private EntityManagerInterface $em,
        private UuidFactory $uuid,
    )
    {
    }

    public function isAppInitialized(): bool
    {
        return $this->configs->hasValueByKey(
            self::KEY_APP_INITIALIZED,
            Config::boolToConfigValue(true),
        );
    }

    public function markAppAsInitialized(): void
    {
        $this->configs->createOrUpdate(
            new Config(
                self::KEY_APP_INITIALIZED,
                Config::boolToConfigValue(true),
                new DateTimeImmutable(),
            ),
        );
    }

    public function loadAssessmentsData(): void
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
                    $assessment,
                    $questionData['description'],
                    new DateTimeImmutable(),
                );

                $this->em->persist($question);

                foreach ($questionData['answers'] as $answerData) {
                    $answer = new Answer(
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
            throw AppInitializerException::initialDataFileNotFound($this->assessmentsDataFilePath);
        }

        return json_decode(
            file_get_contents($this->assessmentsDataFilePath),
            true,
        );
    }
}
