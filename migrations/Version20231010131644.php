<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231010131644 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE messaging DROP FOREIGN KEY FK_EE15BA61A76ED395');
        $this->addSql('DROP INDEX IDX_EE15BA61A76ED395 ON messaging');
        $this->addSql('ALTER TABLE messaging DROP user_id, DROP content, DROP date_content');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE messaging ADD user_id INT DEFAULT NULL, ADD content LONGTEXT NOT NULL, ADD date_content DATE NOT NULL');
        $this->addSql('ALTER TABLE messaging ADD CONSTRAINT FK_EE15BA61A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_EE15BA61A76ED395 ON messaging (user_id)');
    }
}
