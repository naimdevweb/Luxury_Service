<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250207095631 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE candidat ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD deleted_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE fichiers CHANGE chemin_photo chemin_photo VARCHAR(255) DEFAULT NULL, CHANGE chemin_cv chemin_cv VARCHAR(255) DEFAULT NULL, CHANGE chemin_passeport chemin_passeport VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE candidat DROP created_at, DROP updated_at, DROP deleted_at');
        $this->addSql('ALTER TABLE fichiers CHANGE chemin_photo chemin_photo VARCHAR(255) NOT NULL, CHANGE chemin_cv chemin_cv VARCHAR(255) NOT NULL, CHANGE chemin_passeport chemin_passeport VARCHAR(255) NOT NULL');
    }
}
