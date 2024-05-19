<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240518001640 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE606404C4150BB4');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404C4150BB4 FOREIGN KEY (reference_pd_id) REFERENCES produit (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE606404C4150BB4');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404C4150BB4 FOREIGN KEY (reference_pd_id) REFERENCES produit (id)');
    }
}
