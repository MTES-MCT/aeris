<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180507142806 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE declaration_fonctionnement_ligne ADD declaration_compteurs_file_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE declaration_fonctionnement_ligne ADD declaration_flux_file_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE declaration_fonctionnement_ligne ADD declaration_concentrations_file_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE declaration_incinerateur DROP declaration_file_name');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE declaration_fonctionnement_ligne DROP declaration_compteurs_file_name');
        $this->addSql('ALTER TABLE declaration_fonctionnement_ligne DROP declaration_flux_file_name');
        $this->addSql('ALTER TABLE declaration_fonctionnement_ligne DROP declaration_concentrations_file_name');
        $this->addSql('ALTER TABLE declaration_incinerateur ADD declaration_file_name VARCHAR(255) DEFAULT NULL');
    }
}
