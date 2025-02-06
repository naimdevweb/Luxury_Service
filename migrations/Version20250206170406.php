<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250206170406 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE candidat ADD experience_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE candidat ADD CONSTRAINT FK_6AB5B47146E90E27 FOREIGN KEY (experience_id) REFERENCES experience_professionel (id)');
        $this->addSql('CREATE INDEX IDX_6AB5B47146E90E27 ON candidat (experience_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE candidat DROP FOREIGN KEY FK_6AB5B47146E90E27');
        $this->addSql('DROP INDEX IDX_6AB5B47146E90E27 ON candidat');
        $this->addSql('ALTER TABLE candidat DROP experience_id');
    }
}
