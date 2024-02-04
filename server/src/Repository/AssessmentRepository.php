<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\Assessment;
use App\Repository\Trait\BaseRepositoryMethods;
use App\Repository\Trait\UuidRepositoryMethods;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

final class AssessmentRepository extends ServiceEntityRepository
{
    use BaseRepositoryMethods, UuidRepositoryMethods;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Assessment::class);
    }
}
