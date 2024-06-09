<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240609192408 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE server ADD name VARCHAR(64) NOT NULL');
        $this->addSql('ALTER TABLE server ADD ip VARCHAR(32) DEFAULT NULL');
        $this->addSql('ALTER TABLE server ADD version VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE server ADD max_players INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE server ADD current_players INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE server ADD online BOOLEAN DEFAULT false NOT NULL');
        $this->addSql('ALTER TABLE server ADD motd_first_line VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE server ADD motd_second_line VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE server ADD icon VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE server ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE server ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE server DROP name');
        $this->addSql('ALTER TABLE server DROP ip');
        $this->addSql('ALTER TABLE server DROP version');
        $this->addSql('ALTER TABLE server DROP max_players');
        $this->addSql('ALTER TABLE server DROP current_players');
        $this->addSql('ALTER TABLE server DROP online');
        $this->addSql('ALTER TABLE server DROP motd_first_line');
        $this->addSql('ALTER TABLE server DROP motd_second_line');
        $this->addSql('ALTER TABLE server DROP icon');
        $this->addSql('ALTER TABLE server DROP created_at');
        $this->addSql('ALTER TABLE server DROP updated_at');
    }
}
