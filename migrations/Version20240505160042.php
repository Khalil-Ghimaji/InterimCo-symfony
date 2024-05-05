<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240505160042 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE competences_employes (competences_id INT NOT NULL, employes_id INT NOT NULL, INDEX IDX_E65F10B3A660B158 (competences_id), INDEX IDX_E65F10B3F971F91F (employes_id), PRIMARY KEY(competences_id, employes_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE competences_employes ADD CONSTRAINT FK_E65F10B3A660B158 FOREIGN KEY (competences_id) REFERENCES competences (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE competences_employes ADD CONSTRAINT FK_E65F10B3F971F91F FOREIGN KEY (employes_id) REFERENCES employes (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE competences_employes DROP FOREIGN KEY FK_E65F10B3A660B158');
        $this->addSql('ALTER TABLE competences_employes DROP FOREIGN KEY FK_E65F10B3F971F91F');
        $this->addSql('DROP TABLE competences_employes');
    }
}
