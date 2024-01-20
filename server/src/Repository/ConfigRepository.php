<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\Config;
use App\Repository\Trait\BaseRepositoryMethods;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class ConfigRepository extends ServiceEntityRepository
{
    use BaseRepositoryMethods;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Config::class);
    }

    public function hasValueByKey(string $key, string $value): bool
    {
        return $this->count([ 'key' => $key, 'value' => $value ]) > 0;
    }

    public function createOrUpdate(Config $config): void
    {
        /** @var ?Config $dbConfig */
        $dbConfig = $this->findOneBy([ 'key' => $config->key() ]);

        $dbConfig === null
            ? $dbConfig = $config
            : $dbConfig->updateValue($config->value());

        $this->persist($dbConfig);
        $this->flush();
    }
}
