<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240504212354 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE competenceemploye (id INT AUTO_INCREMENT NOT NULL, id_employe_id INT DEFAULT NULL, id_competence_id INT DEFAULT NULL, INDEX IDX_48D45126A43CD245 (id_employe_id), INDEX IDX_48D45126AB5ECCCE (id_competence_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contrats (id INT AUTO_INCREMENT NOT NULL, id_client_id INT DEFAULT NULL, id_agent_drh_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, date_soumission DATE DEFAULT NULL, date_reponse DATE DEFAULT NULL, etat_contrat VARCHAR(255) DEFAULT NULL, prix DOUBLE PRECISION DEFAULT NULL, prix_final DOUBLE PRECISION DEFAULT NULL, INDEX IDX_7268396C99DED506 (id_client_id), INDEX IDX_7268396CBB01BEDA (id_agent_drh_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employeprestation (id INT AUTO_INCREMENT NOT NULL, id_employe_id INT DEFAULT NULL, id_prestation_id INT DEFAULT NULL, INDEX IDX_DD7A28E6A43CD245 (id_employe_id), INDEX IDX_DD7A28E6206D1431 (id_prestation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notifications (id INT AUTO_INCREMENT NOT NULL, id_contrat_id INT DEFAULT NULL, INDEX IDX_6000B0D3BDA986C8 (id_contrat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prestations (id INT AUTO_INCREMENT NOT NULL, id_contrat_id INT DEFAULT NULL, date_debut DATE DEFAULT NULL, date_fin DATE DEFAULT NULL, date_fin_finale DATE DEFAULT NULL, date_deb_finale DATE NOT NULL, duree INT DEFAULT NULL, prix DOUBLE PRECISION DEFAULT NULL, prix_final DOUBLE PRECISION DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, INDEX IDX_B338D8D1BDA986C8 (id_contrat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE competenceemploye ADD CONSTRAINT FK_48D45126A43CD245 FOREIGN KEY (id_employe_id) REFERENCES employes (id)');
        $this->addSql('ALTER TABLE competenceemploye ADD CONSTRAINT FK_48D45126AB5ECCCE FOREIGN KEY (id_competence_id) REFERENCES competences (id)');
        $this->addSql('ALTER TABLE contrats ADD CONSTRAINT FK_7268396C99DED506 FOREIGN KEY (id_client_id) REFERENCES clients (id)');
        $this->addSql('ALTER TABLE contrats ADD CONSTRAINT FK_7268396CBB01BEDA FOREIGN KEY (id_agent_drh_id) REFERENCES agentsdrh (id)');
        $this->addSql('ALTER TABLE employeprestation ADD CONSTRAINT FK_DD7A28E6A43CD245 FOREIGN KEY (id_employe_id) REFERENCES employes (id)');
        $this->addSql('ALTER TABLE employeprestation ADD CONSTRAINT FK_DD7A28E6206D1431 FOREIGN KEY (id_prestation_id) REFERENCES prestations (id)');
        $this->addSql('ALTER TABLE notifications ADD CONSTRAINT FK_6000B0D3BDA986C8 FOREIGN KEY (id_contrat_id) REFERENCES contrats (id)');
        $this->addSql('ALTER TABLE prestations ADD CONSTRAINT FK_B338D8D1BDA986C8 FOREIGN KEY (id_contrat_id) REFERENCES contrats (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE competenceemploye DROP FOREIGN KEY FK_48D45126A43CD245');
        $this->addSql('ALTER TABLE competenceemploye DROP FOREIGN KEY FK_48D45126AB5ECCCE');
        $this->addSql('ALTER TABLE contrats DROP FOREIGN KEY FK_7268396C99DED506');
        $this->addSql('ALTER TABLE contrats DROP FOREIGN KEY FK_7268396CBB01BEDA');
        $this->addSql('ALTER TABLE employeprestation DROP FOREIGN KEY FK_DD7A28E6A43CD245');
        $this->addSql('ALTER TABLE employeprestation DROP FOREIGN KEY FK_DD7A28E6206D1431');
        $this->addSql('ALTER TABLE notifications DROP FOREIGN KEY FK_6000B0D3BDA986C8');
        $this->addSql('ALTER TABLE prestations DROP FOREIGN KEY FK_B338D8D1BDA986C8');
        $this->addSql('DROP TABLE competenceemploye');
        $this->addSql('DROP TABLE contrats');
        $this->addSql('DROP TABLE employeprestation');
        $this->addSql('DROP TABLE notifications');
        $this->addSql('DROP TABLE prestations');
    }
}
