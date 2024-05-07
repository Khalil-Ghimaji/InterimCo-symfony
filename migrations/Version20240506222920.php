<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240506222920 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin ADD roles JSON NOT NULL');
        $this->addSql('ALTER TABLE admin ADD password VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE admin DROP mot_de_passe');
        $this->addSql('ALTER TABLE admin ALTER login TYPE VARCHAR(180)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_LOGIN ON admin (login)');
        $this->addSql('ALTER TABLE contrats ALTER date_soumission DROP NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE contrats ALTER date_soumission SET NOT NULL');
        $this->addSql('DROP INDEX UNIQ_IDENTIFIER_LOGIN');
        $this->addSql('ALTER TABLE admin ADD mot_de_passe VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE admin DROP roles');
        $this->addSql('ALTER TABLE admin DROP password');
        $this->addSql('ALTER TABLE admin ALTER login TYPE VARCHAR(20)');
    }
}
