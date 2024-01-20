<?php declare(strict_types=1);

namespace App\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

trait IncrementalIdColumn
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id', type: 'bigint')]
    private readonly int $id;

    public function id(): int
    {
        return $this->id;
    }
}
