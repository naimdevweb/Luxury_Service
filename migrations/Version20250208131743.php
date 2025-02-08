<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250208131743 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE offre_emploi (id INT AUTO_INCREMENT NOT NULL, categorie_id INT NOT NULL, client_id INT NOT NULL, localisation VARCHAR(255) NOT NULL, titre VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, salaire BIGINT NOT NULL, note LONGTEXT NOT NULL, active TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_132AD0D1BCF5E72D (categorie_id), INDEX IDX_132AD0D119EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE offre_emploi ADD CONSTRAINT FK_132AD0D1BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE offre_emploi ADD CONSTRAINT FK_132AD0D119EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE offre_emploi DROP FOREIGN KEY FK_132AD0D1BCF5E72D');
        $this->addSql('ALTER TABLE offre_emploi DROP FOREIGN KEY FK_132AD0D119EB6921');
        $this->addSql('DROP TABLE offre_emploi');
    }
}
