<?php declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\CreatedAtColumn;
use App\Entity\Trait\IncrementalIdColumn;
use App\Entity\Trait\UuidColumn;
use App\Repository\ResultRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: ResultRepository::class)]
#[ORM\Table(name: 'tm_result')]
class Result
{
    use IncrementalIdColumn, UuidColumn, CreatedAtColumn;

    public function __construct(
        Uuid $uuid,

        #[ORM\ManyToOne(targetEntity: Assessment::class, cascade: [ 'all' ])]
        #[ORM\JoinColumn(name: 'assessment_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
        private readonly Assessment $assessment,

        #[ORM\JoinTable(
            name: 'tm_answer_to_result',
            joinColumns: [
                new ORM\JoinColumn(name: 'result_id', referencedColumnName: 'id', onDelete: 'CASCADE'),
            ],
            inverseJoinColumns: [
                new ORM\InverseJoinColumn(name: 'answer_id', referencedColumnName: 'id', onDelete: 'CASCADE'),
            ]
        )]
        #[ORM\ManyToMany(targetEntity: Answer::class, cascade: [ 'all' ])]
        private Collection $answers,

        #[ORM\Column(name: 'is_correct', type: 'boolean')]
        private readonly bool $isCorrect,

        DateTimeImmutable $createdAt,
    )
    {
        $this->uuid = $uuid;
        $this->createdAt = $createdAt;
    }

    public function assessment(): Assessment
    {
        return $this->assessment;
    }

    public function answers(): Collection
    {
        return $this->answers;
    }

    public function isCorrect(): bool
    {
        return $this->isCorrect;
    }

    public function correctAnswers(): Collection
    {
        return $this->answers->filter(fn(Answer $answer) => $answer->isCorrect());
    }

    public function incorrectAnswers(): Collection
    {
        return $this->answers->filter(fn(Answer $answer) => !$answer->isCorrect());
    }
}
