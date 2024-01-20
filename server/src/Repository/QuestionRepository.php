<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\Question;
use App\Repository\Trait\BaseRepositoryMethods;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class QuestionRepository extends ServiceEntityRepository
{
    use BaseRepositoryMethods;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Question::class);
    }
}
