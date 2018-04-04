<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180404152236 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE mesure_dioxine ADD ligne_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE mesure_dioxine ADD CONSTRAINT FK_29E44FB35A438E76 FOREIGN KEY (ligne_id) REFERENCES incinerateur_ligne (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_29E44FB35A438E76 ON mesure_dioxine (ligne_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE mesure_dioxine DROP CONSTRAINT FK_29E44FB35A438E76');
        $this->addSql('DROP INDEX IDX_29E44FB35A438E76');
        $this->addSql('ALTER TABLE mesure_dioxine DROP ligne_id');
    }
}
