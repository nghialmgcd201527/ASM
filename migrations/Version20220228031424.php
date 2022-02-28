<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220228031424 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A3319777D11E');
        $this->addSql('CREATE TABLE category_book (id INT AUTO_INCREMENT NOT NULL, category_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE category');
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A3319777D11E');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A3319777D11E FOREIGN KEY (category_id_id) REFERENCES category_book (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A3319777D11E');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, category_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE category_book');
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A3319777D11E');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A3319777D11E FOREIGN KEY (category_id_id) REFERENCES category (id)');
    }
}
