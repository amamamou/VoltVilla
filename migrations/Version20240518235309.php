<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240518235309 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE intervention DROP FOREIGN KEY FK_D11814AB61BB3550');
        $this->addSql('DROP INDEX IDX_D11814AB61BB3550 ON intervention');
        $this->addSql('ALTER TABLE intervention CHANGE code_clt_id user_id INT DEFAULT NULL, CHANGE note_utilisateur note DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE intervention ADD CONSTRAINT FK_D11814ABA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_D11814ABA76ED395 ON intervention (user_id)');
        $this->addSql('ALTER TABLE user DROP cp');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE intervention DROP FOREIGN KEY FK_D11814ABA76ED395');
        $this->addSql('DROP INDEX IDX_D11814ABA76ED395 ON intervention');
        $this->addSql('ALTER TABLE intervention CHANGE user_id code_clt_id INT DEFAULT NULL, CHANGE note note_utilisateur DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE intervention ADD CONSTRAINT FK_D11814AB61BB3550 FOREIGN KEY (code_clt_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_D11814AB61BB3550 ON intervention (code_clt_id)');
        $this->addSql('ALTER TABLE `user` ADD cp INT NOT NULL');
    }
}
