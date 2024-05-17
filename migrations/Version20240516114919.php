<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240516114919 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reclamation ADD code_clt_id INT NOT NULL, ADD reference_pd_id INT NOT NULL, DROP code_clt, DROP reference_pd');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE60640461BB3550 FOREIGN KEY (code_clt_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404C4150BB4 FOREIGN KEY (reference_pd_id) REFERENCES produit (id)');
        $this->addSql('CREATE INDEX IDX_CE60640461BB3550 ON reclamation (code_clt_id)');
        $this->addSql('CREATE INDEX IDX_CE606404C4150BB4 ON reclamation (reference_pd_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE60640461BB3550');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE606404C4150BB4');
        $this->addSql('DROP INDEX IDX_CE60640461BB3550 ON reclamation');
        $this->addSql('DROP INDEX IDX_CE606404C4150BB4 ON reclamation');
        $this->addSql('ALTER TABLE reclamation ADD code_clt INT NOT NULL, ADD reference_pd INT NOT NULL, DROP code_clt_id, DROP reference_pd_id');
    }
}
