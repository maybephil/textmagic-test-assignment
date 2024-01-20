<?php declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\CreatedAtColumn;
use App\Entity\Trait\IncrementalIdColumn;
use App\Repository\AnswerRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnswerRepository::class)]
#[ORM\Table(name: 'tm_answer')]
#[ORM\Index(columns: [ 'question_id' ], name: 'idx_tm_answer_question_id')]
class Answer
{
    use IncrementalIdColumn, CreatedAtColumn;

    public function __construct(
        #[ORM\ManyToOne(targetEntity: Question::class, cascade: [ 'all' ], inversedBy: 'answers')]
        #[ORM\JoinColumn(name: 'question_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
        private readonly Question $question,

        #[ORM\Column(name: 'description', type: 'text')]
        private readonly string $description,

        #[ORM\Column(name: 'is_valid', type: 'boolean')]
        private readonly bool $isValid,

        DateTimeImmutable $createdAt,
    )
    {
        $this->createdAt = $createdAt;
    }

    public function question(): Question
    {
        return $this->question;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function isValid(): bool
    {
        return $this->isValid;
    }
}
