<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180328090910 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE declaration_incinerateur ADD incinerateur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE declaration_incinerateur ADD creationDate TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE declaration_incinerateur ADD CONSTRAINT FK_A65652D07C7923EC FOREIGN KEY (incinerateur_id) REFERENCES incinerateur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_A65652D07C7923EC ON declaration_incinerateur (incinerateur_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE declaration_incinerateur DROP CONSTRAINT FK_A65652D07C7923EC');
        $this->addSql('DROP INDEX IDX_A65652D07C7923EC');
        $this->addSql('ALTER TABLE declaration_incinerateur DROP incinerateur_id');
        $this->addSql('ALTER TABLE declaration_incinerateur DROP creationDate');
    }
}
