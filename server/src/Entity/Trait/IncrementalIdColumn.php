<?php declare(strict_types=1);

namespace App\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

trait IncrementalIdColumn
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id', type: 'bigint')]
    private readonly string $id;

    public function id(): string
    {
        return $this->id;
    }

    public function idAsInt(): int
    {
        return (int) $this->id;
    }
}
