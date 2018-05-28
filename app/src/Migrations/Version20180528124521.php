<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180528124521 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE mesure_compteur_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE mesure_compteur (id INT NOT NULL, declaration_fonctionnement_ligne_id INT DEFAULT NULL, value INT NOT NULL, type VARCHAR(32) NOT NULL, component VARCHAR(32) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_CE015DFF9779828 ON mesure_compteur (declaration_fonctionnement_ligne_id)');
        $this->addSql('ALTER TABLE mesure_compteur ADD CONSTRAINT FK_CE015DFF9779828 FOREIGN KEY (declaration_fonctionnement_ligne_id) REFERENCES declaration_fonctionnement_ligne (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE mesure_compteur_id_seq CASCADE');
        $this->addSql('DROP TABLE mesure_compteur');
        $this->addSql('ALTER TABLE mesure ALTER value TYPE NUMERIC(20, 10)');
    }
}
