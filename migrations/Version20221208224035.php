<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221208224035 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE articles DROP FOREIGN KEY FK_BFDD3168C6E59929');
        $this->addSql('DROP INDEX UNIQ_BFDD3168C6E59929 ON articles');
        $this->addSql('ALTER TABLE articles DROP autheur_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE articles ADD autheur_id INT NOT NULL');
        $this->addSql('ALTER TABLE articles ADD CONSTRAINT FK_BFDD3168C6E59929 FOREIGN KEY (autheur_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BFDD3168C6E59929 ON articles (autheur_id)');
    }
}
