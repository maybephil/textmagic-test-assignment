<?php declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\CreatedAtColumn;
use App\Entity\Trait\IncrementalIdColumn;
use App\Entity\Trait\UuidColumn;
use App\Repository\AssessmentRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: AssessmentRepository::class)]
#[ORM\Table(name: 'tm_assessment')]
class Assessment
{
    use IncrementalIdColumn, UuidColumn, CreatedAtColumn;

    /**
     * @var Collection<Question>
     */
    #[ORM\OneToMany(mappedBy: 'assessment', targetEntity: Question::class, cascade: [ 'all' ])]
    private Collection $questions;

    public function __construct(
        Uuid $uuid,

        #[ORM\Column(name: 'name', type: 'string', length: 120)]
        private readonly string $name,

        #[ORM\Column(name: 'description', type: 'text')]
        private readonly string $description,

        DateTimeImmutable $createdAt,
    )
    {
        $this->uuid = $uuid;
        $this->createdAt = $createdAt;
        $this->questions = new ArrayCollection();
    }

    public function name(): string
    {
        return $this->name;
    }

    public function description(): string
    {
        return $this->description;
    }

    /**
     * @return Collection<Question>
     */
    public function questions(): Collection
    {
        return $this->questions;
    }

    public function numTotalAnswers(): int
    {
        return $this->questions->reduce(
            fn (int $carry, Question $question): int => $carry + $question->answers()->count(),
            0
        );
    }
}
