<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240305104539 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE rob (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rob_travaux (rob_id INT NOT NULL, travaux_id INT NOT NULL, INDEX IDX_E2FE618EE465CE5F (rob_id), INDEX IDX_E2FE618E9495C4E2 (travaux_id), PRIMARY KEY(rob_id, travaux_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE rob_travaux ADD CONSTRAINT FK_E2FE618EE465CE5F FOREIGN KEY (rob_id) REFERENCES rob (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rob_travaux ADD CONSTRAINT FK_E2FE618E9495C4E2 FOREIGN KEY (travaux_id) REFERENCES travaux (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rob_travaux DROP FOREIGN KEY FK_E2FE618EE465CE5F');
        $this->addSql('ALTER TABLE rob_travaux DROP FOREIGN KEY FK_E2FE618E9495C4E2');
        $this->addSql('DROP TABLE rob');
        $this->addSql('DROP TABLE rob_travaux');
    }
}
