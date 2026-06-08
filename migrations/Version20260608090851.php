<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260608090851 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ennemies_template (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, base_hp INT NOT NULL, base_attack INT NOT NULL, xp_reward INT NOT NULL, image_path VARCHAR(255) NOT NULL, is_boss TINYINT NOT NULL, is_semi_boss TINYINT NOT NULL, world INT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE hero_template (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, base_hp INT NOT NULL, base_ki INT NOT NULL, image_path VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE partie_en_cours (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, hero_id INT NOT NULL, hp INT NOT NULL, max_hp INT NOT NULL, ki INT NOT NULL, max_ki INT NOT NULL, level INT NOT NULL, xp INT NOT NULL, corrent_world INT NOT NULL, current_stage INT NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE skill (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, identifiant VARCHAR(255) NOT NULL, ki_cost INT NOT NULL, type VARCHAR(255) NOT NULL, niveau_requis INT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE ennemies_template');
        $this->addSql('DROP TABLE hero_template');
        $this->addSql('DROP TABLE partie_en_cours');
        $this->addSql('DROP TABLE skill');
    }
}
