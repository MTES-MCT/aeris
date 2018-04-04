<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180404095756 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE mesure_dioxine ALTER commentaire DROP NOT NULL');
        $this->addSql('ALTER TABLE declaration_dechets ALTER qtite_incineree_totale DROP NOT NULL');
        $this->addSql('ALTER TABLE declaration_dechets ALTER qtite_incineree_dechets_dangereux DROP NOT NULL');
        $this->addSql('ALTER TABLE declaration_dechets ALTER qtite_incineree_dechets_dasri DROP NOT NULL');
        $this->addSql('ALTER TABLE declaration_dechets ALTER qtite_incineree_dechets_non_dangereux DROP NOT NULL');
        $this->addSql('ALTER TABLE declaration_dechets ALTER qtite_incineree_dechets_non_dangereux_menagers DROP NOT NULL');
        $this->addSql('ALTER TABLE declaration_dechets ALTER qtite_incineree_dechets_non_dangereux_refus_tri DROP NOT NULL');
        $this->addSql('ALTER TABLE declaration_dechets ALTER qtite_incineree_dechets_non_dangereux_dae DROP NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE declaration_dechets ALTER qtite_incineree_totale SET NOT NULL');
        $this->addSql('ALTER TABLE declaration_dechets ALTER qtite_incineree_dechets_dangereux SET NOT NULL');
        $this->addSql('ALTER TABLE declaration_dechets ALTER qtite_incineree_dechets_dasri SET NOT NULL');
        $this->addSql('ALTER TABLE declaration_dechets ALTER qtite_incineree_dechets_non_dangereux SET NOT NULL');
        $this->addSql('ALTER TABLE declaration_dechets ALTER qtite_incineree_dechets_non_dangereux_menagers SET NOT NULL');
        $this->addSql('ALTER TABLE declaration_dechets ALTER qtite_incineree_dechets_non_dangereux_refus_tri SET NOT NULL');
        $this->addSql('ALTER TABLE declaration_dechets ALTER qtite_incineree_dechets_non_dangereux_dae SET NOT NULL');
        $this->addSql('ALTER TABLE mesure_dioxine ALTER commentaire SET NOT NULL');
    }
}
