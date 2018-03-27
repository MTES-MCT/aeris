<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180327130909 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE declaration_incinerateur_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE declaration_incinerateur (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE incinerateur ADD owner_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE incinerateur ADD CONSTRAINT FK_BEC9251B7E3C61F9 FOREIGN KEY (owner_id) REFERENCES fos_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_BEC9251B7E3C61F9 ON incinerateur (owner_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE declaration_incinerateur_id_seq CASCADE');
        $this->addSql('DROP TABLE declaration_incinerateur');
        $this->addSql('ALTER TABLE incinerateur DROP CONSTRAINT FK_BEC9251B7E3C61F9');
        $this->addSql('DROP INDEX IDX_BEC9251B7E3C61F9');
        $this->addSql('ALTER TABLE incinerateur DROP owner_id');
    }
}
