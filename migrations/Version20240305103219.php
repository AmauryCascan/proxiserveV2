<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240305103219 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE rob (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rob_type (rob_id INT NOT NULL, type_id INT NOT NULL, INDEX IDX_A44C0BF6E465CE5F (rob_id), INDEX IDX_A44C0BF6C54C8C93 (type_id), PRIMARY KEY(rob_id, type_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE rob_type ADD CONSTRAINT FK_A44C0BF6E465CE5F FOREIGN KEY (rob_id) REFERENCES rob (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rob_type ADD CONSTRAINT FK_A44C0BF6C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rob_type DROP FOREIGN KEY FK_A44C0BF6E465CE5F');
        $this->addSql('ALTER TABLE rob_type DROP FOREIGN KEY FK_A44C0BF6C54C8C93');
        $this->addSql('DROP TABLE rob');
        $this->addSql('DROP TABLE rob_type');
    }
}
