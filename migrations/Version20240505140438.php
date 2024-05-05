<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240505140438 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE competenceemploye DROP FOREIGN KEY FK_48D45126AB5ECCCE');
        $this->addSql('ALTER TABLE competenceemploye DROP FOREIGN KEY FK_48D45126A43CD245');
        $this->addSql('DROP INDEX IDX_48D45126A43CD245 ON competenceemploye');
        $this->addSql('DROP INDEX IDX_48D45126AB5ECCCE ON competenceemploye');
        $this->addSql('ALTER TABLE competenceemploye ADD employe_id INT DEFAULT NULL, ADD competence_id INT DEFAULT NULL, DROP id_employe_id, DROP id_competence_id');
        $this->addSql('ALTER TABLE competenceemploye ADD CONSTRAINT FK_48D451261B65292 FOREIGN KEY (employe_id) REFERENCES employes (id)');
        $this->addSql('ALTER TABLE competenceemploye ADD CONSTRAINT FK_48D4512615761DAB FOREIGN KEY (competence_id) REFERENCES competences (id)');
        $this->addSql('CREATE INDEX IDX_48D451261B65292 ON competenceemploye (employe_id)');
        $this->addSql('CREATE INDEX IDX_48D4512615761DAB ON competenceemploye (competence_id)');
        $this->addSql('ALTER TABLE contrats DROP FOREIGN KEY FK_7268396C99DED506');
        $this->addSql('DROP INDEX IDX_7268396C99DED506 ON contrats');
        $this->addSql('ALTER TABLE contrats CHANGE id_client_id client_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE contrats ADD CONSTRAINT FK_7268396C19EB6921 FOREIGN KEY (client_id) REFERENCES clients (id)');
        $this->addSql('CREATE INDEX IDX_7268396C19EB6921 ON contrats (client_id)');
        $this->addSql('ALTER TABLE employeprestation DROP FOREIGN KEY FK_DD7A28E6206D1431');
        $this->addSql('ALTER TABLE employeprestation DROP FOREIGN KEY FK_DD7A28E6A43CD245');
        $this->addSql('DROP INDEX IDX_DD7A28E6A43CD245 ON employeprestation');
        $this->addSql('DROP INDEX IDX_DD7A28E6206D1431 ON employeprestation');
        $this->addSql('ALTER TABLE employeprestation ADD employe_id INT DEFAULT NULL, ADD prestation_id INT DEFAULT NULL, DROP id_employe_id, DROP id_prestation_id');
        $this->addSql('ALTER TABLE employeprestation ADD CONSTRAINT FK_DD7A28E61B65292 FOREIGN KEY (employe_id) REFERENCES employes (id)');
        $this->addSql('ALTER TABLE employeprestation ADD CONSTRAINT FK_DD7A28E69E45C554 FOREIGN KEY (prestation_id) REFERENCES prestations (id)');
        $this->addSql('CREATE INDEX IDX_DD7A28E61B65292 ON employeprestation (employe_id)');
        $this->addSql('CREATE INDEX IDX_DD7A28E69E45C554 ON employeprestation (prestation_id)');
        $this->addSql('ALTER TABLE prestations DROP FOREIGN KEY FK_B338D8D1AB5ECCCE');
        $this->addSql('ALTER TABLE prestations DROP FOREIGN KEY FK_B338D8D1BDA986C8');
        $this->addSql('DROP INDEX IDX_B338D8D1AB5ECCCE ON prestations');
        $this->addSql('DROP INDEX IDX_B338D8D1BDA986C8 ON prestations');
        $this->addSql('ALTER TABLE prestations ADD contrat_id INT DEFAULT NULL, ADD competence_id INT DEFAULT NULL, DROP id_contrat_id, DROP id_competence_id');
        $this->addSql('ALTER TABLE prestations ADD CONSTRAINT FK_B338D8D11823061F FOREIGN KEY (contrat_id) REFERENCES contrats (id)');
        $this->addSql('ALTER TABLE prestations ADD CONSTRAINT FK_B338D8D115761DAB FOREIGN KEY (competence_id) REFERENCES competences (id)');
        $this->addSql('CREATE INDEX IDX_B338D8D11823061F ON prestations (contrat_id)');
        $this->addSql('CREATE INDEX IDX_B338D8D115761DAB ON prestations (competence_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE competenceemploye DROP FOREIGN KEY FK_48D451261B65292');
        $this->addSql('ALTER TABLE competenceemploye DROP FOREIGN KEY FK_48D4512615761DAB');
        $this->addSql('DROP INDEX IDX_48D451261B65292 ON competenceemploye');
        $this->addSql('DROP INDEX IDX_48D4512615761DAB ON competenceemploye');
        $this->addSql('ALTER TABLE competenceemploye ADD id_employe_id INT DEFAULT NULL, ADD id_competence_id INT DEFAULT NULL, DROP employe_id, DROP competence_id');
        $this->addSql('ALTER TABLE competenceemploye ADD CONSTRAINT FK_48D45126AB5ECCCE FOREIGN KEY (id_competence_id) REFERENCES competences (id)');
        $this->addSql('ALTER TABLE competenceemploye ADD CONSTRAINT FK_48D45126A43CD245 FOREIGN KEY (id_employe_id) REFERENCES employes (id)');
        $this->addSql('CREATE INDEX IDX_48D45126A43CD245 ON competenceemploye (id_employe_id)');
        $this->addSql('CREATE INDEX IDX_48D45126AB5ECCCE ON competenceemploye (id_competence_id)');
        $this->addSql('ALTER TABLE contrats DROP FOREIGN KEY FK_7268396C19EB6921');
        $this->addSql('DROP INDEX IDX_7268396C19EB6921 ON contrats');
        $this->addSql('ALTER TABLE contrats CHANGE client_id id_client_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE contrats ADD CONSTRAINT FK_7268396C99DED506 FOREIGN KEY (id_client_id) REFERENCES clients (id)');
        $this->addSql('CREATE INDEX IDX_7268396C99DED506 ON contrats (id_client_id)');
        $this->addSql('ALTER TABLE employeprestation DROP FOREIGN KEY FK_DD7A28E61B65292');
        $this->addSql('ALTER TABLE employeprestation DROP FOREIGN KEY FK_DD7A28E69E45C554');
        $this->addSql('DROP INDEX IDX_DD7A28E61B65292 ON employeprestation');
        $this->addSql('DROP INDEX IDX_DD7A28E69E45C554 ON employeprestation');
        $this->addSql('ALTER TABLE employeprestation ADD id_employe_id INT DEFAULT NULL, ADD id_prestation_id INT DEFAULT NULL, DROP employe_id, DROP prestation_id');
        $this->addSql('ALTER TABLE employeprestation ADD CONSTRAINT FK_DD7A28E6206D1431 FOREIGN KEY (id_prestation_id) REFERENCES prestations (id)');
        $this->addSql('ALTER TABLE employeprestation ADD CONSTRAINT FK_DD7A28E6A43CD245 FOREIGN KEY (id_employe_id) REFERENCES employes (id)');
        $this->addSql('CREATE INDEX IDX_DD7A28E6A43CD245 ON employeprestation (id_employe_id)');
        $this->addSql('CREATE INDEX IDX_DD7A28E6206D1431 ON employeprestation (id_prestation_id)');
        $this->addSql('ALTER TABLE prestations DROP FOREIGN KEY FK_B338D8D11823061F');
        $this->addSql('ALTER TABLE prestations DROP FOREIGN KEY FK_B338D8D115761DAB');
        $this->addSql('DROP INDEX IDX_B338D8D11823061F ON prestations');
        $this->addSql('DROP INDEX IDX_B338D8D115761DAB ON prestations');
        $this->addSql('ALTER TABLE prestations ADD id_contrat_id INT DEFAULT NULL, ADD id_competence_id INT DEFAULT NULL, DROP contrat_id, DROP competence_id');
        $this->addSql('ALTER TABLE prestations ADD CONSTRAINT FK_B338D8D1AB5ECCCE FOREIGN KEY (id_competence_id) REFERENCES competences (id)');
        $this->addSql('ALTER TABLE prestations ADD CONSTRAINT FK_B338D8D1BDA986C8 FOREIGN KEY (id_contrat_id) REFERENCES contrats (id)');
        $this->addSql('CREATE INDEX IDX_B338D8D1AB5ECCCE ON prestations (id_competence_id)');
        $this->addSql('CREATE INDEX IDX_B338D8D1BDA986C8 ON prestations (id_contrat_id)');
    }
}
