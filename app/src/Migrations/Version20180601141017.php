<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180601141017 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE declaration_dechets ALTER qtite_incineree_totale TYPE NUMERIC NUMERIC(20, 10)');
        $this->addSql('ALTER TABLE declaration_dechets ALTER qtite_incineree_totale DROP DEFAULT');
        $this->addSql('ALTER TABLE declaration_dechets ALTER qtite_incineree_dechets_dangereux TYPE NUMERIC NUMERIC(20, 10)');
        $this->addSql('ALTER TABLE declaration_dechets ALTER qtite_incineree_dechets_dangereux DROP DEFAULT');
        $this->addSql('ALTER TABLE declaration_dechets ALTER qtite_incineree_dechets_dasri TYPE NUMERIC NUMERIC(20, 10)');
        $this->addSql('ALTER TABLE declaration_dechets ALTER qtite_incineree_dechets_dasri DROP DEFAULT');
        $this->addSql('ALTER TABLE declaration_dechets ALTER qtite_incineree_dechets_non_dangereux TYPE NUMERIC NUMERIC(20, 10)');
        $this->addSql('ALTER TABLE declaration_dechets ALTER qtite_incineree_dechets_non_dangereux DROP DEFAULT');
        $this->addSql('ALTER TABLE declaration_dechets ALTER qtite_incineree_dechets_non_dangereux_menagers TYPE NUMERIC NUMERIC(20, 10)');
        $this->addSql('ALTER TABLE declaration_dechets ALTER qtite_incineree_dechets_non_dangereux_menagers DROP DEFAULT');
        $this->addSql('ALTER TABLE declaration_dechets ALTER qtite_incineree_dechets_non_dangereux_refus_tri TYPE NUMERIC NUMERIC(20, 10)');
        $this->addSql('ALTER TABLE declaration_dechets ALTER qtite_incineree_dechets_non_dangereux_refus_tri DROP DEFAULT');
        $this->addSql('ALTER TABLE declaration_dechets ALTER qtite_incineree_dechets_non_dangereux_dae TYPE NUMERIC NUMERIC(20, 10)');
        $this->addSql('ALTER TABLE declaration_dechets ALTER qtite_incineree_dechets_non_dangereux_dae DROP DEFAULT');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE declaration_dechets ALTER qtite_incineree_totale TYPE INT');
        $this->addSql('ALTER TABLE declaration_dechets ALTER qtite_incineree_totale DROP DEFAULT');
        $this->addSql('ALTER TABLE declaration_dechets ALTER qtite_incineree_dechets_dangereux TYPE INT');
        $this->addSql('ALTER TABLE declaration_dechets ALTER qtite_incineree_dechets_dangereux DROP DEFAULT');
        $this->addSql('ALTER TABLE declaration_dechets ALTER qtite_incineree_dechets_dasri TYPE INT');
        $this->addSql('ALTER TABLE declaration_dechets ALTER qtite_incineree_dechets_dasri DROP DEFAULT');
        $this->addSql('ALTER TABLE declaration_dechets ALTER qtite_incineree_dechets_non_dangereux TYPE INT');
        $this->addSql('ALTER TABLE declaration_dechets ALTER qtite_incineree_dechets_non_dangereux DROP DEFAULT');
        $this->addSql('ALTER TABLE declaration_dechets ALTER qtite_incineree_dechets_non_dangereux_menagers TYPE INT');
        $this->addSql('ALTER TABLE declaration_dechets ALTER qtite_incineree_dechets_non_dangereux_menagers DROP DEFAULT');
        $this->addSql('ALTER TABLE declaration_dechets ALTER qtite_incineree_dechets_non_dangereux_refus_tri TYPE INT');
        $this->addSql('ALTER TABLE declaration_dechets ALTER qtite_incineree_dechets_non_dangereux_refus_tri DROP DEFAULT');
        $this->addSql('ALTER TABLE declaration_dechets ALTER qtite_incineree_dechets_non_dangereux_dae TYPE INT');
        $this->addSql('ALTER TABLE declaration_dechets ALTER qtite_incineree_dechets_non_dangereux_dae DROP DEFAULT');
    }
}
