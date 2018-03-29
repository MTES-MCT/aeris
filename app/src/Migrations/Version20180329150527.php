<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180329150527 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE incinerateur_ligne_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE incinerateur_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE fos_user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE declaration_incinerateur_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE incinerateur_ligne (id INT NOT NULL, incinerateur_id INT DEFAULT NULL, numero INT NOT NULL, nb_fours INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_797D17A57C7923EC ON incinerateur_ligne (incinerateur_id)');
        $this->addSql('CREATE TABLE incinerateur (id INT NOT NULL, owner_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, nb_lignes INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_BEC9251B7E3C61F9 ON incinerateur (owner_id)');
        $this->addSql('CREATE TABLE fos_user (id INT NOT NULL, username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled BOOLEAN NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, roles TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_957A647992FC23A8 ON fos_user (username_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_957A6479A0D96FBF ON fos_user (email_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_957A6479C05FB297 ON fos_user (confirmation_token)');
        $this->addSql('COMMENT ON COLUMN fos_user.roles IS \'(DC2Type:array)\'');
        $this->addSql('CREATE TABLE declaration_incinerateur (id INT NOT NULL, incinerateur_id INT DEFAULT NULL, createdAt TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, comment TEXT DEFAULT NULL, declaration_file_name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_A65652D07C7923EC ON declaration_incinerateur (incinerateur_id)');
        $this->addSql('ALTER TABLE incinerateur_ligne ADD CONSTRAINT FK_797D17A57C7923EC FOREIGN KEY (incinerateur_id) REFERENCES incinerateur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE incinerateur ADD CONSTRAINT FK_BEC9251B7E3C61F9 FOREIGN KEY (owner_id) REFERENCES fos_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE declaration_incinerateur ADD CONSTRAINT FK_A65652D07C7923EC FOREIGN KEY (incinerateur_id) REFERENCES incinerateur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE incinerateur_ligne DROP CONSTRAINT FK_797D17A57C7923EC');
        $this->addSql('ALTER TABLE declaration_incinerateur DROP CONSTRAINT FK_A65652D07C7923EC');
        $this->addSql('ALTER TABLE incinerateur DROP CONSTRAINT FK_BEC9251B7E3C61F9');
        $this->addSql('DROP SEQUENCE incinerateur_ligne_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE incinerateur_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE fos_user_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE declaration_incinerateur_id_seq CASCADE');
        $this->addSql('DROP TABLE incinerateur_ligne');
        $this->addSql('DROP TABLE incinerateur');
        $this->addSql('DROP TABLE fos_user');
        $this->addSql('DROP TABLE declaration_incinerateur');
    }
}
