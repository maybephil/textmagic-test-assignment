<?php declare(strict_types=1);

namespace App\Entity\Trait;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

trait CreatedAtColumn
{
    #[ORM\Column(name: 'created_at', type: 'datetime_immutable')]
    private readonly DateTimeImmutable $createdAt;

    public function createdAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }
}
