<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240506212120 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contrats DROP CONSTRAINT fk_7268396c99ded506');
        $this->addSql('DROP INDEX idx_7268396c99ded506');
        $this->addSql('ALTER TABLE contrats RENAME COLUMN id_client_id TO client_id');
        $this->addSql('ALTER TABLE contrats ADD CONSTRAINT FK_7268396C19EB6921 FOREIGN KEY (client_id) REFERENCES clients (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_7268396C19EB6921 ON contrats (client_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE contrats DROP CONSTRAINT FK_7268396C19EB6921');
        $this->addSql('DROP INDEX IDX_7268396C19EB6921');
        $this->addSql('ALTER TABLE contrats RENAME COLUMN client_id TO id_client_id');
        $this->addSql('ALTER TABLE contrats ADD CONSTRAINT fk_7268396c99ded506 FOREIGN KEY (id_client_id) REFERENCES clients (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_7268396c99ded506 ON contrats (id_client_id)');
    }
}
