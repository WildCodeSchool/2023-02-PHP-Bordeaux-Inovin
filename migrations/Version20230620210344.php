<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230620210344 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE arome (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE color (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(20) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE region (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(50) NOT NULL, lastname VARCHAR(50) NOT NULL, birthday DATE NOT NULL, zipcode INT DEFAULT NULL, phone_number VARCHAR(20) DEFAULT NULL, is_verified TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_color (user_id INT NOT NULL, color_id INT NOT NULL, INDEX IDX_8494B3B1A76ED395 (user_id), INDEX IDX_8494B3B17ADA1FB5 (color_id), PRIMARY KEY(user_id, color_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_arome (user_id INT NOT NULL, arome_id INT NOT NULL, INDEX IDX_EF84368FA76ED395 (user_id), INDEX IDX_EF84368FF6CAB2E (arome_id), PRIMARY KEY(user_id, arome_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_region (user_id INT NOT NULL, region_id INT NOT NULL, INDEX IDX_6A30EA4BA76ED395 (user_id), INDEX IDX_6A30EA4B98260155 (region_id), PRIMARY KEY(user_id, region_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_color ADD CONSTRAINT FK_8494B3B1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_color ADD CONSTRAINT FK_8494B3B17ADA1FB5 FOREIGN KEY (color_id) REFERENCES color (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_arome ADD CONSTRAINT FK_EF84368FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_arome ADD CONSTRAINT FK_EF84368FF6CAB2E FOREIGN KEY (arome_id) REFERENCES arome (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_region ADD CONSTRAINT FK_6A30EA4BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_region ADD CONSTRAINT FK_6A30EA4B98260155 FOREIGN KEY (region_id) REFERENCES region (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE user_color DROP FOREIGN KEY FK_8494B3B1A76ED395');
        $this->addSql('ALTER TABLE user_color DROP FOREIGN KEY FK_8494B3B17ADA1FB5');
        $this->addSql('ALTER TABLE user_arome DROP FOREIGN KEY FK_EF84368FA76ED395');
        $this->addSql('ALTER TABLE user_arome DROP FOREIGN KEY FK_EF84368FF6CAB2E');
        $this->addSql('ALTER TABLE user_region DROP FOREIGN KEY FK_6A30EA4BA76ED395');
        $this->addSql('ALTER TABLE user_region DROP FOREIGN KEY FK_6A30EA4B98260155');
        $this->addSql('DROP TABLE arome');
        $this->addSql('DROP TABLE color');
        $this->addSql('DROP TABLE region');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_color');
        $this->addSql('DROP TABLE user_arome');
        $this->addSql('DROP TABLE user_region');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
