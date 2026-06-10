<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260608142910 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE inventory_item (id INT AUTO_INCREMENT NOT NULL, quantity INT NOT NULL, partie_en_cours_id INT DEFAULT NULL, INDEX IDX_55BDEA30A9C51563 (partie_en_cours_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE item_template (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, value INT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE inventory_item ADD CONSTRAINT FK_55BDEA30A9C51563 FOREIGN KEY (partie_en_cours_id) REFERENCES item_template (id)');
        $this->addSql('ALTER TABLE item DROP FOREIGN KEY `FK_1F1B251EA9C51563`');
        $this->addSql('DROP TABLE item');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE item (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, type VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, value INT NOT NULL, partie_en_cours_id INT DEFAULT NULL, INDEX IDX_1F1B251EA9C51563 (partie_en_cours_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT `FK_1F1B251EA9C51563` FOREIGN KEY (partie_en_cours_id) REFERENCES partie_en_cours (id)');
        $this->addSql('ALTER TABLE inventory_item DROP FOREIGN KEY FK_55BDEA30A9C51563');
        $this->addSql('DROP TABLE inventory_item');
        $this->addSql('DROP TABLE item_template');
    }
}
