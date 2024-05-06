<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240506211403 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE prestations ADD contrat_id INT NOT NULL');
        $this->addSql('ALTER TABLE prestations ADD CONSTRAINT FK_B338D8D11823061F FOREIGN KEY (contrat_id) REFERENCES contrats (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_B338D8D11823061F ON prestations (contrat_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE prestations DROP CONSTRAINT FK_B338D8D11823061F');
        $this->addSql('DROP INDEX IDX_B338D8D11823061F');
        $this->addSql('ALTER TABLE prestations DROP contrat_id');
    }
}
