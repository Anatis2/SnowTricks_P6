<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200302132213 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE picture CHANGE name name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE trick CHANGE category_id category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sf_user DROP FOREIGN KEY FK_28E707FE537A1329');
        $this->addSql('DROP INDEX IDX_28E707FE537A1329 ON sf_user');
        $this->addSql('ALTER TABLE sf_user DROP message_id, CHANGE phonenumber phonenumber VARCHAR(255) DEFAULT NULL, CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE picture CHANGE name name VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE sf_User ADD message_id INT NOT NULL, CHANGE phonenumber phonenumber VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
        $this->addSql('ALTER TABLE sf_User ADD CONSTRAINT FK_28E707FE537A1329 FOREIGN KEY (message_id) REFERENCES message (id)');
        $this->addSql('CREATE INDEX IDX_28E707FE537A1329 ON sf_User (message_id)');
        $this->addSql('ALTER TABLE trick CHANGE category_id category_id INT DEFAULT NULL');
    }
}
