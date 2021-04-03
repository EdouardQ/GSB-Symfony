<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210403235635 extends AbstractMigration
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
        $this->addSql('CREATE TABLE line_expense_out_bundle (id INT AUTO_INCREMENT NOT NULL, expense_form_id INT NOT NULL, wording VARCHAR(255) NOT NULL, date DATE NOT NULL, amount NUMERIC(9, 2) NOT NULL, INDEX IDX_770EF1D532EDD047 (expense_form_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE state (id INT AUTO_INCREMENT NOT NULL, wording VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, login VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(50) NOT NULL, first_name VARCHAR(50) NOT NULL, adress VARCHAR(255) NOT NULL, postal_code VARCHAR(5) NOT NULL, hiring_date DATE NOT NULL, email VARCHAR(255) NOT NULL, city VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_8D93D649AA08CB10 (login), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE expense_form ADD CONSTRAINT FK_E62FB32DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE expense_form ADD CONSTRAINT FK_E62FB32D5D83CC1 FOREIGN KEY (state_id) REFERENCES state (id)');
        $this->addSql('ALTER TABLE line_expense_bundle ADD CONSTRAINT FK_5722D10032EDD047 FOREIGN KEY (expense_form_id) REFERENCES expense_form (id)');
        $this->addSql('ALTER TABLE line_expense_bundle ADD CONSTRAINT FK_5722D100355DF2A9 FOREIGN KEY (expense_bundle_id) REFERENCES expense_bundle (id)');
        $this->addSql('ALTER TABLE line_expense_out_bundle ADD CONSTRAINT FK_770EF1D532EDD047 FOREIGN KEY (expense_form_id) REFERENCES expense_form (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE line_expense_bundle DROP FOREIGN KEY FK_5722D100355DF2A9');
        $this->addSql('ALTER TABLE line_expense_bundle DROP FOREIGN KEY FK_5722D10032EDD047');
        $this->addSql('ALTER TABLE line_expense_out_bundle DROP FOREIGN KEY FK_770EF1D532EDD047');
        $this->addSql('ALTER TABLE expense_form DROP FOREIGN KEY FK_E62FB32D5D83CC1');
        $this->addSql('ALTER TABLE expense_form DROP FOREIGN KEY FK_E62FB32DA76ED395');
        $this->addSql('DROP TABLE expense_bundle');
        $this->addSql('DROP TABLE expense_form');
        $this->addSql('DROP TABLE line_expense_bundle');
        $this->addSql('DROP TABLE line_expense_out_bundle');
        $this->addSql('DROP TABLE state');
        $this->addSql('DROP TABLE user');
    }
}
