<?php declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\CreatedAtColumn;
use App\Entity\Trait\IncrementalIdColumn;
use App\Entity\Trait\UuidColumn;
use App\Repository\AnswerRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: AnswerRepository::class)]
#[ORM\Table(name: 'tm_answer')]
#[ORM\Index(columns: [ 'question_id' ], name: 'idx_tm_answer_question_id')]
class Answer
{
    use IncrementalIdColumn, UuidColumn, CreatedAtColumn;

    public function __construct(
        Uuid $uuid,

        #[ORM\ManyToOne(targetEntity: Question::class, cascade: [ 'all' ], inversedBy: 'answers')]
        #[ORM\JoinColumn(name: 'question_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
        private readonly Question $question,

        #[ORM\Column(name: 'title', type: 'text')]
        private readonly string $title,

        #[ORM\Column(name: 'is_correct', type: 'boolean')]
        private readonly bool $isCorrect,

        DateTimeImmutable $createdAt,
    )
    {
        $this->uuid = $uuid;
        $this->createdAt = $createdAt;
    }

    public function question(): Question
    {
        return $this->question;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function isCorrect(): bool
    {
        return $this->isCorrect;
    }
}
