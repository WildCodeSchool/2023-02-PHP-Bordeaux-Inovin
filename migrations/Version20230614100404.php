<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230614100404 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE arome ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE color ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE region ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE user ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE arome DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE color DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE region DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE user DROP created_at, DROP updated_at');
    }
}
