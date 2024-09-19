<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240919185331 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE server_statistic (id INT NOT NULL, server_id INT DEFAULT NULL, players INT DEFAULT 0 NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_A68E1CBA1844E6B7 ON server_statistic (server_id)');
        $this->addSql('COMMENT ON COLUMN server_statistic.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE server_statistic ADD CONSTRAINT FK_A68E1CBA1844E6B7 FOREIGN KEY (server_id) REFERENCES server (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE server_statistic DROP CONSTRAINT FK_A68E1CBA1844E6B7');
        $this->addSql('DROP TABLE server_statistic');
    }
}
