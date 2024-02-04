<?php declare(strict_types=1);

namespace App\Repository\Trait;

use App\Entity\Assessment;
use Symfony\Component\Uid\Uuid;

trait UuidRepositoryMethods
{
    public function findOneByUuidAsString(string $uuid): ?Assessment
    {
        return $this->findOneBy([
            'uuid' => Uuid::fromRfc4122($uuid),
        ]);
    }

    public function findByUuidsAsString(array $uuids): array
    {
        return $this->findBy([
            'uuid' => array_map(
                fn(string $uuid) => Uuid::fromBase32($uuid),
                $uuids,
            ),
        ]);
    }
}
