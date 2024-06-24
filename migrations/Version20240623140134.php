<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240623140134 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE _prisma_migrations');
        $this->addSql('DROP INDEX "Server_name_key"');
        $this->addSql('ALTER TABLE Server ADD max_players INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE Server ADD current_players INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE Server ADD motd_first_line VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE Server ADD motd_second_line VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE Server ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE Server DROP "maxPlayers"');
        $this->addSql('ALTER TABLE Server DROP "currentPlayers"');
        $this->addSql('ALTER TABLE Server DROP "updatedAt"');
        $this->addSql('ALTER TABLE Server DROP "motdFirstLine"');
        $this->addSql('ALTER TABLE Server DROP "motdSecondLine"');
        $this->addSql('ALTER TABLE Server ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE Server ALTER name TYPE VARCHAR(64)');
        $this->addSql('ALTER TABLE Server ALTER ip TYPE VARCHAR(32)');
        $this->addSql('ALTER TABLE Server ALTER version TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE Server ALTER online SET DEFAULT false');
        $this->addSql('ALTER TABLE Server RENAME COLUMN createdAt TO updated_at');
        $this->addSql('COMMENT ON COLUMN Server.created_at IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE _prisma_migrations (id VARCHAR(36) NOT NULL, checksum VARCHAR(64) NOT NULL, finished_at TIMESTAMP(0) WITH TIME ZONE DEFAULT NULL, migration_name VARCHAR(255) NOT NULL, logs TEXT DEFAULT NULL, rolled_back_at TIMESTAMP(0) WITH TIME ZONE DEFAULT NULL, started_at TIMESTAMP(0) WITH TIME ZONE DEFAULT \'now()\' NOT NULL, applied_steps_count INT DEFAULT 0 NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE server ADD "maxPlayers" INT NOT NULL');
        $this->addSql('ALTER TABLE server ADD "currentPlayers" INT NOT NULL');
        $this->addSql('ALTER TABLE server ADD "updatedAt" TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE server ADD "motdFirstLine" TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE server ADD "motdSecondLine" TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE server DROP max_players');
        $this->addSql('ALTER TABLE server DROP current_players');
        $this->addSql('ALTER TABLE server DROP motd_first_line');
        $this->addSql('ALTER TABLE server DROP motd_second_line');
        $this->addSql('ALTER TABLE server DROP created_at');
        $this->addSql('CREATE SEQUENCE server_id_seq');
        $this->addSql('SELECT setval(\'server_id_seq\', (SELECT MAX(id) FROM server))');
        $this->addSql('ALTER TABLE server ALTER id SET DEFAULT nextval(\'server_id_seq\')');
        $this->addSql('ALTER TABLE server ALTER name TYPE TEXT');
        $this->addSql('ALTER TABLE server ALTER name TYPE TEXT');
        $this->addSql('ALTER TABLE server ALTER ip TYPE TEXT');
        $this->addSql('ALTER TABLE server ALTER ip TYPE TEXT');
        $this->addSql('ALTER TABLE server ALTER version TYPE TEXT');
        $this->addSql('ALTER TABLE server ALTER online DROP DEFAULT');
        $this->addSql('ALTER TABLE server RENAME COLUMN updated_at TO "createdAt"');
        $this->addSql('CREATE UNIQUE INDEX "Server_name_key" ON server (name)');
    }
}
