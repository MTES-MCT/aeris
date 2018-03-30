<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180330142634 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE declaration_fonctionnement_ligne_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE mesure_dioxine_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE declaration_dechets_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE declaration_fonctionnement_ligne (id INT NOT NULL, nb_heures_fonctionnement_th NUMERIC(10, 0) NOT NULL, nb_heures_fonctionnement_reel NUMERIC(10, 0) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE mesure_dioxine (id INT NOT NULL, numero_ligne INT NOT NULL, dateDebut DATE NOT NULL, dateFin DATE NOT NULL, disponibilite_ligne NUMERIC(10, 0) NOT NULL, disponibilite_analyseur NUMERIC(10, 0) NOT NULL, nom_laboratoire TEXT NOT NULL, concentration NUMERIC(10, 0) NOT NULL, commentaire TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE declaration_dechets (id INT NOT NULL, declaration_incinerateur_id INT DEFAULT NULL, qtite_incineree_totale INT NOT NULL, qtite_incineree_dechets_dangereux INT NOT NULL, qtite_incineree_dechets_dasri INT NOT NULL, qtite_incineree_dechets_non_dangereux INT NOT NULL, qtite_incineree_dechets_non_dangereux_menagers INT NOT NULL, qtite_incineree_dechets_non_dangereux_refus_tri INT NOT NULL, qtite_incineree_dechets_non_dangereux_dae INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_397D08BDE14D3BB1 ON declaration_dechets (declaration_incinerateur_id)');
        $this->addSql('ALTER TABLE declaration_dechets ADD CONSTRAINT FK_397D08BDE14D3BB1 FOREIGN KEY (declaration_incinerateur_id) REFERENCES declaration_incinerateur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE declaration_fonctionnement_ligne_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE mesure_dioxine_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE declaration_dechets_id_seq CASCADE');
        $this->addSql('DROP TABLE declaration_fonctionnement_ligne');
        $this->addSql('DROP TABLE mesure_dioxine');
        $this->addSql('DROP TABLE declaration_dechets');
    }
}
