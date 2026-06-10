<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260609102528 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inventory_item DROP FOREIGN KEY `FK_55BDEA30A9C51563`');
        $this->addSql('ALTER TABLE inventory_item ADD item_template_id INT NOT NULL, CHANGE partie_en_cours_id partie_en_cours_id INT NOT NULL');
        $this->addSql('ALTER TABLE inventory_item ADD CONSTRAINT FK_55BDEA30A9C51563 FOREIGN KEY (partie_en_cours_id) REFERENCES partie_en_cours (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE inventory_item ADD CONSTRAINT FK_55BDEA30E5B2578E FOREIGN KEY (item_template_id) REFERENCES item_template (id)');
        $this->addSql('CREATE INDEX IDX_55BDEA30E5B2578E ON inventory_item (item_template_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inventory_item DROP FOREIGN KEY FK_55BDEA30A9C51563');
        $this->addSql('ALTER TABLE inventory_item DROP FOREIGN KEY FK_55BDEA30E5B2578E');
        $this->addSql('DROP INDEX IDX_55BDEA30E5B2578E ON inventory_item');
        $this->addSql('ALTER TABLE inventory_item DROP item_template_id, CHANGE partie_en_cours_id partie_en_cours_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE inventory_item ADD CONSTRAINT `FK_55BDEA30A9C51563` FOREIGN KEY (partie_en_cours_id) REFERENCES item_template (id)');
    }
}
