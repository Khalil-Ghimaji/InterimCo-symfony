<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240509144612 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE competenceemploye DROP FOREIGN KEY FK_48D4512615761DAB');
        $this->addSql('ALTER TABLE competenceemploye DROP FOREIGN KEY FK_48D451261B65292');
        $this->addSql('ALTER TABLE employeprestation DROP FOREIGN KEY FK_DD7A28E61B65292');
        $this->addSql('ALTER TABLE employeprestation DROP FOREIGN KEY FK_DD7A28E69E45C554');
        $this->addSql('DROP TABLE competenceemploye');
        $this->addSql('DROP TABLE employeprestation');
        $this->addSql('ALTER TABLE contrats DROP prix_final');
        $this->addSql('ALTER TABLE prestations DROP date_fin_finale, DROP date_deb_finale, DROP prix_final');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE competenceemploye (id INT AUTO_INCREMENT NOT NULL, employe_id INT DEFAULT NULL, competence_id INT DEFAULT NULL, INDEX IDX_48D451261B65292 (employe_id), INDEX IDX_48D4512615761DAB (competence_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE employeprestation (id INT AUTO_INCREMENT NOT NULL, employe_id INT DEFAULT NULL, prestation_id INT DEFAULT NULL, INDEX IDX_DD7A28E61B65292 (employe_id), INDEX IDX_DD7A28E69E45C554 (prestation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE competenceemploye ADD CONSTRAINT FK_48D4512615761DAB FOREIGN KEY (competence_id) REFERENCES competences (id)');
        $this->addSql('ALTER TABLE competenceemploye ADD CONSTRAINT FK_48D451261B65292 FOREIGN KEY (employe_id) REFERENCES employes (id)');
        $this->addSql('ALTER TABLE employeprestation ADD CONSTRAINT FK_DD7A28E61B65292 FOREIGN KEY (employe_id) REFERENCES employes (id)');
        $this->addSql('ALTER TABLE employeprestation ADD CONSTRAINT FK_DD7A28E69E45C554 FOREIGN KEY (prestation_id) REFERENCES prestations (id)');
        $this->addSql('ALTER TABLE contrats ADD prix_final DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE prestations ADD date_fin_finale DATE DEFAULT NULL, ADD date_deb_finale DATE NOT NULL, ADD prix_final DOUBLE PRECISION DEFAULT NULL');
    }
}
