<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220919090926 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comments (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, disc_id INT NOT NULL, content LONGTEXT NOT NULL, date DATETIME NOT NULL, update_date DATETIME NOT NULL, INDEX IDX_5F9E962AA76ED395 (user_id), INDEX IDX_5F9E962AC38F37CA (disc_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962AC38F37CA FOREIGN KEY (disc_id) REFERENCES disc (id)');
        $this->addSql('ALTER TABLE disc CHANGE price price INT NOT NULL, CHANGE date_ajout date_ajout DATETIME NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE birthday birthday DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962AA76ED395');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962AC38F37CA');
        $this->addSql('DROP TABLE comments');
        $this->addSql('ALTER TABLE user CHANGE birthday birthday DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE disc CHANGE price price NUMERIC(5, 2) NOT NULL, CHANGE date_ajout date_ajout DATETIME DEFAULT NULL');
    }
}
