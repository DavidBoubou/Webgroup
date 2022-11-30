<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221130173951 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categories ADD real_articles_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE categories ADD CONSTRAINT FK_3AF346687B8DA9E0 FOREIGN KEY (real_articles_id) REFERENCES articles (id)');
        $this->addSql('CREATE INDEX IDX_3AF346687B8DA9E0 ON categories (real_articles_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categories DROP FOREIGN KEY FK_3AF346687B8DA9E0');
        $this->addSql('DROP INDEX IDX_3AF346687B8DA9E0 ON categories');
        $this->addSql('ALTER TABLE categories DROP real_articles_id');
    }
}
