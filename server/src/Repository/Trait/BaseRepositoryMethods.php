<?php declare(strict_types=1);

namespace App\Repository\Trait;

use Doctrine\ORM\EntityManagerInterface;

trait BaseRepositoryMethods
{
    /**
     * @return EntityManagerInterface
     */
    protected abstract function getEntityManager();

    public function persist(object $entity): void
    {
        $this->getEntityManager()->persist($entity);
    }

    public function flush(): void
    {
        $this->getEntityManager()->flush();
    }
}
