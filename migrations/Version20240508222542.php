<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240508222542 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE competence_id_seq CASCADE');
        $this->addSql('CREATE TABLE competences_employes (competences_id INT NOT NULL, employes_id INT NOT NULL, PRIMARY KEY(competences_id, employes_id))');
        $this->addSql('CREATE INDEX IDX_E65F10B3A660B158 ON competences_employes (competences_id)');
        $this->addSql('CREATE INDEX IDX_E65F10B3F971F91F ON competences_employes (employes_id)');
        $this->addSql('ALTER TABLE competences_employes ADD CONSTRAINT FK_E65F10B3A660B158 FOREIGN KEY (competences_id) REFERENCES competences (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE competences_employes ADD CONSTRAINT FK_E65F10B3F971F91F FOREIGN KEY (employes_id) REFERENCES employes (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE competence_employes DROP CONSTRAINT fk_72e4419915761dab');
        $this->addSql('ALTER TABLE competence_employes DROP CONSTRAINT fk_72e44199f971f91f');
        $this->addSql('DROP TABLE competence_employes');
        $this->addSql('DROP TABLE competence');
        $this->addSql('ALTER TABLE agents_drh RENAME COLUMN login TO username');
        $this->addSql('ALTER TABLE clients RENAME COLUMN login TO username');
        $this->addSql('ALTER TABLE prestations DROP CONSTRAINT FK_B338D8D115761DAB');
        $this->addSql('ALTER TABLE prestations ADD CONSTRAINT FK_B338D8D115761DAB FOREIGN KEY (competence_id) REFERENCES competences (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE competence_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE competence_employes (competence_id INT NOT NULL, employes_id INT NOT NULL, PRIMARY KEY(competence_id, employes_id))');
        $this->addSql('CREATE INDEX idx_72e44199f971f91f ON competence_employes (employes_id)');
        $this->addSql('CREATE INDEX idx_72e4419915761dab ON competence_employes (competence_id)');
        $this->addSql('CREATE TABLE competence (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE competence_employes ADD CONSTRAINT fk_72e4419915761dab FOREIGN KEY (competence_id) REFERENCES competence (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE competence_employes ADD CONSTRAINT fk_72e44199f971f91f FOREIGN KEY (employes_id) REFERENCES employes (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE competences_employes DROP CONSTRAINT FK_E65F10B3A660B158');
        $this->addSql('ALTER TABLE competences_employes DROP CONSTRAINT FK_E65F10B3F971F91F');
        $this->addSql('DROP TABLE competences_employes');
        $this->addSql('ALTER TABLE clients RENAME COLUMN username TO login');
        $this->addSql('ALTER TABLE prestations DROP CONSTRAINT fk_b338d8d115761dab');
        $this->addSql('ALTER TABLE prestations ADD CONSTRAINT fk_b338d8d115761dab FOREIGN KEY (competence_id) REFERENCES contrats (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE agents_drh RENAME COLUMN username TO login');
    }
}
