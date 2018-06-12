<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180612094347 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE incinerateur ADD inspecteur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE incinerateur ADD CONSTRAINT FK_BEC9251BB7728AA0 FOREIGN KEY (inspecteur_id) REFERENCES fos_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_BEC9251BB7728AA0 ON incinerateur (inspecteur_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE incinerateur DROP CONSTRAINT FK_BEC9251BB7728AA0');
        $this->addSql('DROP INDEX IDX_BEC9251BB7728AA0');
        $this->addSql('ALTER TABLE incinerateur DROP inspecteur_id');
    }
}
