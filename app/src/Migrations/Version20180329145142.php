<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180329145142 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE ligne_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE ligne (id INT NOT NULL, incinerateur_id INT DEFAULT NULL, numero INT NOT NULL, nb_fours INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_57F0DB837C7923EC ON ligne (incinerateur_id)');
        $this->addSql('ALTER TABLE ligne ADD CONSTRAINT FK_57F0DB837C7923EC FOREIGN KEY (incinerateur_id) REFERENCES incinerateur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE ligne_id_seq CASCADE');
        $this->addSql('DROP TABLE ligne');
    }
}
