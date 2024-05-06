<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240506212014 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE prestations DROP CONSTRAINT fk_b338d8d1ab5eccce');
        $this->addSql('DROP INDEX idx_b338d8d1ab5eccce');
        $this->addSql('ALTER TABLE prestations RENAME COLUMN id_competence_id TO competence_id');
        $this->addSql('ALTER TABLE prestations ADD CONSTRAINT FK_B338D8D115761DAB FOREIGN KEY (competence_id) REFERENCES competences (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_B338D8D115761DAB ON prestations (competence_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE prestations DROP CONSTRAINT FK_B338D8D115761DAB');
        $this->addSql('DROP INDEX IDX_B338D8D115761DAB');
        $this->addSql('ALTER TABLE prestations RENAME COLUMN competence_id TO id_competence_id');
        $this->addSql('ALTER TABLE prestations ADD CONSTRAINT fk_b338d8d1ab5eccce FOREIGN KEY (id_competence_id) REFERENCES competences (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_b338d8d1ab5eccce ON prestations (id_competence_id)');
    }
}
