<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240120083300 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE tm_answer_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tm_assessment_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tm_config_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tm_question_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE tm_answer (id BIGINT NOT NULL, question_id BIGINT DEFAULT NULL, description TEXT NOT NULL, is_valid BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_tm_answer_question_id ON tm_answer (question_id)');
        $this->addSql('COMMENT ON COLUMN tm_answer.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE tm_assessment (id BIGINT NOT NULL, name VARCHAR(120) NOT NULL, description TEXT NOT NULL, uuid UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3C5A4192D17F50A6 ON tm_assessment (uuid)');
        $this->addSql('COMMENT ON COLUMN tm_assessment.uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN tm_assessment.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE tm_config (id BIGINT NOT NULL, key VARCHAR(120) NOT NULL, value VARCHAR(240) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B07D249C8A90ABA9 ON tm_config (key)');
        $this->addSql('COMMENT ON COLUMN tm_config.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE tm_question (id BIGINT NOT NULL, test_id BIGINT DEFAULT NULL, description TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_tm_question_test_id ON tm_question (test_id)');
        $this->addSql('COMMENT ON COLUMN tm_question.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE tm_answer ADD CONSTRAINT FK_BE2A41C51E27F6BF FOREIGN KEY (question_id) REFERENCES tm_question (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tm_question ADD CONSTRAINT FK_7F5B07DD1E5D0459 FOREIGN KEY (test_id) REFERENCES tm_assessment (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE tm_answer_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE tm_assessment_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE tm_config_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE tm_question_id_seq CASCADE');
        $this->addSql('ALTER TABLE tm_answer DROP CONSTRAINT FK_BE2A41C51E27F6BF');
        $this->addSql('ALTER TABLE tm_question DROP CONSTRAINT FK_7F5B07DD1E5D0459');
        $this->addSql('DROP TABLE tm_answer');
        $this->addSql('DROP TABLE tm_assessment');
        $this->addSql('DROP TABLE tm_config');
        $this->addSql('DROP TABLE tm_question');
    }
}
