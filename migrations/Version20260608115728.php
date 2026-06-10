<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260608115728 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE partie_en_cours_skill (partie_en_cours_id INT NOT NULL, skill_id INT NOT NULL, INDEX IDX_D1121AEBA9C51563 (partie_en_cours_id), INDEX IDX_D1121AEB5585C142 (skill_id), PRIMARY KEY (partie_en_cours_id, skill_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE partie_en_cours_skill ADD CONSTRAINT FK_D1121AEBA9C51563 FOREIGN KEY (partie_en_cours_id) REFERENCES partie_en_cours (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE partie_en_cours_skill ADD CONSTRAINT FK_D1121AEB5585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE partie_en_cours_skill DROP FOREIGN KEY FK_D1121AEBA9C51563');
        $this->addSql('ALTER TABLE partie_en_cours_skill DROP FOREIGN KEY FK_D1121AEB5585C142');
        $this->addSql('DROP TABLE partie_en_cours_skill');
    }
}
