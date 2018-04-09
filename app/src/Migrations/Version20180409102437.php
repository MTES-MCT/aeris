<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180409102437 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE declaration_fonctionnement_ligne ADD declaration_incinerateur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE declaration_fonctionnement_ligne ADD ligne_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE declaration_fonctionnement_ligne ADD CONSTRAINT FK_92DDBF9CE14D3BB1 FOREIGN KEY (declaration_incinerateur_id) REFERENCES declaration_incinerateur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE declaration_fonctionnement_ligne ADD CONSTRAINT FK_92DDBF9C5A438E76 FOREIGN KEY (ligne_id) REFERENCES incinerateur_ligne (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_92DDBF9CE14D3BB1 ON declaration_fonctionnement_ligne (declaration_incinerateur_id)');
        $this->addSql('CREATE INDEX IDX_92DDBF9C5A438E76 ON declaration_fonctionnement_ligne (ligne_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE declaration_fonctionnement_ligne DROP CONSTRAINT FK_92DDBF9CE14D3BB1');
        $this->addSql('ALTER TABLE declaration_fonctionnement_ligne DROP CONSTRAINT FK_92DDBF9C5A438E76');
        $this->addSql('DROP INDEX IDX_92DDBF9CE14D3BB1');
        $this->addSql('DROP INDEX IDX_92DDBF9C5A438E76');
        $this->addSql('ALTER TABLE declaration_fonctionnement_ligne DROP declaration_incinerateur_id');
        $this->addSql('ALTER TABLE declaration_fonctionnement_ligne DROP ligne_id');
    }
}
