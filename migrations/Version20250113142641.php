<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250113142641 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE form DROP FOREIGN KEY FK_5288FD4F159D9B5E');
        $this->addSql('ALTER TABLE form DROP FOREIGN KEY FK_5288FD4FAEDF7DEF');
        $this->addSql('DROP INDEX UNIQ_5288FD4F159D9B5E ON form');
        $this->addSql('DROP INDEX IDX_5288FD4FAEDF7DEF ON form');
        $this->addSql('ALTER TABLE form ADD created_by_id INT NOT NULL, DROP level_id_id, CHANGE created_by_user_id_id level_id INT NOT NULL');
        $this->addSql('ALTER TABLE form ADD CONSTRAINT FK_5288FD4F5FB14BA7 FOREIGN KEY (level_id) REFERENCES level (id)');
        $this->addSql('ALTER TABLE form ADD CONSTRAINT FK_5288FD4FB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_5288FD4F5FB14BA7 ON form (level_id)');
        $this->addSql('CREATE INDEX IDX_5288FD4FB03A8386 ON form (created_by_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE form DROP FOREIGN KEY FK_5288FD4F5FB14BA7');
        $this->addSql('ALTER TABLE form DROP FOREIGN KEY FK_5288FD4FB03A8386');
        $this->addSql('DROP INDEX IDX_5288FD4F5FB14BA7 ON form');
        $this->addSql('DROP INDEX IDX_5288FD4FB03A8386 ON form');
        $this->addSql('ALTER TABLE form ADD level_id_id INT DEFAULT NULL, ADD created_by_user_id_id INT NOT NULL, DROP level_id, DROP created_by_id');
        $this->addSql('ALTER TABLE form ADD CONSTRAINT FK_5288FD4F159D9B5E FOREIGN KEY (level_id_id) REFERENCES level (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE form ADD CONSTRAINT FK_5288FD4FAEDF7DEF FOREIGN KEY (created_by_user_id_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5288FD4F159D9B5E ON form (level_id_id)');
        $this->addSql('CREATE INDEX IDX_5288FD4FAEDF7DEF ON form (created_by_user_id_id)');
    }
}
