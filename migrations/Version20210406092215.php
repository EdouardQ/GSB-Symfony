<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210406092215 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE expense_bundle (id INT AUTO_INCREMENT NOT NULL, wording VARCHAR(50) NOT NULL, amount NUMERIC(5, 2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE expense_form (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, state_id INT NOT NULL, month VARCHAR(7) NOT NULL, nb_supporting_documents INT NOT NULL, valid_amount NUMERIC(8, 2) NOT NULL, date_update DATETIME NOT NULL, token VARCHAR(59) NOT NULL, INDEX IDX_E62FB32DA76ED395 (user_id), INDEX IDX_E62FB32D5D83CC1 (state_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE line_expense_bundle (id INT AUTO_INCREMENT NOT NULL, expense_form_id INT NOT NULL, expense_bundle_id INT NOT NULL, quantity INT NOT NULL, date DATE DEFAULT NULL, INDEX IDX_5722D10032EDD047 (expense_form_id), INDEX IDX_5722D100355DF2A9 (expense_bundle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE line_expense_out_bundle (id INT AUTO_INCREMENT NOT NULL, expense_form_id INT NOT NULL, wording VARCHAR(255) NOT NULL, date DATE NOT NULL, amount NUMERIC(9, 2) NOT NULL, supporting_document VARCHAR(100) DEFAULT NULL, valid TINYINT(1) NOT NULL, INDEX IDX_770EF1D532EDD047 (expense_form_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medication (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(10) NOT NULL, name VARCHAR(50) NOT NULL, family VARCHAR(150) NOT NULL, composition VARCHAR(255) NOT NULL, side_effects LONGTEXT DEFAULT NULL, contraindications LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE practitioner (id INT AUTO_INCREMENT NOT NULL, workplace_id INT NOT NULL, name VARCHAR(50) NOT NULL, first_name VARCHAR(50) NOT NULL, adress VARCHAR(255) NOT NULL, postal_code VARCHAR(5) NOT NULL, city VARCHAR(50) NOT NULL, coeff_reputation NUMERIC(7, 2) NOT NULL, INDEX IDX_17323CBCAC25FB46 (workplace_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE report (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, practitioner_id INT NOT NULL, date DATE NOT NULL, reason_visit VARCHAR(255) NOT NULL, summary LONGTEXT NOT NULL, INDEX IDX_C42F7784A76ED395 (user_id), INDEX IDX_C42F77841121EA2C (practitioner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE samples_offer (id INT AUTO_INCREMENT NOT NULL, report_id INT NOT NULL, medication_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_3B44F4D04BD2A4C0 (report_id), INDEX IDX_3B44F4D02C4DE6DA (medication_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE state (id INT AUTO_INCREMENT NOT NULL, wording VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, login VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(50) NOT NULL, first_name VARCHAR(50) NOT NULL, adress VARCHAR(255) NOT NULL, postal_code VARCHAR(5) NOT NULL, hiring_date DATE NOT NULL, email VARCHAR(255) NOT NULL, city VARCHAR(50) NOT NULL, enabled TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649AA08CB10 (login), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE workplace (id INT AUTO_INCREMENT NOT NULL, wording VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE expense_form ADD CONSTRAINT FK_E62FB32DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE expense_form ADD CONSTRAINT FK_E62FB32D5D83CC1 FOREIGN KEY (state_id) REFERENCES state (id)');
        $this->addSql('ALTER TABLE line_expense_bundle ADD CONSTRAINT FK_5722D10032EDD047 FOREIGN KEY (expense_form_id) REFERENCES expense_form (id)');
        $this->addSql('ALTER TABLE line_expense_bundle ADD CONSTRAINT FK_5722D100355DF2A9 FOREIGN KEY (expense_bundle_id) REFERENCES expense_bundle (id)');
        $this->addSql('ALTER TABLE line_expense_out_bundle ADD CONSTRAINT FK_770EF1D532EDD047 FOREIGN KEY (expense_form_id) REFERENCES expense_form (id)');
        $this->addSql('ALTER TABLE practitioner ADD CONSTRAINT FK_17323CBCAC25FB46 FOREIGN KEY (workplace_id) REFERENCES workplace (id)');
        $this->addSql('ALTER TABLE report ADD CONSTRAINT FK_C42F7784A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE report ADD CONSTRAINT FK_C42F77841121EA2C FOREIGN KEY (practitioner_id) REFERENCES practitioner (id)');
        $this->addSql('ALTER TABLE samples_offer ADD CONSTRAINT FK_3B44F4D04BD2A4C0 FOREIGN KEY (report_id) REFERENCES report (id)');
        $this->addSql('ALTER TABLE samples_offer ADD CONSTRAINT FK_3B44F4D02C4DE6DA FOREIGN KEY (medication_id) REFERENCES medication (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE line_expense_bundle DROP FOREIGN KEY FK_5722D100355DF2A9');
        $this->addSql('ALTER TABLE line_expense_bundle DROP FOREIGN KEY FK_5722D10032EDD047');
        $this->addSql('ALTER TABLE line_expense_out_bundle DROP FOREIGN KEY FK_770EF1D532EDD047');
        $this->addSql('ALTER TABLE samples_offer DROP FOREIGN KEY FK_3B44F4D02C4DE6DA');
        $this->addSql('ALTER TABLE report DROP FOREIGN KEY FK_C42F77841121EA2C');
        $this->addSql('ALTER TABLE samples_offer DROP FOREIGN KEY FK_3B44F4D04BD2A4C0');
        $this->addSql('ALTER TABLE expense_form DROP FOREIGN KEY FK_E62FB32D5D83CC1');
        $this->addSql('ALTER TABLE expense_form DROP FOREIGN KEY FK_E62FB32DA76ED395');
        $this->addSql('ALTER TABLE report DROP FOREIGN KEY FK_C42F7784A76ED395');
        $this->addSql('ALTER TABLE practitioner DROP FOREIGN KEY FK_17323CBCAC25FB46');
        $this->addSql('DROP TABLE expense_bundle');
        $this->addSql('DROP TABLE expense_form');
        $this->addSql('DROP TABLE line_expense_bundle');
        $this->addSql('DROP TABLE line_expense_out_bundle');
        $this->addSql('DROP TABLE medication');
        $this->addSql('DROP TABLE practitioner');
        $this->addSql('DROP TABLE report');
        $this->addSql('DROP TABLE samples_offer');
        $this->addSql('DROP TABLE state');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE workplace');
    }
}
