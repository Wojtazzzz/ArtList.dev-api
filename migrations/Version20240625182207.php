<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240625182207 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE server_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE server (id INT NOT NULL, name VARCHAR(64) NOT NULL, ip VARCHAR(32) DEFAULT NULL, version VARCHAR(255) DEFAULT NULL, max_players INT DEFAULT 0 NOT NULL, current_players INT DEFAULT 0 NOT NULL, online BOOLEAN DEFAULT false NOT NULL, motd_first_line VARCHAR(255) DEFAULT NULL, motd_second_line VARCHAR(255) DEFAULT NULL, icon TEXT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN server.created_at IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE server_id_seq CASCADE');
        $this->addSql('DROP TABLE server');
    }
}
