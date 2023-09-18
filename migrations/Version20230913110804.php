<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230913110804 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vocabulaire ADD lesson_id INT NOT NULL, DROP niveau_difficulte, CHANGE exemple exemple VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE vocabulaire ADD CONSTRAINT FK_DB1ADE7DCDF80196 FOREIGN KEY (lesson_id) REFERENCES cours (id)');
        $this->addSql('CREATE INDEX IDX_DB1ADE7DCDF80196 ON vocabulaire (lesson_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vocabulaire DROP FOREIGN KEY FK_DB1ADE7DCDF80196');
        $this->addSql('DROP INDEX IDX_DB1ADE7DCDF80196 ON vocabulaire');
        $this->addSql('ALTER TABLE vocabulaire ADD niveau_difficulte LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', DROP lesson_id, CHANGE exemple exemple LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\'');
    }
}
