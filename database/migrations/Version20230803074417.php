<?php

declare(strict_types=1);

namespace Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230803074417 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE regular_subjects (id INT NOT NULL, subject_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_A65D393423EDC87 (subject_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE schools (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE special_subjects (id INT NOT NULL, subject_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_2B98F28023EDC87 (subject_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE students (id INT AUTO_INCREMENT NOT NULL, school_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', birthdate DATE NOT NULL, email VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, name_first VARCHAR(255) NOT NULL, name_last VARCHAR(255) NOT NULL, type INT NOT NULL, INDEX IDX_A4698DB2C32A47EE (school_id), UNIQUE INDEX unique_email (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student_subject (student_id INT NOT NULL, subject_id INT NOT NULL, INDEX IDX_16F88B82CB944F1A (student_id), INDEX IDX_16F88B8223EDC87 (subject_id), PRIMARY KEY(student_id, subject_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subjects (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, type INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE regular_subjects ADD CONSTRAINT FK_A65D393423EDC87 FOREIGN KEY (subject_id) REFERENCES subjects (id)');
        $this->addSql('ALTER TABLE regular_subjects ADD CONSTRAINT FK_A65D3934BF396750 FOREIGN KEY (id) REFERENCES subjects (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE special_subjects ADD CONSTRAINT FK_2B98F28023EDC87 FOREIGN KEY (subject_id) REFERENCES subjects (id)');
        $this->addSql('ALTER TABLE special_subjects ADD CONSTRAINT FK_2B98F280BF396750 FOREIGN KEY (id) REFERENCES subjects (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE students ADD CONSTRAINT FK_A4698DB2C32A47EE FOREIGN KEY (school_id) REFERENCES schools (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE student_subject ADD CONSTRAINT FK_16F88B82CB944F1A FOREIGN KEY (student_id) REFERENCES students (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE student_subject ADD CONSTRAINT FK_16F88B8223EDC87 FOREIGN KEY (subject_id) REFERENCES subjects (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE students DROP FOREIGN KEY FK_A4698DB2C32A47EE');
        $this->addSql('ALTER TABLE student_subject DROP FOREIGN KEY FK_16F88B82CB944F1A');
        $this->addSql('ALTER TABLE regular_subjects DROP FOREIGN KEY FK_A65D393423EDC87');
        $this->addSql('ALTER TABLE regular_subjects DROP FOREIGN KEY FK_A65D3934BF396750');
        $this->addSql('ALTER TABLE special_subjects DROP FOREIGN KEY FK_2B98F28023EDC87');
        $this->addSql('ALTER TABLE special_subjects DROP FOREIGN KEY FK_2B98F280BF396750');
        $this->addSql('ALTER TABLE student_subject DROP FOREIGN KEY FK_16F88B8223EDC87');
        $this->addSql('DROP TABLE regular_subjects');
        $this->addSql('DROP TABLE schools');
        $this->addSql('DROP TABLE special_subjects');
        $this->addSql('DROP TABLE students');
        $this->addSql('DROP TABLE student_subject');
        $this->addSql('DROP TABLE subjects');
    }
}
