<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240514222954 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE intervention (id INT AUTO_INCREMENT NOT NULL, code_clt_id INT DEFAULT NULL, code_tech_id INT DEFAULT NULL, date_interv DATE NOT NULL, INDEX IDX_D11814AB61BB3550 (code_clt_id), INDEX IDX_D11814AB5CD53F60 (code_tech_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE intervention_produit (intervention_id INT NOT NULL, produit_id INT NOT NULL, INDEX IDX_624B98428EAE3863 (intervention_id), INDEX IDX_624B9842F347EFB (produit_id), PRIMARY KEY(intervention_id, produit_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, designation VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE technecien (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE intervention ADD CONSTRAINT FK_D11814AB61BB3550 FOREIGN KEY (code_clt_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE intervention ADD CONSTRAINT FK_D11814AB5CD53F60 FOREIGN KEY (code_tech_id) REFERENCES technecien (id)');
        $this->addSql('ALTER TABLE intervention_produit ADD CONSTRAINT FK_624B98428EAE3863 FOREIGN KEY (intervention_id) REFERENCES intervention (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE intervention_produit ADD CONSTRAINT FK_624B9842F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE intervention DROP FOREIGN KEY FK_D11814AB61BB3550');
        $this->addSql('ALTER TABLE intervention DROP FOREIGN KEY FK_D11814AB5CD53F60');
        $this->addSql('ALTER TABLE intervention_produit DROP FOREIGN KEY FK_624B98428EAE3863');
        $this->addSql('ALTER TABLE intervention_produit DROP FOREIGN KEY FK_624B9842F347EFB');
        $this->addSql('DROP TABLE intervention');
        $this->addSql('DROP TABLE intervention_produit');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE technecien');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
