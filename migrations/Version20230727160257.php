<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230727160257 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE planned_slot ADD planned_slot_category_id INT NOT NULL');
        $this->addSql('ALTER TABLE planned_slot ADD CONSTRAINT FK_17564DFA8336A436 FOREIGN KEY (planned_slot_category_id) REFERENCES planned_slot_category (id)');
        $this->addSql('CREATE INDEX IDX_17564DFA8336A436 ON planned_slot (planned_slot_category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE planned_slot DROP FOREIGN KEY FK_17564DFA8336A436');
        $this->addSql('DROP INDEX IDX_17564DFA8336A436 ON planned_slot');
        $this->addSql('ALTER TABLE planned_slot DROP planned_slot_category_id');
    }
}
