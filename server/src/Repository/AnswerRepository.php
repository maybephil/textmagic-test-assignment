<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\Answer;
use App\Repository\Trait\BaseRepositoryMethods;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class AnswerRepository extends ServiceEntityRepository
{
    use BaseRepositoryMethods;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Answer::class);
    }
}
