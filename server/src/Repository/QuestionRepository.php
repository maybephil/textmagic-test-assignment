<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\Question;
use App\Repository\Trait\BaseRepositoryMethods;
use App\Repository\Trait\UuidRepositoryMethods;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

final class QuestionRepository extends ServiceEntityRepository
{
    use BaseRepositoryMethods, UuidRepositoryMethods;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Question::class);
    }

    /**
     * @return Question[]
     */
    public function findAllWithAnswersByAssessmentId(int $assessmentId): array
    {
        return $this->createQueryBuilder('q')
            ->select('q', 'a')
            ->innerJoin('q.answers', 'a')
            ->where('q.assessment = :assessmentId')
            ->setParameter('assessmentId', $assessmentId)
            ->getQuery()
            ->getResult();
    }
}
