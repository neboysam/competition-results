<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221027065243 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE file_uploads (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE result DROP FOREIGN KEY FK_136AC113236250DF');
        $this->addSql('ALTER TABLE result DROP FOREIGN KEY FK_136AC1138CF3AC81');
        $this->addSql('ALTER TABLE result DROP FOREIGN KEY FK_136AC1139777D11E');
        $this->addSql('DROP INDEX IDX_136AC1139777D11E ON result');
        $this->addSql('DROP INDEX IDX_136AC113236250DF ON result');
        $this->addSql('DROP INDEX IDX_136AC1138CF3AC81 ON result');
        $this->addSql('ALTER TABLE result ADD competitor_id_id INT NOT NULL, ADD category_id_id INT NOT NULL, ADD competition_id_id INT NOT NULL, DROP competitor_id, DROP category_id, DROP competition_id');
        $this->addSql('ALTER TABLE result ADD CONSTRAINT FK_136AC113236250DF FOREIGN KEY (competitor_id_id) REFERENCES competitor (id)');
        $this->addSql('ALTER TABLE result ADD CONSTRAINT FK_136AC1138CF3AC81 FOREIGN KEY (competition_id_id) REFERENCES competition (id)');
        $this->addSql('ALTER TABLE result ADD CONSTRAINT FK_136AC1139777D11E FOREIGN KEY (category_id_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_136AC1139777D11E ON result (category_id_id)');
        $this->addSql('CREATE INDEX IDX_136AC113236250DF ON result (competitor_id_id)');
        $this->addSql('CREATE INDEX IDX_136AC1138CF3AC81 ON result (competition_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE file_uploads');
        $this->addSql('ALTER TABLE result DROP FOREIGN KEY FK_136AC113236250DF');
        $this->addSql('ALTER TABLE result DROP FOREIGN KEY FK_136AC1139777D11E');
        $this->addSql('ALTER TABLE result DROP FOREIGN KEY FK_136AC1138CF3AC81');
        $this->addSql('DROP INDEX IDX_136AC113236250DF ON result');
        $this->addSql('DROP INDEX IDX_136AC1139777D11E ON result');
        $this->addSql('DROP INDEX IDX_136AC1138CF3AC81 ON result');
        $this->addSql('ALTER TABLE result ADD competitor_id INT NOT NULL, ADD category_id INT NOT NULL, ADD competition_id INT NOT NULL, DROP competitor_id_id, DROP category_id_id, DROP competition_id_id');
        $this->addSql('ALTER TABLE result ADD CONSTRAINT FK_136AC113236250DF FOREIGN KEY (competitor_id) REFERENCES competitor (id)');
        $this->addSql('ALTER TABLE result ADD CONSTRAINT FK_136AC1139777D11E FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE result ADD CONSTRAINT FK_136AC1138CF3AC81 FOREIGN KEY (competition_id) REFERENCES competition (id)');
        $this->addSql('CREATE INDEX IDX_136AC113236250DF ON result (competitor_id)');
        $this->addSql('CREATE INDEX IDX_136AC1139777D11E ON result (category_id)');
        $this->addSql('CREATE INDEX IDX_136AC1138CF3AC81 ON result (competition_id)');
    }
}
