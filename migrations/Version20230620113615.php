<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230620113615 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE arome (id INT AUTO_INCREMENT NOT NULL, name_arome VARCHAR(100) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE color (id INT AUTO_INCREMENT NOT NULL, name_color VARCHAR(20) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gout (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_C11EA42DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gout_color (gout_id INT NOT NULL, color_id INT NOT NULL, INDEX IDX_F250571066B054CC (gout_id), INDEX IDX_F25057107ADA1FB5 (color_id), PRIMARY KEY(gout_id, color_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gout_arome (gout_id INT NOT NULL, arome_id INT NOT NULL, INDEX IDX_9940D22E66B054CC (gout_id), INDEX IDX_9940D22EF6CAB2E (arome_id), PRIMARY KEY(gout_id, arome_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gout_region (gout_id INT NOT NULL, region_id INT NOT NULL, INDEX IDX_CB97BDD166B054CC (gout_id), INDEX IDX_CB97BDD198260155 (region_id), PRIMARY KEY(gout_id, region_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE region (id INT AUTO_INCREMENT NOT NULL, name_region VARCHAR(100) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(50) NOT NULL, lastname VARCHAR(50) NOT NULL, birthday DATE NOT NULL, zipcode INT DEFAULT NULL, phone_number VARCHAR(20) DEFAULT NULL, is_verified TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE gout ADD CONSTRAINT FK_C11EA42DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE gout_color ADD CONSTRAINT FK_F250571066B054CC FOREIGN KEY (gout_id) REFERENCES gout (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE gout_color ADD CONSTRAINT FK_F25057107ADA1FB5 FOREIGN KEY (color_id) REFERENCES color (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE gout_arome ADD CONSTRAINT FK_9940D22E66B054CC FOREIGN KEY (gout_id) REFERENCES gout (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE gout_arome ADD CONSTRAINT FK_9940D22EF6CAB2E FOREIGN KEY (arome_id) REFERENCES arome (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE gout_region ADD CONSTRAINT FK_CB97BDD166B054CC FOREIGN KEY (gout_id) REFERENCES gout (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE gout_region ADD CONSTRAINT FK_CB97BDD198260155 FOREIGN KEY (region_id) REFERENCES region (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gout DROP FOREIGN KEY FK_C11EA42DA76ED395');
        $this->addSql('ALTER TABLE gout_color DROP FOREIGN KEY FK_F250571066B054CC');
        $this->addSql('ALTER TABLE gout_color DROP FOREIGN KEY FK_F25057107ADA1FB5');
        $this->addSql('ALTER TABLE gout_arome DROP FOREIGN KEY FK_9940D22E66B054CC');
        $this->addSql('ALTER TABLE gout_arome DROP FOREIGN KEY FK_9940D22EF6CAB2E');
        $this->addSql('ALTER TABLE gout_region DROP FOREIGN KEY FK_CB97BDD166B054CC');
        $this->addSql('ALTER TABLE gout_region DROP FOREIGN KEY FK_CB97BDD198260155');
        $this->addSql('DROP TABLE arome');
        $this->addSql('DROP TABLE color');
        $this->addSql('DROP TABLE gout');
        $this->addSql('DROP TABLE gout_color');
        $this->addSql('DROP TABLE gout_arome');
        $this->addSql('DROP TABLE gout_region');
        $this->addSql('DROP TABLE region');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
