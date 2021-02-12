<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201125075638 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE archive (id INT AUTO_INCREMENT NOT NULL, teacher_id INT NOT NULL, justification VARCHAR(255) NOT NULL, comment LONGTEXT DEFAULT NULL, archived_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_D5FC5D9C41807E1D (teacher_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE city (id INT AUTO_INCREMENT NOT NULL, legation_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_2D5B02344C83E04B (legation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE legation (id INT AUTO_INCREMENT NOT NULL, region_id INT NOT NULL, name VARCHAR(255) NOT NULL, phone VARCHAR(255) DEFAULT NULL, address LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, email VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_617F94935E237E06 (name), INDEX IDX_617F949398260155 (region_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mission (id INT AUTO_INCREMENT NOT NULL, school_id INT NOT NULL, teacher_id INT NOT NULL, city_id INT NOT NULL, new_month INT NOT NULL, new_day INT NOT NULL, start_at DATE NOT NULL, end_at DATE DEFAULT NULL, type TINYINT(1) NOT NULL, INDEX IDX_9067F23CC32A47EE (school_id), INDEX IDX_9067F23C41807E1D (teacher_id), INDEX IDX_9067F23C8BAC62AF (city_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offer (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, month_nbr INT NOT NULL, price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE region (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE school (id INT AUTO_INCREMENT NOT NULL, legation_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_F99EDABB4C83E04B (legation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subscription (id INT AUTO_INCREMENT NOT NULL, legation_id INT NOT NULL, offer_id INT NOT NULL, start_at DATE NOT NULL, end_at DATE NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_A3C664D34C83E04B (legation_id), INDEX IDX_A3C664D353C674EE (offer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE teacher (id INT AUTO_INCREMENT NOT NULL, legation_id INT NOT NULL, city_id INT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, cin VARCHAR(255) NOT NULL, birthday DATE NOT NULL, phone VARCHAR(255) NOT NULL, address LONGTEXT DEFAULT NULL, diploma_at VARCHAR(255) NOT NULL, init_month INT NOT NULL, init_day INT DEFAULT NULL, created_at DATETIME NOT NULL, comment LONGTEXT DEFAULT NULL, archived TINYINT(1) NOT NULL, ord INT NOT NULL, p_id VARCHAR(255) DEFAULT NULL, bank_id INT DEFAULT NULL, INDEX IDX_B0F6A6D54C83E04B (legation_id), INDEX IDX_B0F6A6D58BAC62AF (city_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, legation_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, full_name VARCHAR(255) NOT NULL, registered_at DATETIME NOT NULL, enabled TINYINT(1) NOT NULL, mobile VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D6494C83E04B (legation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE archive ADD CONSTRAINT FK_D5FC5D9C41807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id)');
        $this->addSql('ALTER TABLE city ADD CONSTRAINT FK_2D5B02344C83E04B FOREIGN KEY (legation_id) REFERENCES legation (id)');
        $this->addSql('ALTER TABLE legation ADD CONSTRAINT FK_617F949398260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23CC32A47EE FOREIGN KEY (school_id) REFERENCES school (id)');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23C41807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id)');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23C8BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE school ADD CONSTRAINT FK_F99EDABB4C83E04B FOREIGN KEY (legation_id) REFERENCES legation (id)');
        $this->addSql('ALTER TABLE subscription ADD CONSTRAINT FK_A3C664D34C83E04B FOREIGN KEY (legation_id) REFERENCES legation (id)');
        $this->addSql('ALTER TABLE subscription ADD CONSTRAINT FK_A3C664D353C674EE FOREIGN KEY (offer_id) REFERENCES offer (id)');
        $this->addSql('ALTER TABLE teacher ADD CONSTRAINT FK_B0F6A6D54C83E04B FOREIGN KEY (legation_id) REFERENCES legation (id)');
        $this->addSql('ALTER TABLE teacher ADD CONSTRAINT FK_B0F6A6D58BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D6494C83E04B FOREIGN KEY (legation_id) REFERENCES legation (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23C8BAC62AF');
        $this->addSql('ALTER TABLE teacher DROP FOREIGN KEY FK_B0F6A6D58BAC62AF');
        $this->addSql('ALTER TABLE city DROP FOREIGN KEY FK_2D5B02344C83E04B');
        $this->addSql('ALTER TABLE school DROP FOREIGN KEY FK_F99EDABB4C83E04B');
        $this->addSql('ALTER TABLE subscription DROP FOREIGN KEY FK_A3C664D34C83E04B');
        $this->addSql('ALTER TABLE teacher DROP FOREIGN KEY FK_B0F6A6D54C83E04B');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D6494C83E04B');
        $this->addSql('ALTER TABLE subscription DROP FOREIGN KEY FK_A3C664D353C674EE');
        $this->addSql('ALTER TABLE legation DROP FOREIGN KEY FK_617F949398260155');
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23CC32A47EE');
        $this->addSql('ALTER TABLE archive DROP FOREIGN KEY FK_D5FC5D9C41807E1D');
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23C41807E1D');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('DROP TABLE archive');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE legation');
        $this->addSql('DROP TABLE mission');
        $this->addSql('DROP TABLE offer');
        $this->addSql('DROP TABLE region');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE school');
        $this->addSql('DROP TABLE subscription');
        $this->addSql('DROP TABLE teacher');
        $this->addSql('DROP TABLE `user`');
    }
}
