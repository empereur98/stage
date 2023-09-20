<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230920122927 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9C2AADBACD FOREIGN KEY (langue_id) REFERENCES langue (id)');
        $this->addSql('CREATE INDEX IDX_FDCA8C9C2AADBACD ON cours (langue_id)');
        $this->addSql('ALTER TABLE vocabulaire ADD uppade_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE audio filename VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9C2AADBACD');
        $this->addSql('DROP INDEX IDX_FDCA8C9C2AADBACD ON cours');
        $this->addSql('ALTER TABLE vocabulaire DROP uppade_at, CHANGE filename audio VARCHAR(255) DEFAULT NULL');
    }
}
