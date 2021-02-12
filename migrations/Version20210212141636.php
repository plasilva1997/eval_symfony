<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210212141636 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categorie DROP FOREIGN KEY FK_497DD634567F5183');
        $this->addSql('DROP INDEX IDX_497DD634567F5183 ON categorie');
        $this->addSql('ALTER TABLE categorie DROP film_id');
        $this->addSql('ALTER TABLE film ADD categorie_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE film ADD CONSTRAINT FK_8244BE228A3C7387 FOREIGN KEY (categorie_id_id) REFERENCES categorie (id)');
        $this->addSql('CREATE INDEX IDX_8244BE228A3C7387 ON film (categorie_id_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categorie ADD film_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE categorie ADD CONSTRAINT FK_497DD634567F5183 FOREIGN KEY (film_id) REFERENCES film (id)');
        $this->addSql('CREATE INDEX IDX_497DD634567F5183 ON categorie (film_id)');
        $this->addSql('ALTER TABLE film DROP FOREIGN KEY FK_8244BE228A3C7387');
        $this->addSql('DROP INDEX IDX_8244BE228A3C7387 ON film');
        $this->addSql('ALTER TABLE film DROP categorie_id_id');
    }
}
