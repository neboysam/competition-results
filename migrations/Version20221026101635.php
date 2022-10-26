<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221026101635 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE competitor_category (competitor_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_6E1E2C9878A5D405 (competitor_id), INDEX IDX_6E1E2C9812469DE2 (category_id), PRIMARY KEY(competitor_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE competitor_category ADD CONSTRAINT FK_6E1E2C9878A5D405 FOREIGN KEY (competitor_id) REFERENCES competitor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE competitor_category ADD CONSTRAINT FK_6E1E2C9812469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE competitor_category DROP FOREIGN KEY FK_6E1E2C9878A5D405');
        $this->addSql('ALTER TABLE competitor_category DROP FOREIGN KEY FK_6E1E2C9812469DE2');
        $this->addSql('DROP TABLE competitor_category');
    }
}
