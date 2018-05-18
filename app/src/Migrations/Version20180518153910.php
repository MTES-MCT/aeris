<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180518153910 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE mesure DROP CONSTRAINT fk_5f1b6e705a438e76');
        $this->addSql('DROP INDEX idx_5f1b6e705a438e76');
        $this->addSql('ALTER TABLE mesure DROP ligne_id');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE mesure ADD ligne_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE mesure ADD CONSTRAINT fk_5f1b6e705a438e76 FOREIGN KEY (ligne_id) REFERENCES incinerateur_ligne (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_5f1b6e705a438e76 ON mesure (ligne_id)');
    }
}
