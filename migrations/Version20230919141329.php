<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230919141329 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE meet (id INT AUTO_INCREMENT NOT NULL, patient_id INT DEFAULT NULL, user_id INT DEFAULT NULL, info_complementaire LONGTEXT DEFAULT NULL, type_soin LONGTEXT NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, type_passage VARCHAR(255) NOT NULL, INDEX IDX_E9F6D3CE6B899279 (patient_id), INDEX IDX_E9F6D3CEA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE passage (id INT AUTO_INCREMENT NOT NULL, meet_id INT DEFAULT NULL, hour TIME NOT NULL, date_passage DATE NOT NULL, etat_passage TINYINT(1) NOT NULL, INDEX IDX_2B258F673BBBF66 (meet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE patient (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, adress VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, birthday DATE NOT NULL, num_secu VARCHAR(255) NOT NULL, genre VARCHAR(255) NOT NULL, info_sup_adress LONGTEXT DEFAULT NULL, full_name_medecin_traitant VARCHAR(255) NOT NULL, phone_medecin_traitant VARCHAR(255) NOT NULL, pharmacie_name VARCHAR(255) DEFAULT NULL, phone_pharmacie VARCHAR(255) DEFAULT NULL, full_name_urgent_contact VARCHAR(255) NOT NULL, phone_urgent_contact VARCHAR(255) NOT NULL, INDEX IDX_1ADAD7EBA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE meet ADD CONSTRAINT FK_E9F6D3CE6B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE meet ADD CONSTRAINT FK_E9F6D3CEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE passage ADD CONSTRAINT FK_2B258F673BBBF66 FOREIGN KEY (meet_id) REFERENCES meet (id)');
        $this->addSql('ALTER TABLE patient ADD CONSTRAINT FK_1ADAD7EBA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD name VARCHAR(255) NOT NULL, ADD firstname VARCHAR(255) NOT NULL, ADD phone VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE meet DROP FOREIGN KEY FK_E9F6D3CE6B899279');
        $this->addSql('ALTER TABLE meet DROP FOREIGN KEY FK_E9F6D3CEA76ED395');
        $this->addSql('ALTER TABLE passage DROP FOREIGN KEY FK_2B258F673BBBF66');
        $this->addSql('ALTER TABLE patient DROP FOREIGN KEY FK_1ADAD7EBA76ED395');
        $this->addSql('DROP TABLE meet');
        $this->addSql('DROP TABLE passage');
        $this->addSql('DROP TABLE patient');
        $this->addSql('ALTER TABLE user DROP name, DROP firstname, DROP phone');
    }
}
