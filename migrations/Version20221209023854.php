<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221209023854 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sonata_user__user ADD created_at VARCHAR(255) NOT NULL, ADD updated_at VARCHAR(255) NOT NULL, ADD last_login VARCHAR(255) NOT NULL, ADD username VARCHAR(255) NOT NULL, ADD enabled TINYINT(1) NOT NULL, ADD password_requested_at VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sonata_user__user DROP created_at, DROP updated_at, DROP last_login, DROP username, DROP enabled, DROP password_requested_at');
    }
}
