<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240505155843 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE prestations_employes (prestations_id INT NOT NULL, employes_id INT NOT NULL, INDEX IDX_56DD37AD8BE96D0D (prestations_id), INDEX IDX_56DD37ADF971F91F (employes_id), PRIMARY KEY(prestations_id, employes_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE prestations_employes ADD CONSTRAINT FK_56DD37AD8BE96D0D FOREIGN KEY (prestations_id) REFERENCES prestations (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE prestations_employes ADD CONSTRAINT FK_56DD37ADF971F91F FOREIGN KEY (employes_id) REFERENCES employes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE prestations DROP FOREIGN KEY FK_B338D8D11B65292');
        $this->addSql('DROP INDEX UNIQ_B338D8D11B65292 ON prestations');
        $this->addSql('ALTER TABLE prestations DROP employe_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE prestations_employes DROP FOREIGN KEY FK_56DD37AD8BE96D0D');
        $this->addSql('ALTER TABLE prestations_employes DROP FOREIGN KEY FK_56DD37ADF971F91F');
        $this->addSql('DROP TABLE prestations_employes');
        $this->addSql('ALTER TABLE prestations ADD employe_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE prestations ADD CONSTRAINT FK_B338D8D11B65292 FOREIGN KEY (employe_id) REFERENCES employes (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B338D8D11B65292 ON prestations (employe_id)');
    }
}
