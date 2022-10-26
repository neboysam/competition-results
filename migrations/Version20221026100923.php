<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221026100923 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE result (id INT AUTO_INCREMENT NOT NULL, competitor_id_id INT NOT NULL, category_id_id INT NOT NULL, competition_id_id INT NOT NULL, result1 VARCHAR(255) NOT NULL, result2 VARCHAR(255) NOT NULL, final_result VARCHAR(255) NOT NULL, INDEX IDX_136AC113236250DF (competitor_id_id), INDEX IDX_136AC1139777D11E (category_id_id), INDEX IDX_136AC1138CF3AC81 (competition_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE result ADD CONSTRAINT FK_136AC113236250DF FOREIGN KEY (competitor_id_id) REFERENCES competitor (id)');
        $this->addSql('ALTER TABLE result ADD CONSTRAINT FK_136AC1139777D11E FOREIGN KEY (category_id_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE result ADD CONSTRAINT FK_136AC1138CF3AC81 FOREIGN KEY (competition_id_id) REFERENCES competition (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE result DROP FOREIGN KEY FK_136AC113236250DF');
        $this->addSql('ALTER TABLE result DROP FOREIGN KEY FK_136AC1139777D11E');
        $this->addSql('ALTER TABLE result DROP FOREIGN KEY FK_136AC1138CF3AC81');
        $this->addSql('DROP TABLE result');
    }
}
