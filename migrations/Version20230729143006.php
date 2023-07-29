<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230729143006 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reception (id INT AUTO_INCREMENT NOT NULL, service_note_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_50D6852FE9695AC9 (service_note_id), INDEX IDX_50D6852FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reception ADD CONSTRAINT FK_50D6852FE9695AC9 FOREIGN KEY (service_note_id) REFERENCES service_note (id)');
        $this->addSql('ALTER TABLE reception ADD CONSTRAINT FK_50D6852FA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reception DROP FOREIGN KEY FK_50D6852FE9695AC9');
        $this->addSql('ALTER TABLE reception DROP FOREIGN KEY FK_50D6852FA76ED395');
        $this->addSql('DROP TABLE reception');
    }
}
