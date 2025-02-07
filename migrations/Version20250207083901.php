<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250207083901 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE candidat ADD fichiers_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE candidat ADD CONSTRAINT FK_6AB5B471BD7BF362 FOREIGN KEY (fichiers_id) REFERENCES fichiers (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6AB5B471BD7BF362 ON candidat (fichiers_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE candidat DROP FOREIGN KEY FK_6AB5B471BD7BF362');
        $this->addSql('DROP INDEX UNIQ_6AB5B471BD7BF362 ON candidat');
        $this->addSql('ALTER TABLE candidat DROP fichiers_id');
    }
}
