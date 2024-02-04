<?php declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\CreatedAtColumn;
use App\Entity\Trait\IncrementalIdColumn;
use App\Entity\Trait\UuidColumn;
use DateTimeImmutable;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
#[ORM\Table(name: 'tm_result')]
class Result
{
    use IncrementalIdColumn, UuidColumn, CreatedAtColumn;

    public function __construct(
        Uuid $uuid,

        #[ORM\ManyToOne(targetEntity: Assessment::class, cascade: [ 'all' ])]
        #[ORM\JoinColumn(name: 'assessment_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
        private Assessment $assessment,

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

        #[ORM\Column(name: 'is_successful', type: 'boolean')]
        private bool $isSuccessful,

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
        return $this->answers();
    }

    public function isSuccessful(): bool
    {
        return $this->isSuccessful;
    }

    public function validAnswers(): Collection
    {
        return $this->answers->filter(fn(Answer $answer) => $answer->isValid());
    }

    public function invalidAnswers(): Collection
    {
        return $this->answers->filter(fn(Answer $answer) => !$answer->isValid());
    }
}
