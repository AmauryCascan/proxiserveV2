<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240301134830 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE etat (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE secteur (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE travaux (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, secteur_id INT NOT NULL, etat_id INT NOT NULL, numero INT NOT NULL, year INT NOT NULL, started_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', finished_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', price INT DEFAULT NULL, rdv_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', commande INT DEFAULT NULL, INDEX IDX_6C24F39BC54C8C93 (type_id), INDEX IDX_6C24F39B9F7E4405 (secteur_id), INDEX IDX_6C24F39BD5E86FF (etat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE travaux ADD CONSTRAINT FK_6C24F39BC54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE travaux ADD CONSTRAINT FK_6C24F39B9F7E4405 FOREIGN KEY (secteur_id) REFERENCES secteur (id)');
        $this->addSql('ALTER TABLE travaux ADD CONSTRAINT FK_6C24F39BD5E86FF FOREIGN KEY (etat_id) REFERENCES etat (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE travaux DROP FOREIGN KEY FK_6C24F39BC54C8C93');
        $this->addSql('ALTER TABLE travaux DROP FOREIGN KEY FK_6C24F39B9F7E4405');
        $this->addSql('ALTER TABLE travaux DROP FOREIGN KEY FK_6C24F39BD5E86FF');
        $this->addSql('DROP TABLE etat');
        $this->addSql('DROP TABLE secteur');
        $this->addSql('DROP TABLE travaux');
        $this->addSql('DROP TABLE type');
    }
}
