<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240505144138 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE agentsdrh (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, numero_telephone INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE competences (id INT AUTO_INCREMENT NOT NULL, competence VARCHAR(255) NOT NULL, niveau_competence INT NOT NULL, prix_estime DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE competences_employes (competences_id INT NOT NULL, employes_id INT NOT NULL, INDEX IDX_E65F10B3A660B158 (competences_id), INDEX IDX_E65F10B3F971F91F (employes_id), PRIMARY KEY(competences_id, employes_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contrats (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, agent_drh_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, date_soumission DATE DEFAULT NULL, date_reponse DATE DEFAULT NULL, etat_contrat VARCHAR(255) NOT NULL, prix DOUBLE PRECISION DEFAULT NULL, prix_final DOUBLE PRECISION DEFAULT NULL, INDEX IDX_7268396C19EB6921 (client_id), INDEX IDX_7268396C98C0CBA8 (agent_drh_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employes (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, date_inscription DATE NOT NULL, adresse VARCHAR(255) NOT NULL, numero_telephone INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employes_prestations (employes_id INT NOT NULL, prestations_id INT NOT NULL, INDEX IDX_26FC60ABF971F91F (employes_id), INDEX IDX_26FC60AB8BE96D0D (prestations_id), PRIMARY KEY(employes_id, prestations_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notifications (id INT AUTO_INCREMENT NOT NULL, contrat_id INT NOT NULL, message VARCHAR(255) NOT NULL, date_envoi DATETIME NOT NULL, UNIQUE INDEX UNIQ_6000B0D31823061F (contrat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prestations (id INT AUTO_INCREMENT NOT NULL, competence_id INT DEFAULT NULL, contrat_id INT DEFAULT NULL, date_debut DATE DEFAULT NULL, date_fin DATE DEFAULT NULL, date_deb_finale DATE DEFAULT NULL, date_fin_finale DATE DEFAULT NULL, duree INT NOT NULL, prix DOUBLE PRECISION DEFAULT NULL, prix_final DOUBLE PRECISION DEFAULT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_B338D8D115761DAB (competence_id), INDEX IDX_B338D8D11823061F (contrat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE competences_employes ADD CONSTRAINT FK_E65F10B3A660B158 FOREIGN KEY (competences_id) REFERENCES competences (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE competences_employes ADD CONSTRAINT FK_E65F10B3F971F91F FOREIGN KEY (employes_id) REFERENCES employes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contrats ADD CONSTRAINT FK_7268396C19EB6921 FOREIGN KEY (client_id) REFERENCES clients (id)');
        $this->addSql('ALTER TABLE contrats ADD CONSTRAINT FK_7268396C98C0CBA8 FOREIGN KEY (agent_drh_id) REFERENCES agentsdrh (id)');
        $this->addSql('ALTER TABLE employes_prestations ADD CONSTRAINT FK_26FC60ABF971F91F FOREIGN KEY (employes_id) REFERENCES employes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE employes_prestations ADD CONSTRAINT FK_26FC60AB8BE96D0D FOREIGN KEY (prestations_id) REFERENCES prestations (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE notifications ADD CONSTRAINT FK_6000B0D31823061F FOREIGN KEY (contrat_id) REFERENCES contrats (id)');
        $this->addSql('ALTER TABLE prestations ADD CONSTRAINT FK_B338D8D115761DAB FOREIGN KEY (competence_id) REFERENCES competences (id)');
        $this->addSql('ALTER TABLE prestations ADD CONSTRAINT FK_B338D8D11823061F FOREIGN KEY (contrat_id) REFERENCES contrats (id)');
        $this->addSql('ALTER TABLE clients CHANGE roles roles JSON NOT NULL');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE competences_employes DROP FOREIGN KEY FK_E65F10B3A660B158');
        $this->addSql('ALTER TABLE competences_employes DROP FOREIGN KEY FK_E65F10B3F971F91F');
        $this->addSql('ALTER TABLE contrats DROP FOREIGN KEY FK_7268396C19EB6921');
        $this->addSql('ALTER TABLE contrats DROP FOREIGN KEY FK_7268396C98C0CBA8');
        $this->addSql('ALTER TABLE employes_prestations DROP FOREIGN KEY FK_26FC60ABF971F91F');
        $this->addSql('ALTER TABLE employes_prestations DROP FOREIGN KEY FK_26FC60AB8BE96D0D');
        $this->addSql('ALTER TABLE notifications DROP FOREIGN KEY FK_6000B0D31823061F');
        $this->addSql('ALTER TABLE prestations DROP FOREIGN KEY FK_B338D8D115761DAB');
        $this->addSql('ALTER TABLE prestations DROP FOREIGN KEY FK_B338D8D11823061F');
        $this->addSql('DROP TABLE agentsdrh');
        $this->addSql('DROP TABLE competences');
        $this->addSql('DROP TABLE competences_employes');
        $this->addSql('DROP TABLE contrats');
        $this->addSql('DROP TABLE employes');
        $this->addSql('DROP TABLE employes_prestations');
        $this->addSql('DROP TABLE notifications');
        $this->addSql('DROP TABLE prestations');
        $this->addSql('ALTER TABLE clients CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_bin`');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT \'NULL\'');
    }
}
