<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240505134956 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE notifications DROP FOREIGN KEY FK_6000B0D3BDA986C8');
        $this->addSql('DROP INDEX IDX_6000B0D3BDA986C8 ON notifications');
        $this->addSql('ALTER TABLE notifications CHANGE id_contrat_id contrat_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE notifications ADD CONSTRAINT FK_6000B0D31823061F FOREIGN KEY (contrat_id) REFERENCES contrats (id)');
        $this->addSql('CREATE INDEX IDX_6000B0D31823061F ON notifications (contrat_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE notifications DROP FOREIGN KEY FK_6000B0D31823061F');
        $this->addSql('DROP INDEX IDX_6000B0D31823061F ON notifications');
        $this->addSql('ALTER TABLE notifications CHANGE contrat_id id_contrat_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE notifications ADD CONSTRAINT FK_6000B0D3BDA986C8 FOREIGN KEY (id_contrat_id) REFERENCES contrats (id)');
        $this->addSql('CREATE INDEX IDX_6000B0D3BDA986C8 ON notifications (id_contrat_id)');
    }
}
