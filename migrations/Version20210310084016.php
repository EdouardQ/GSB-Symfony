<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210310084016 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE expense_bundle (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(50) NOT NULL, montant NUMERIC(5, 2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE expense_form (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, state_id INT NOT NULL, mois VARCHAR(7) NOT NULL, nb_justificatifs INT NOT NULL, montant_valide NUMERIC(8, 2) NOT NULL, date_modif DATETIME NOT NULL, token VARCHAR(59) NOT NULL, INDEX IDX_E62FB32DA76ED395 (user_id), INDEX IDX_E62FB32D5D83CC1 (state_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE line_expense_bundle (id INT AUTO_INCREMENT NOT NULL, expense_form_id INT NOT NULL, expense_bundle_id INT NOT NULL, quantite INT NOT NULL, INDEX IDX_5722D10032EDD047 (expense_form_id), INDEX IDX_5722D100355DF2A9 (expense_bundle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE line_expense_out_bundle (id INT AUTO_INCREMENT NOT NULL, expense_form_id INT NOT NULL, libelle VARCHAR(255) NOT NULL, date DATE NOT NULL, montant NUMERIC(9, 2) NOT NULL, INDEX IDX_770EF1D532EDD047 (expense_form_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE state (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, login VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, adresse VARCHAR(255) NOT NULL, code_postal VARCHAR(5) NOT NULL, date_embauche DATE NOT NULL, email VARCHAR(255) NOT NULL, ville VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_8D93D649AA08CB10 (login), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
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
