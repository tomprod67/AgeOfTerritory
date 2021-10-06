<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190703202548 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user CHANGE evolution_id evolution_id INT NOT NULL, CHANGE username username VARCHAR(50) NOT NULL, CHANGE record_date record_date DATETIME NOT NULL, CHANGE last_connection last_connection DATETIME NOT NULL, CHANGE status status TINYINT(1) NOT NULL, CHANGE birth_date birth_date DATE NOT NULL, CHANGE grade api_token VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user CHANGE evolution_id evolution_id INT DEFAULT NULL, CHANGE username username VARCHAR(50) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE record_date record_date DATETIME DEFAULT NULL, CHANGE last_connection last_connection DATETIME DEFAULT NULL, CHANGE status status TINYINT(1) DEFAULT NULL, CHANGE birth_date birth_date DATE DEFAULT NULL, CHANGE api_token grade VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
    }
}
