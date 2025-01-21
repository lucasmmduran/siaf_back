<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250113141615 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE form (id INT AUTO_INCREMENT NOT NULL, level_id_id INT DEFAULT NULL, created_by_user_id_id INT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, is_active TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_5288FD4F159D9B5E (level_id_id), INDEX IDX_5288FD4FAEDF7DEF (created_by_user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE level (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, is_active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE form ADD CONSTRAINT FK_5288FD4F159D9B5E FOREIGN KEY (level_id_id) REFERENCES level (id)');
        $this->addSql('ALTER TABLE form ADD CONSTRAINT FK_5288FD4FAEDF7DEF FOREIGN KEY (created_by_user_id_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE form DROP FOREIGN KEY FK_5288FD4F159D9B5E');
        $this->addSql('ALTER TABLE form DROP FOREIGN KEY FK_5288FD4FAEDF7DEF');
        $this->addSql('DROP TABLE form');
        $this->addSql('DROP TABLE level');
    }
}
