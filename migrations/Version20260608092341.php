<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260608092341 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE hero_template_skill (hero_template_id INT NOT NULL, skill_id INT NOT NULL, INDEX IDX_DA763AB8D560A15F (hero_template_id), INDEX IDX_DA763AB85585C142 (skill_id), PRIMARY KEY (hero_template_id, skill_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE hero_template_skill ADD CONSTRAINT FK_DA763AB8D560A15F FOREIGN KEY (hero_template_id) REFERENCES hero_template (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE hero_template_skill ADD CONSTRAINT FK_DA763AB85585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hero_template_skill DROP FOREIGN KEY FK_DA763AB8D560A15F');
        $this->addSql('ALTER TABLE hero_template_skill DROP FOREIGN KEY FK_DA763AB85585C142');
        $this->addSql('DROP TABLE hero_template_skill');
    }
}
