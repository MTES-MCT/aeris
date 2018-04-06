<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180405143720 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE mesure_dioxine ALTER COLUMN disponibilite_ligne TYPE numeric;');
        $this->addSql('ALTER TABLE mesure_dioxine ALTER COLUMN disponibilite_analyseur TYPE numeric;');
        $this->addSql('ALTER TABLE mesure_dioxine ALTER COLUMN concentration TYPE numeric;');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE mesure_dioxine ALTER disponibilite_ligne TYPE NUMERIC(10, 0)');
        $this->addSql('ALTER TABLE mesure_dioxine ALTER disponibilite_analyseur TYPE NUMERIC(10, 0)');
        $this->addSql('ALTER TABLE mesure_dioxine ALTER concentration TYPE NUMERIC(10, 10)');
    }
}
