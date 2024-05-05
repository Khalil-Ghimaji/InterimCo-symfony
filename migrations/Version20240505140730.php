<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240505140730 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contrats DROP FOREIGN KEY FK_7268396CBB01BEDA');
        $this->addSql('DROP INDEX IDX_7268396CBB01BEDA ON contrats');
        $this->addSql('ALTER TABLE contrats CHANGE id_agent_drh_id agent_drh_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE contrats ADD CONSTRAINT FK_7268396C98C0CBA8 FOREIGN KEY (agent_drh_id) REFERENCES agentsdrh (id)');
        $this->addSql('CREATE INDEX IDX_7268396C98C0CBA8 ON contrats (agent_drh_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contrats DROP FOREIGN KEY FK_7268396C98C0CBA8');
        $this->addSql('DROP INDEX IDX_7268396C98C0CBA8 ON contrats');
        $this->addSql('ALTER TABLE contrats CHANGE agent_drh_id id_agent_drh_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE contrats ADD CONSTRAINT FK_7268396CBB01BEDA FOREIGN KEY (id_agent_drh_id) REFERENCES agentsdrh (id)');
        $this->addSql('CREATE INDEX IDX_7268396CBB01BEDA ON contrats (id_agent_drh_id)');
    }
}
