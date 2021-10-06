<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190708185546 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user ADD main_isle_id INT NOT NULL, CHANGE evolution_id evolution_id INT NOT NULL, CHANGE username username VARCHAR(50) NOT NULL, CHANGE record_date record_date DATETIME NOT NULL, CHANGE last_connection last_connection DATETIME NOT NULL, CHANGE status status TINYINT(1) NOT NULL, CHANGE birth_date birth_date DATE NOT NULL, CHANGE api_token api_token VARCHAR(255) NOT NULL, CHANGE roles roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64933858191 FOREIGN KEY (main_isle_id) REFERENCES isle (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64933858191 ON user (main_isle_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64933858191');
        $this->addSql('DROP INDEX UNIQ_8D93D64933858191 ON user');
        $this->addSql('ALTER TABLE user DROP main_isle_id, CHANGE evolution_id evolution_id INT DEFAULT NULL, CHANGE username username VARCHAR(50) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE record_date record_date DATETIME DEFAULT NULL, CHANGE last_connection last_connection DATETIME DEFAULT NULL, CHANGE status status TINYINT(1) DEFAULT NULL, CHANGE birth_date birth_date DATE DEFAULT NULL, CHANGE api_token api_token VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE roles roles LONGTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:array)\'');
    }
}
