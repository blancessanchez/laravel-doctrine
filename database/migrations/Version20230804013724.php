<?php

declare(strict_types=1);

namespace Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230804013724 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE districts (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', name VARCHAR(255) NOT NULL, area DOUBLE PRECISION NOT NULL, total_schools INT NOT NULL, superintendent VARCHAR(255) NOT NULL, phone_no VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE schools ADD district_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\'');
        $this->addSql('ALTER TABLE schools ADD CONSTRAINT FK_47443BD5B08FA272 FOREIGN KEY (district_id) REFERENCES districts (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_47443BD5B08FA272 ON schools (district_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE schools DROP FOREIGN KEY FK_47443BD5B08FA272');
        $this->addSql('DROP TABLE districts');
        $this->addSql('DROP INDEX IDX_47443BD5B08FA272 ON schools');
        $this->addSql('ALTER TABLE schools DROP district_id');
    }
}
