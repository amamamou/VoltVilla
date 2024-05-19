<?php
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240519011031 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // Add necessary migration statements here
        $this->addSql('ALTER TABLE reclamation ADD intervention_id INT NOT NULL');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE6064048EAE3863 FOREIGN KEY (intervention_id) REFERENCES intervention (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CE6064048EAE3863 ON reclamation (intervention_id)');
    }

    public function down(Schema $schema): void
    {
        // Add necessary migration statements here to revert the changes made in the "up" method
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE6064048EAE3863');
        $this->addSql('DROP INDEX UNIQ_CE6064048EAE3863 ON reclamation');
        $this->addSql('ALTER TABLE reclamation DROP intervention_id');
    }
}
