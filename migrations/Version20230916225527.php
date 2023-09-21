<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230916225527 extends AbstractMigration
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
        $this->addSql('ALTER TABLE exercice ADD cours_id INT NOT NULL');
        $this->addSql('ALTER TABLE exercice ADD CONSTRAINT FK_E418C74D7ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id)');
        $this->addSql('CREATE INDEX IDX_E418C74D7ECF78B0 ON exercice (cours_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9C2AADBACD');
        $this->addSql('DROP INDEX IDX_FDCA8C9C2AADBACD ON cours');
        $this->addSql('ALTER TABLE exercice DROP FOREIGN KEY FK_E418C74D7ECF78B0');
        $this->addSql('DROP INDEX IDX_E418C74D7ECF78B0 ON exercice');
        $this->addSql('ALTER TABLE exercice DROP cours_id');
    }
}
