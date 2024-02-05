<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240205170124 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tm_answer RENAME COLUMN description TO title');
        $this->addSql('ALTER TABLE tm_answer RENAME COLUMN is_valid TO is_correct');
        $this->addSql('ALTER TABLE tm_assessment RENAME COLUMN name TO title');
        $this->addSql('ALTER TABLE tm_question RENAME COLUMN description TO title');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE tm_assessment RENAME COLUMN title TO name');
        $this->addSql('ALTER TABLE tm_answer RENAME COLUMN title TO description');
        $this->addSql('ALTER TABLE tm_answer RENAME COLUMN is_correct TO is_valid');
        $this->addSql('ALTER TABLE tm_question RENAME COLUMN title TO description');
    }
}
