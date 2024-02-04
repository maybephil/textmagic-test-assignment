<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240204164850 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE tm_result_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE tm_result (id BIGINT NOT NULL, assessment_id BIGINT DEFAULT NULL, is_successful BOOLEAN NOT NULL, uuid UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_779DCAF3D17F50A6 ON tm_result (uuid)');
        $this->addSql('CREATE INDEX IDX_779DCAF3DD3DD5F1 ON tm_result (assessment_id)');
        $this->addSql('COMMENT ON COLUMN tm_result.uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN tm_result.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE tm_answer_to_result (result_id BIGINT NOT NULL, answer_id BIGINT NOT NULL, PRIMARY KEY(result_id, answer_id))');
        $this->addSql('CREATE INDEX IDX_37A7F4517A7B643 ON tm_answer_to_result (result_id)');
        $this->addSql('CREATE INDEX IDX_37A7F451AA334807 ON tm_answer_to_result (answer_id)');
        $this->addSql('ALTER TABLE tm_result ADD CONSTRAINT FK_779DCAF3DD3DD5F1 FOREIGN KEY (assessment_id) REFERENCES tm_assessment (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tm_answer_to_result ADD CONSTRAINT FK_37A7F4517A7B643 FOREIGN KEY (result_id) REFERENCES tm_result (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tm_answer_to_result ADD CONSTRAINT FK_37A7F451AA334807 FOREIGN KEY (answer_id) REFERENCES tm_answer (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE tm_result_id_seq CASCADE');
        $this->addSql('ALTER TABLE tm_result DROP CONSTRAINT FK_779DCAF3DD3DD5F1');
        $this->addSql('ALTER TABLE tm_answer_to_result DROP CONSTRAINT FK_37A7F4517A7B643');
        $this->addSql('ALTER TABLE tm_answer_to_result DROP CONSTRAINT FK_37A7F451AA334807');
        $this->addSql('DROP TABLE tm_result');
        $this->addSql('DROP TABLE tm_answer_to_result');
    }
}
