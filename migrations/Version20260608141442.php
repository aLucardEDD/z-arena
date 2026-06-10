<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260608141442 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE item (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, value INT NOT NULL, partie_en_cours_id INT DEFAULT NULL, INDEX IDX_1F1B251EA9C51563 (partie_en_cours_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251EA9C51563 FOREIGN KEY (partie_en_cours_id) REFERENCES partie_en_cours (id)');
        $this->addSql('ALTER TABLE partie_en_cours ADD CONSTRAINT FK_9B775BAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251EA9C51563');
        $this->addSql('DROP TABLE item');
        $this->addSql('ALTER TABLE partie_en_cours DROP FOREIGN KEY FK_9B775BAA76ED395');
    }
}
