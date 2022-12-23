<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221222174628 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sonata_page_snapshot (id INT AUTO_INCREMENT NOT NULL, site_id INT DEFAULT NULL, page_id INT DEFAULT NULL, route_name VARCHAR(255) NOT NULL, page_alias VARCHAR(255) DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, position INT NOT NULL, enabled TINYINT(1) NOT NULL, decorate TINYINT(1) NOT NULL, name VARCHAR(255) NOT NULL, url LONGTEXT DEFAULT NULL, parent_id INT DEFAULT NULL, content JSON DEFAULT NULL, publication_date_start DATETIME DEFAULT NULL, publication_date_end DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, idx_snapshot_dates_enabled VARCHAR(255) NOT NULL, INDEX IDX_6FA38D70F6BD1646 (site_id), INDEX IDX_6FA38D70C4663E4 (page_id), INDEX idx_snapshot_dates_enabled (publication_date_start, publication_date_end, enabled), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sonata_page_snapshot ADD CONSTRAINT FK_6FA38D70F6BD1646 FOREIGN KEY (site_id) REFERENCES sonata_page_site (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sonata_page_snapshot ADD CONSTRAINT FK_6FA38D70C4663E4 FOREIGN KEY (page_id) REFERENCES sonata_page_page (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sonata_page_snapshot DROP FOREIGN KEY FK_6FA38D70F6BD1646');
        $this->addSql('ALTER TABLE sonata_page_snapshot DROP FOREIGN KEY FK_6FA38D70C4663E4');
        $this->addSql('DROP TABLE sonata_page_snapshot');
    }
}
