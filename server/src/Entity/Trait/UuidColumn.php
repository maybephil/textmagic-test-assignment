<?php declare(strict_types=1);

namespace App\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

trait UuidColumn
{
    #[ORM\Column(name: 'uuid', type: UuidType::NAME, unique: true)]
    private readonly Uuid $uuid;

    public function uuid(): Uuid
    {
        return $this->uuid;
    }

    public function uuidBase32(): string
    {
        return $this->uuid->toBase32();
    }
}
