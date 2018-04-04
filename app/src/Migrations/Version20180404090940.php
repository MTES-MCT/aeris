<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180404090940 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE mesure_dioxine ADD declaration_incinerateur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE mesure_dioxine ADD CONSTRAINT FK_29E44FB3E14D3BB1 FOREIGN KEY (declaration_incinerateur_id) REFERENCES declaration_incinerateur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_29E44FB3E14D3BB1 ON mesure_dioxine (declaration_incinerateur_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE mesure_dioxine DROP CONSTRAINT FK_29E44FB3E14D3BB1');
        $this->addSql('DROP INDEX IDX_29E44FB3E14D3BB1');
        $this->addSql('ALTER TABLE mesure_dioxine DROP declaration_incinerateur_id');
    }
}
