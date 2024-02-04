<?php declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\CreatedAtColumn;
use App\Entity\Trait\IncrementalIdColumn;
use App\Entity\Trait\UuidColumn;
use App\Repository\QuestionRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
#[ORM\Table(name: 'tm_question')]
#[ORM\Index(columns: [ 'assessment_id' ], name: 'idx_tm_question_assessment_id')]
class Question
{
    use IncrementalIdColumn, UuidColumn, CreatedAtColumn;

    #[ORM\OneToMany(mappedBy: 'question', targetEntity: Answer::class, cascade: [ 'all' ])]
    private Collection $answers;

    public function __construct(
        Uuid $uuid,

        #[ORM\ManyToOne(targetEntity: Assessment::class, cascade: [ 'all' ], inversedBy: 'questions')]
        #[ORM\JoinColumn(name: 'assessment_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
        private readonly Assessment $assessment,

        #[ORM\Column(name: 'description', type: 'text')]
        private readonly string $description,

        DateTimeImmutable $createdAt,
    )
    {
        $this->uuid = $uuid;
        $this->createdAt = $createdAt;
        $this->answers = new ArrayCollection();
    }

    public function assessment(): Assessment
    {
        return $this->assessment;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function answers(): Collection
    {
        return $this->answers;
    }
}
