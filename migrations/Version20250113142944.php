<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250113142944 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE form DROP FOREIGN KEY FK_5288FD4FB03A8386');
        $this->addSql('DROP INDEX IDX_5288FD4FB03A8386 ON form');
        $this->addSql('ALTER TABLE form CHANGE created_by_id created_by_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE form ADD CONSTRAINT FK_5288FD4F7D182D95 FOREIGN KEY (created_by_user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_5288FD4F7D182D95 ON form (created_by_user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE form DROP FOREIGN KEY FK_5288FD4F7D182D95');
        $this->addSql('DROP INDEX IDX_5288FD4F7D182D95 ON form');
        $this->addSql('ALTER TABLE form CHANGE created_by_user_id created_by_id INT NOT NULL');
        $this->addSql('ALTER TABLE form ADD CONSTRAINT FK_5288FD4FB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_5288FD4FB03A8386 ON form (created_by_id)');
    }
}
