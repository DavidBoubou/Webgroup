<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221208223801 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE articles DROP INDEX IDX_BFDD3168C6E59929, ADD UNIQUE INDEX UNIQ_BFDD3168C6E59929 (autheur_id)');
        $this->addSql('ALTER TABLE articles CHANGE autheur_id autheur_id INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE articles DROP INDEX UNIQ_BFDD3168C6E59929, ADD INDEX IDX_BFDD3168C6E59929 (autheur_id)');
        $this->addSql('ALTER TABLE articles CHANGE autheur_id autheur_id INT DEFAULT NULL');
    }
}
