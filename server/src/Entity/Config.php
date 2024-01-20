<?php declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\CreatedAtColumn;
use App\Entity\Trait\IncrementalIdColumn;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'tm_config')]
class Config
{
    use IncrementalIdColumn, CreatedAtColumn;

    public const string VALUE_TRUE = '1';
    public const string VALUE_FALSE = '0';

    public static function boolToConfigValue(bool $value): string
    {
        return $value ? self::VALUE_TRUE : self::VALUE_FALSE;
    }

    public function __construct(
        #[ORM\Column(name: 'key', type: 'string', length: 120, unique: true)]
        private readonly string $key,

        #[ORM\Column(name: 'value', type: 'string', length: 240, nullable: true)]
        private ?string $value,

        DateTimeImmutable $createdAt,
    ) {
        $this->createdAt = $createdAt;
    }

    public function key(): string
    {
        return $this->key;
    }

    public function value(): ?string
    {
        return $this->value;
    }

    public function updateValue(string $newValue): void
    {
        $this->value = $newValue;
    }
}
