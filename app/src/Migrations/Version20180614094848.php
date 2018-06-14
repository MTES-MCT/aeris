<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180614094848 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs

        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql("INSERT INTO fos_user (id, username, username_canonical, email, email_canonical, enabled, salt, password, last_login, confirmation_token, password_requested_at, roles) VALUES (2, 'incinerateur-demo', 'incinerateur-demo', 'incinerateur-demo@aeris.fr', 'incinerateur-demo@aeris.fr', true, NULL, '\$2y\$13\$DwLDcPjCVviNl3QUFdH0Leq9Pvhf8p3GAgl3etZC2nv9ntwq7L8.u', '2018-06-14 08:39:21', NULL, NULL, 'a:1:{i:0;s:17:\"ROLE_INCINERATEUR\";}');");

        $this->addSql("INSERT INTO fos_user (id, username, username_canonical, email, email_canonical, enabled, salt, password, last_login, confirmation_token, password_requested_at, roles) VALUES (1, 'inspecteur-demo', 'inspecteur-demo', 'inspecteur-demo@aeris.fr', 'inspecteur-demo@aeris.fr', true, NULL, '\$2y\$13\$M53R.nGWsLwrKQjbZFDjoOwF8JPNOIPHs14ud6DPLvkZmiPldqb5m', '2018-06-14 08:40:24', NULL, NULL, 'a:1:{i:0;s:15:\"ROLE_INSPECTEUR\";}');");

        $this->addSql("INSERT INTO incinerateur (id, owner_id, name, nb_lignes, inspecteur_id) VALUES (13, 2, 'Incinérateur de démonstration', 2, 1);");
        $this->addSql("INSERT INTO incinerateur_ligne (id, incinerateur_id, numero, nb_fours) VALUES (3, 13, 1, 2);");
        $this->addSql("INSERT INTO incinerateur_ligne (id, incinerateur_id, numero, nb_fours) VALUES (4, 13, 2, 2);");

/*
SELECT pg_catalog.setval('fos_user_id_seq', 2, true);
SELECT pg_catalog.setval('incinerateur_id_seq', 13, true);
SELECT pg_catalog.setval('incinerateur_ligne_id_seq', 4, true);
*/

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
