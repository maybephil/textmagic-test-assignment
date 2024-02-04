<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\Result;
use App\Repository\Trait\BaseRepositoryMethods;
use App\Repository\Trait\UuidRepositoryMethods;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class ResultRepository extends ServiceEntityRepository
{
    use BaseRepositoryMethods, UuidRepositoryMethods;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Result::class);
    }
}
