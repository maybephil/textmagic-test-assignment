<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\Assessment;
use App\Repository\Trait\BaseRepositoryMethods;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

final class AssessmentRepository extends ServiceEntityRepository
{
    use BaseRepositoryMethods;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Assessment::class);
    }

    public function findOneByBase32Uuid(string $uuidBase32): ?Assessment
    {
        return $this->findOneBy([
            'uuid' => Uuid::fromBase32(
                strtoupper($uuidBase32),
            ),
        ]);
    }
}
