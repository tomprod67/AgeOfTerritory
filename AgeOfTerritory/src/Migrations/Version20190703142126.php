<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190703142126 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE build_building (id INT AUTO_INCREMENT NOT NULL, building_id INT NOT NULL, isle_id INT NOT NULL, level_building INT NOT NULL, INDEX IDX_54C3BA24D2A7E12 (building_id), INDEX IDX_54C3BA2C7CE2878 (isle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE build_defense (id INT AUTO_INCREMENT NOT NULL, defense_id INT NOT NULL, isle_id INT NOT NULL, INDEX IDX_F63088F9FB0C2DCF (defense_id), INDEX IDX_F63088F9C7CE2878 (isle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE building (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, picture VARCHAR(255) NOT NULL, wood_cost INT NOT NULL, stone_cost INT NOT NULL, metal_cost INT NOT NULL, building_prod INT NOT NULL, build_time INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE defense (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, picture VARCHAR(255) NOT NULL, damage INT NOT NULL, health INT NOT NULL, wood_cost INT NOT NULL, stone_cost INT NOT NULL, metal_cost INT NOT NULL, build_time INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evolution (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, evolve_time INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE isle (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, map_id INT DEFAULT NULL, longitude INT NOT NULL, latitude INT NOT NULL, description LONGTEXT NOT NULL, picture VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, wood_stock INT NOT NULL, stone_stock INT NOT NULL, metal_stock INT NOT NULL, power_point INT DEFAULT NULL, INDEX IDX_C54D00E0A76ED395 (user_id), INDEX IDX_C54D00E053C55F64 (map_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE machine (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, picture VARCHAR(255) NOT NULL, damage INT NOT NULL, health INT NOT NULL, wood_cost INT NOT NULL, stone_cost INT NOT NULL, metal_cost INT NOT NULL, oil_consumption INT NOT NULL, training_time INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE coordinate (id INT AUTO_INCREMENT NOT NULL, longitude INT NOT NULL, latitude INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, recipient_id INT NOT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, INDEX IDX_B6BD307FF675F31B (author_id), INDEX IDX_B6BD307FE92F8F78 (recipient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE search_technology (id INT AUTO_INCREMENT NOT NULL, technology_id INT DEFAULT NULL, user_id INT DEFAULT NULL, level_technology INT NOT NULL, INDEX IDX_2CD562874235D463 (technology_id), INDEX IDX_2CD56287A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE technology (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, picture VARCHAR(255) NOT NULL, wood_cost INT NOT NULL, stone_cost INT NOT NULL, metal_cost INT NOT NULL, search_time INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE training_machine (id INT AUTO_INCREMENT NOT NULL, machine_id INT NOT NULL, isle_id INT NOT NULL, INDEX IDX_C83B4F8AF6B75B26 (machine_id), INDEX IDX_C83B4F8AC7CE2878 (isle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE training_unit (id INT AUTO_INCREMENT NOT NULL, unit_id INT NOT NULL, isle_id INT NOT NULL, INDEX IDX_D3214B10F8BD700D (unit_id), INDEX IDX_D3214B10C7CE2878 (isle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE unit (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, picture VARCHAR(255) NOT NULL, damage INT NOT NULL, health INT NOT NULL, wood_cost INT NOT NULL, stone_cost INT NOT NULL, metal_cost INT NOT NULL, food_consumption INT NOT NULL, training_time INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, evolution_id INT NOT NULL, username VARCHAR(50) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, record_date DATETIME NOT NULL, last_connection DATETIME NOT NULL, status TINYINT(1) NOT NULL, grade VARCHAR(255) NOT NULL, birth_date DATE NOT NULL, town VARCHAR(255) DEFAULT NULL, adress_ip VARCHAR(255) DEFAULT NULL, INDEX IDX_8D93D649CDFF215A (evolution_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE build_building ADD CONSTRAINT FK_54C3BA24D2A7E12 FOREIGN KEY (building_id) REFERENCES building (id)');
        $this->addSql('ALTER TABLE build_building ADD CONSTRAINT FK_54C3BA2C7CE2878 FOREIGN KEY (isle_id) REFERENCES isle (id)');
        $this->addSql('ALTER TABLE build_defense ADD CONSTRAINT FK_F63088F9FB0C2DCF FOREIGN KEY (defense_id) REFERENCES defense (id)');
        $this->addSql('ALTER TABLE build_defense ADD CONSTRAINT FK_F63088F9C7CE2878 FOREIGN KEY (isle_id) REFERENCES isle (id)');
        $this->addSql('ALTER TABLE isle ADD CONSTRAINT FK_C54D00E0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE isle ADD CONSTRAINT FK_C54D00E053C55F64 FOREIGN KEY (map_id) REFERENCES coordinate (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FE92F8F78 FOREIGN KEY (recipient_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE search_technology ADD CONSTRAINT FK_2CD562874235D463 FOREIGN KEY (technology_id) REFERENCES technology (id)');
        $this->addSql('ALTER TABLE search_technology ADD CONSTRAINT FK_2CD56287A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE training_machine ADD CONSTRAINT FK_C83B4F8AF6B75B26 FOREIGN KEY (machine_id) REFERENCES machine (id)');
        $this->addSql('ALTER TABLE training_machine ADD CONSTRAINT FK_C83B4F8AC7CE2878 FOREIGN KEY (isle_id) REFERENCES isle (id)');
        $this->addSql('ALTER TABLE training_unit ADD CONSTRAINT FK_D3214B10F8BD700D FOREIGN KEY (unit_id) REFERENCES unit (id)');
        $this->addSql('ALTER TABLE training_unit ADD CONSTRAINT FK_D3214B10C7CE2878 FOREIGN KEY (isle_id) REFERENCES isle (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649CDFF215A FOREIGN KEY (evolution_id) REFERENCES evolution (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE build_building DROP FOREIGN KEY FK_54C3BA24D2A7E12');
        $this->addSql('ALTER TABLE build_defense DROP FOREIGN KEY FK_F63088F9FB0C2DCF');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649CDFF215A');
        $this->addSql('ALTER TABLE build_building DROP FOREIGN KEY FK_54C3BA2C7CE2878');
        $this->addSql('ALTER TABLE build_defense DROP FOREIGN KEY FK_F63088F9C7CE2878');
        $this->addSql('ALTER TABLE training_machine DROP FOREIGN KEY FK_C83B4F8AC7CE2878');
        $this->addSql('ALTER TABLE training_unit DROP FOREIGN KEY FK_D3214B10C7CE2878');
        $this->addSql('ALTER TABLE training_machine DROP FOREIGN KEY FK_C83B4F8AF6B75B26');
        $this->addSql('ALTER TABLE isle DROP FOREIGN KEY FK_C54D00E053C55F64');
        $this->addSql('ALTER TABLE search_technology DROP FOREIGN KEY FK_2CD562874235D463');
        $this->addSql('ALTER TABLE training_unit DROP FOREIGN KEY FK_D3214B10F8BD700D');
        $this->addSql('ALTER TABLE isle DROP FOREIGN KEY FK_C54D00E0A76ED395');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FF675F31B');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FE92F8F78');
        $this->addSql('ALTER TABLE search_technology DROP FOREIGN KEY FK_2CD56287A76ED395');
        $this->addSql('DROP TABLE build_building');
        $this->addSql('DROP TABLE build_defense');
        $this->addSql('DROP TABLE building');
        $this->addSql('DROP TABLE defense');
        $this->addSql('DROP TABLE evolution');
        $this->addSql('DROP TABLE isle');
        $this->addSql('DROP TABLE machine');
        $this->addSql('DROP TABLE coordinate');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE search_technology');
        $this->addSql('DROP TABLE technology');
        $this->addSql('DROP TABLE training_machine');
        $this->addSql('DROP TABLE training_unit');
        $this->addSql('DROP TABLE unit');
        $this->addSql('DROP TABLE user');
    }
}
