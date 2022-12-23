<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221222103809 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE articles (id INT AUTO_INCREMENT NOT NULL, autheur_id INT DEFAULT NULL, titre VARCHAR(100) NOT NULL, baniere_url VARCHAR(255) DEFAULT NULL, content LONGTEXT NOT NULL, publie TINYINT(1) DEFAULT NULL, INDEX IDX_BFDD3168C6E59929 (autheur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE baniere (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(50) NOT NULL, image_url VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, articles_id INT DEFAULT NULL, titre VARCHAR(10) NOT NULL, couleur VARCHAR(10) DEFAULT NULL, INDEX IDX_3AF346681EBAF6CC (articles_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE log (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sonata_page_block (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, page_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, type VARCHAR(255) NOT NULL, settings JSON NOT NULL, enabled TINYINT(1) DEFAULT NULL, position INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_D319A22B727ACA70 (parent_id), INDEX IDX_D319A22BC4663E4 (page_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sonata_page_page (id INT AUTO_INCREMENT NOT NULL, site_id INT DEFAULT NULL, parent_id INT DEFAULT NULL, route_name VARCHAR(255) NOT NULL, page_alias VARCHAR(255) DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, position INT NOT NULL, enabled TINYINT(1) NOT NULL, decorate TINYINT(1) NOT NULL, edited TINYINT(1) NOT NULL, name VARCHAR(255) NOT NULL, slug LONGTEXT DEFAULT NULL, url LONGTEXT DEFAULT NULL, custom_url LONGTEXT DEFAULT NULL, request_method VARCHAR(255) DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, meta_keyword VARCHAR(255) DEFAULT NULL, meta_description VARCHAR(255) DEFAULT NULL, javascript LONGTEXT DEFAULT NULL, stylesheet LONGTEXT DEFAULT NULL, raw_headers LONGTEXT DEFAULT NULL, template VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_134E8350F6BD1646 (site_id), INDEX IDX_134E8350727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sonata_page_site (id INT AUTO_INCREMENT NOT NULL, enabled TINYINT(1) NOT NULL, name VARCHAR(255) NOT NULL, relative_path VARCHAR(255) DEFAULT NULL, host VARCHAR(255) NOT NULL, enabled_from DATETIME DEFAULT NULL, enabled_to DATETIME DEFAULT NULL, is_default TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, locale VARCHAR(7) DEFAULT NULL, title VARCHAR(64) DEFAULT NULL, meta_keywords VARCHAR(255) DEFAULT NULL, meta_description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sonata_user__user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, adresse LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', is_verified TINYINT(1) NOT NULL, username VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_4F797D5E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, adresse LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE articles ADD CONSTRAINT FK_BFDD3168C6E59929 FOREIGN KEY (autheur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE categories ADD CONSTRAINT FK_3AF346681EBAF6CC FOREIGN KEY (articles_id) REFERENCES articles (id)');
        $this->addSql('ALTER TABLE sonata_page_block ADD CONSTRAINT FK_D319A22B727ACA70 FOREIGN KEY (parent_id) REFERENCES sonata_page_block (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sonata_page_block ADD CONSTRAINT FK_D319A22BC4663E4 FOREIGN KEY (page_id) REFERENCES sonata_page_page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sonata_page_page ADD CONSTRAINT FK_134E8350F6BD1646 FOREIGN KEY (site_id) REFERENCES sonata_page_site (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sonata_page_page ADD CONSTRAINT FK_134E8350727ACA70 FOREIGN KEY (parent_id) REFERENCES sonata_page_page (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE articles DROP FOREIGN KEY FK_BFDD3168C6E59929');
        $this->addSql('ALTER TABLE categories DROP FOREIGN KEY FK_3AF346681EBAF6CC');
        $this->addSql('ALTER TABLE sonata_page_block DROP FOREIGN KEY FK_D319A22B727ACA70');
        $this->addSql('ALTER TABLE sonata_page_block DROP FOREIGN KEY FK_D319A22BC4663E4');
        $this->addSql('ALTER TABLE sonata_page_page DROP FOREIGN KEY FK_134E8350F6BD1646');
        $this->addSql('ALTER TABLE sonata_page_page DROP FOREIGN KEY FK_134E8350727ACA70');
        $this->addSql('DROP TABLE articles');
        $this->addSql('DROP TABLE baniere');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE log');
        $this->addSql('DROP TABLE sonata_page_block');
        $this->addSql('DROP TABLE sonata_page_page');
        $this->addSql('DROP TABLE sonata_page_site');
        $this->addSql('DROP TABLE sonata_user__user');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
