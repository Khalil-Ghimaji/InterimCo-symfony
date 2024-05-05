<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240505072604 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE prestations ADD id_competence_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE prestations ADD CONSTRAINT FK_B338D8D1AB5ECCCE FOREIGN KEY (id_competence_id) REFERENCES competences (id)');
        $this->addSql('CREATE INDEX IDX_B338D8D1AB5ECCCE ON prestations (id_competence_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE prestations DROP FOREIGN KEY FK_B338D8D1AB5ECCCE');
        $this->addSql('DROP INDEX IDX_B338D8D1AB5ECCCE ON prestations');
        $this->addSql('ALTER TABLE prestations DROP id_competence_id');
    }
}
