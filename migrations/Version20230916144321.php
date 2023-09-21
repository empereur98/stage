<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230916144321 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
       // $this->addSql('DROP TABLE commercants');
       // $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9C2AADBACD FOREIGN KEY (langue_id) REFERENCES langue (id)');
       // $this->addSql('CREATE INDEX IDX_FDCA8C9C2AADBACD ON cours (langue_id)');
        //$this->addSql('ALTER TABLE user ADD niveau VARCHAR(255) DEFAULT NULL, ADD progres INT NOT NULL, DROP password, DROP roles');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commercants (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:json)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9C2AADBACD');
        $this->addSql('DROP INDEX IDX_FDCA8C9C2AADBACD ON cours');
        $this->addSql('ALTER TABLE user ADD password VARCHAR(255) NOT NULL, ADD roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', DROP niveau, DROP progres');
    }
}
