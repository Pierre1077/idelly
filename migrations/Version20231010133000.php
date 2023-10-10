<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231010133000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE group_chat (id INT AUTO_INCREMENT NOT NULL, last_update DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE group_chat_user (group_chat_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_EBBC17E99C9A2529 (group_chat_id), INDEX IDX_EBBC17E9A76ED395 (user_id), PRIMARY KEY(group_chat_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE group_chat_user ADD CONSTRAINT FK_EBBC17E99C9A2529 FOREIGN KEY (group_chat_id) REFERENCES group_chat (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE group_chat_user ADD CONSTRAINT FK_EBBC17E9A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE messaging ADD auteur_id INT DEFAULT NULL, ADD group_chat_id INT DEFAULT NULL, ADD content LONGTEXT NOT NULL, ADD date_content DATETIME NOT NULL');
        $this->addSql('ALTER TABLE messaging ADD CONSTRAINT FK_EE15BA6160BB6FE6 FOREIGN KEY (auteur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE messaging ADD CONSTRAINT FK_EE15BA619C9A2529 FOREIGN KEY (group_chat_id) REFERENCES group_chat (id)');
        $this->addSql('CREATE INDEX IDX_EE15BA6160BB6FE6 ON messaging (auteur_id)');
        $this->addSql('CREATE INDEX IDX_EE15BA619C9A2529 ON messaging (group_chat_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE messaging DROP FOREIGN KEY FK_EE15BA619C9A2529');
        $this->addSql('ALTER TABLE group_chat_user DROP FOREIGN KEY FK_EBBC17E99C9A2529');
        $this->addSql('ALTER TABLE group_chat_user DROP FOREIGN KEY FK_EBBC17E9A76ED395');
        $this->addSql('DROP TABLE group_chat');
        $this->addSql('DROP TABLE group_chat_user');
        $this->addSql('ALTER TABLE messaging DROP FOREIGN KEY FK_EE15BA6160BB6FE6');
        $this->addSql('DROP INDEX IDX_EE15BA6160BB6FE6 ON messaging');
        $this->addSql('DROP INDEX IDX_EE15BA619C9A2529 ON messaging');
        $this->addSql('ALTER TABLE messaging DROP auteur_id, DROP group_chat_id, DROP content, DROP date_content');
    }
}
