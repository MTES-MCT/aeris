<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180502142504 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE declaration_dioxines_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE declaration_dioxines (id INT NOT NULL, incinerateur_id INT DEFAULT NULL, createdAt TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, comment TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_399A6C767C7923EC ON declaration_dioxines (incinerateur_id)');
        $this->addSql('ALTER TABLE declaration_dioxines ADD CONSTRAINT FK_399A6C767C7923EC FOREIGN KEY (incinerateur_id) REFERENCES incinerateur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE mesure_dioxine DROP CONSTRAINT fk_29e44fb3e14d3bb1');
        $this->addSql('DROP INDEX idx_29e44fb3e14d3bb1');
        $this->addSql('UPDATE mesure_dioxine SET declaration_incinerateur_id=NULL');
        $this->addSql('ALTER TABLE mesure_dioxine RENAME COLUMN declaration_incinerateur_id TO declaration_dioxine_id');
        $this->addSql('ALTER TABLE mesure_dioxine ADD CONSTRAINT FK_29E44FB3B30F124D FOREIGN KEY (declaration_dioxine_id) REFERENCES declaration_dioxines (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_29E44FB3B30F124D ON mesure_dioxine (declaration_dioxine_id)');
        // $this->addSql('ALTER TABLE incinerateur DROP CONSTRAINT fk_bec9251bb7728aa0');
        //$this->addSql('DROP INDEX idx_bec9251bb7728aa0');
        //$this->addSql('ALTER TABLE incinerateur DROP inspecteur_id');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE mesure_dioxine DROP CONSTRAINT FK_29E44FB3B30F124D');
        $this->addSql('DROP SEQUENCE declaration_dioxines_id_seq CASCADE');
        $this->addSql('DROP TABLE declaration_dioxines');
        $this->addSql('DROP INDEX IDX_29E44FB3B30F124D');
        $this->addSql('ALTER TABLE mesure_dioxine RENAME COLUMN declaration_dioxine_id TO declaration_incinerateur_id');
        $this->addSql('ALTER TABLE mesure_dioxine ADD CONSTRAINT fk_29e44fb3e14d3bb1 FOREIGN KEY (declaration_incinerateur_id) REFERENCES declaration_incinerateur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_29e44fb3e14d3bb1 ON mesure_dioxine (declaration_incinerateur_id)');
        $this->addSql('ALTER TABLE incinerateur ADD inspecteur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE incinerateur ADD CONSTRAINT fk_bec9251bb7728aa0 FOREIGN KEY (inspecteur_id) REFERENCES fos_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_bec9251bb7728aa0 ON incinerateur (inspecteur_id)');
    }
}
