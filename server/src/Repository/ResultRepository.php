<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\Answer;
use App\Entity\Question;
use App\Entity\Result;
use App\Repository\Trait\BaseRepositoryMethods;
use App\Repository\Trait\UuidRepositoryMethods;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Persistence\ManagerRegistry;

final class ResultRepository extends ServiceEntityRepository
{
    use BaseRepositoryMethods, UuidRepositoryMethods;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Result::class);
    }

    public function findCorrectlyAnsweredQuestionsForResult(Result $result): Collection
    {
        $correctAnswersIds = $result->correctAnswers()->map(fn(Answer $answer) => $answer->id());
        $incorrectAnswerIds = $result->incorrectAnswers()->map(fn(Answer $answer) => $answer->id());

        return $result->assessment()->questions()
            ->filter(
                fn(Question $question) =>
                    $question->answers()->filter(
                        fn(Answer $answer) => $correctAnswersIds->contains($answer->id()),
                    )->count() > 0 &&
                    $question->answers()->filter(
                        fn(Answer $answer) => $incorrectAnswerIds->contains($answer->id()),
                    )->count() === 0,
            );
    }

    public function findIncorrectlyAnsweredQuestionsForResult(Result $result): Collection
    {
        $incorrectAnswerIds = $result->incorrectAnswers()->map(fn(Answer $answer) => $answer->id());

        return $result->assessment()->questions()
            ->filter(
                fn(Question $question) =>
                    $question->answers()->filter(
                        fn(Answer $answer) => $incorrectAnswerIds->contains($answer->id()),
                    )->count() > 0
            );
    }

    public function findAllQuestionsForResult(Result $result): Collection
    {
        return $result->assessment()->questions();
    }

    public function fetchResultsData(): array
    {
        $results = $this->findBy([], [ 'createdAt' => 'desc' ]);

        return array_map(
            fn(Result $result) => [
                'result' => $result,
                'num_correct_questions' => $this->findCorrectlyAnsweredQuestionsForResult($result)->count(),
                'num_questions' => $this->findAllQuestionsForResult($result)->count(),
            ],
            $results,
        );
    }
}
