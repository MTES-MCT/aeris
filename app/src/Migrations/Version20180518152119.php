<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180518152119 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE mesure_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE mesure (id INT NOT NULL, ligne_id INT DEFAULT NULL, declaration_fonctionnement_ligne_id INT DEFAULT NULL, date DATE NOT NULL, value NUMERIC(10, 0) NOT NULL, type VARCHAR(32) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5F1B6E705A438E76 ON mesure (ligne_id)');
        $this->addSql('CREATE INDEX IDX_5F1B6E709779828 ON mesure (declaration_fonctionnement_ligne_id)');
        $this->addSql('ALTER TABLE mesure ADD CONSTRAINT FK_5F1B6E705A438E76 FOREIGN KEY (ligne_id) REFERENCES incinerateur_ligne (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE mesure ADD CONSTRAINT FK_5F1B6E709779828 FOREIGN KEY (declaration_fonctionnement_ligne_id) REFERENCES declaration_fonctionnement_ligne (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE declaration_fonctionnement_ligne ALTER nb_heures_fonctionnement_th DROP NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE mesure_id_seq CASCADE');
        $this->addSql('DROP TABLE mesure');
        $this->addSql('ALTER TABLE declaration_fonctionnement_ligne ALTER nb_heures_fonctionnement_th SET NOT NULL');
    }
}
