<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230614094334 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE arome (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE color (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE region (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_color (user_id INT NOT NULL, color_id INT NOT NULL, INDEX IDX_8494B3B1A76ED395 (user_id), INDEX IDX_8494B3B17ADA1FB5 (color_id), PRIMARY KEY(user_id, color_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_arome (user_id INT NOT NULL, arome_id INT NOT NULL, INDEX IDX_EF84368FA76ED395 (user_id), INDEX IDX_EF84368FF6CAB2E (arome_id), PRIMARY KEY(user_id, arome_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_region (user_id INT NOT NULL, region_id INT NOT NULL, INDEX IDX_6A30EA4BA76ED395 (user_id), INDEX IDX_6A30EA4B98260155 (region_id), PRIMARY KEY(user_id, region_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_color ADD CONSTRAINT FK_8494B3B1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_color ADD CONSTRAINT FK_8494B3B17ADA1FB5 FOREIGN KEY (color_id) REFERENCES color (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_arome ADD CONSTRAINT FK_EF84368FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_arome ADD CONSTRAINT FK_EF84368FF6CAB2E FOREIGN KEY (arome_id) REFERENCES arome (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_region ADD CONSTRAINT FK_6A30EA4BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_region ADD CONSTRAINT FK_6A30EA4B98260155 FOREIGN KEY (region_id) REFERENCES region (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_color DROP FOREIGN KEY FK_8494B3B1A76ED395');
        $this->addSql('ALTER TABLE user_color DROP FOREIGN KEY FK_8494B3B17ADA1FB5');
        $this->addSql('ALTER TABLE user_arome DROP FOREIGN KEY FK_EF84368FA76ED395');
        $this->addSql('ALTER TABLE user_arome DROP FOREIGN KEY FK_EF84368FF6CAB2E');
        $this->addSql('ALTER TABLE user_region DROP FOREIGN KEY FK_6A30EA4BA76ED395');
        $this->addSql('ALTER TABLE user_region DROP FOREIGN KEY FK_6A30EA4B98260155');
        $this->addSql('DROP TABLE arome');
        $this->addSql('DROP TABLE color');
        $this->addSql('DROP TABLE region');
        $this->addSql('DROP TABLE user_color');
        $this->addSql('DROP TABLE user_arome');
        $this->addSql('DROP TABLE user_region');
    }
}
