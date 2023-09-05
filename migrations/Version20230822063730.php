<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230822063730 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE service_note_user (service_note_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_7578FD5BE9695AC9 (service_note_id), INDEX IDX_7578FD5BA76ED395 (user_id), PRIMARY KEY(service_note_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE service_note_user ADD CONSTRAINT FK_7578FD5BE9695AC9 FOREIGN KEY (service_note_id) REFERENCES service_note (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE service_note_user ADD CONSTRAINT FK_7578FD5BA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE service_note_user DROP FOREIGN KEY FK_7578FD5BE9695AC9');
        $this->addSql('ALTER TABLE service_note_user DROP FOREIGN KEY FK_7578FD5BA76ED395');
        $this->addSql('DROP TABLE service_note_user');
    }
}
