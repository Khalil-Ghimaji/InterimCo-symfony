<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240507223133 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE admin_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE agents_drh_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE clients_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE competence_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE competences_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE contrats_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE employes_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE notifications_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE prestations_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE admin (id INT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME ON admin (username)');
        $this->addSql('CREATE TABLE agents_drh (id INT NOT NULL, login VARCHAR(180) NOT NULL, password VARCHAR(180) NOT NULL, email VARCHAR(50) NOT NULL, numero_telephone INT DEFAULT NULL, nom VARCHAR(30) NOT NULL, prenom VARCHAR(30) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE clients (id INT NOT NULL, login VARCHAR(180) NOT NULL, password VARCHAR(180) NOT NULL, email VARCHAR(50) NOT NULL, nom VARCHAR(30) NOT NULL, locale VARCHAR(50) NOT NULL, numero_telephone INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE competence (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE competence_employes (competence_id INT NOT NULL, employes_id INT NOT NULL, PRIMARY KEY(competence_id, employes_id))');
        $this->addSql('CREATE INDEX IDX_72E4419915761DAB ON competence_employes (competence_id)');
        $this->addSql('CREATE INDEX IDX_72E44199F971F91F ON competence_employes (employes_id)');
        $this->addSql('CREATE TABLE competences (id INT NOT NULL, competence VARCHAR(30) NOT NULL, niveau_competence SMALLINT NOT NULL, prix_estime DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE contrats (id INT NOT NULL, client_id INT NOT NULL, agent_drh_id INT DEFAULT NULL, libelle VARCHAR(30) NOT NULL, date_soumission DATE DEFAULT NULL, date_reponse DATE DEFAULT NULL, etat_contrat VARCHAR(30) NOT NULL, prix DOUBLE PRECISION NOT NULL, prix_final DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7268396C19EB6921 ON contrats (client_id)');
        $this->addSql('CREATE INDEX IDX_7268396C98C0CBA8 ON contrats (agent_drh_id)');
        $this->addSql('CREATE TABLE employes (id INT NOT NULL, nom VARCHAR(30) NOT NULL, prenom VARCHAR(30) NOT NULL, email VARCHAR(50) NOT NULL, date_inscription DATE NOT NULL, adresse VARCHAR(50) NOT NULL, numero_telephone INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE notifications (id INT NOT NULL, contrat_id INT NOT NULL, message VARCHAR(255) NOT NULL, date_envoi TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6000B0D31823061F ON notifications (contrat_id)');
        $this->addSql('CREATE TABLE prestations (id INT NOT NULL, contrat_id INT NOT NULL, competence_id INT NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, date_fin_finale DATE DEFAULT NULL, date_deb_finale DATE DEFAULT NULL, duree INT NOT NULL, prix DOUBLE PRECISION NOT NULL, prix_final DOUBLE PRECISION DEFAULT NULL, description VARCHAR(30) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B338D8D11823061F ON prestations (contrat_id)');
        $this->addSql('CREATE INDEX IDX_B338D8D115761DAB ON prestations (competence_id)');
        $this->addSql('CREATE TABLE prestations_employes (prestations_id INT NOT NULL, employes_id INT NOT NULL, PRIMARY KEY(prestations_id, employes_id))');
        $this->addSql('CREATE INDEX IDX_56DD37AD8BE96D0D ON prestations_employes (prestations_id)');
        $this->addSql('CREATE INDEX IDX_56DD37ADF971F91F ON prestations_employes (employes_id)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE competence_employes ADD CONSTRAINT FK_72E4419915761DAB FOREIGN KEY (competence_id) REFERENCES competence (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE competence_employes ADD CONSTRAINT FK_72E44199F971F91F FOREIGN KEY (employes_id) REFERENCES employes (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contrats ADD CONSTRAINT FK_7268396C19EB6921 FOREIGN KEY (client_id) REFERENCES clients (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contrats ADD CONSTRAINT FK_7268396C98C0CBA8 FOREIGN KEY (agent_drh_id) REFERENCES agents_drh (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE notifications ADD CONSTRAINT FK_6000B0D31823061F FOREIGN KEY (contrat_id) REFERENCES contrats (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE prestations ADD CONSTRAINT FK_B338D8D11823061F FOREIGN KEY (contrat_id) REFERENCES contrats (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE prestations ADD CONSTRAINT FK_B338D8D115761DAB FOREIGN KEY (competence_id) REFERENCES contrats (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE prestations_employes ADD CONSTRAINT FK_56DD37AD8BE96D0D FOREIGN KEY (prestations_id) REFERENCES prestations (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE prestations_employes ADD CONSTRAINT FK_56DD37ADF971F91F FOREIGN KEY (employes_id) REFERENCES employes (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE admin_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE agents_drh_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE clients_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE competence_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE competences_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE contrats_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE employes_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE notifications_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE prestations_id_seq CASCADE');
        $this->addSql('ALTER TABLE competence_employes DROP CONSTRAINT FK_72E4419915761DAB');
        $this->addSql('ALTER TABLE competence_employes DROP CONSTRAINT FK_72E44199F971F91F');
        $this->addSql('ALTER TABLE contrats DROP CONSTRAINT FK_7268396C19EB6921');
        $this->addSql('ALTER TABLE contrats DROP CONSTRAINT FK_7268396C98C0CBA8');
        $this->addSql('ALTER TABLE notifications DROP CONSTRAINT FK_6000B0D31823061F');
        $this->addSql('ALTER TABLE prestations DROP CONSTRAINT FK_B338D8D11823061F');
        $this->addSql('ALTER TABLE prestations DROP CONSTRAINT FK_B338D8D115761DAB');
        $this->addSql('ALTER TABLE prestations_employes DROP CONSTRAINT FK_56DD37AD8BE96D0D');
        $this->addSql('ALTER TABLE prestations_employes DROP CONSTRAINT FK_56DD37ADF971F91F');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE agents_drh');
        $this->addSql('DROP TABLE clients');
        $this->addSql('DROP TABLE competence');
        $this->addSql('DROP TABLE competence_employes');
        $this->addSql('DROP TABLE competences');
        $this->addSql('DROP TABLE contrats');
        $this->addSql('DROP TABLE employes');
        $this->addSql('DROP TABLE notifications');
        $this->addSql('DROP TABLE prestations');
        $this->addSql('DROP TABLE prestations_employes');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
