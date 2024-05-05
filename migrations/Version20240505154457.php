<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240505154457 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE prestations ADD employe_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE prestations ADD CONSTRAINT FK_B338D8D11B65292 FOREIGN KEY (employe_id) REFERENCES employes (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B338D8D11B65292 ON prestations (employe_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE prestations DROP FOREIGN KEY FK_B338D8D11B65292');
        $this->addSql('DROP INDEX UNIQ_B338D8D11B65292 ON prestations');
        $this->addSql('ALTER TABLE prestations DROP employe_id');
    }
}
