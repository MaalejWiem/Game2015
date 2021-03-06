<?php

namespace Aip\SeriousgameBundle\Migrations\ibm_db2;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated migration based on mapping information: modify it with caution
 *
 * Generation date: 2015/02/02 05:37:35
 */
class Version20150202173731 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("
            CREATE TABLE \"Enable\" (
                id INTEGER GENERATED BY DEFAULT AS IDENTITY NOT NULL, 
                \"enable\" SMALLINT NOT NULL, 
                creator INTEGER NOT NULL, 
                PRIMARY KEY(id)
            )
        ");
        $this->addSql("
            CREATE TABLE EnableCLA (
                id INTEGER GENERATED BY DEFAULT AS IDENTITY NOT NULL, 
                enablecla SMALLINT NOT NULL, 
                aggregate_id INTEGER NOT NULL, 
                PRIMARY KEY(id)
            )
        ");
        $this->addSql("
            CREATE TABLE EnableLA (
                id INTEGER GENERATED BY DEFAULT AS IDENTITY NOT NULL, 
                enablela SMALLINT NOT NULL, 
                aggregate_id INTEGER NOT NULL, 
                PRIMARY KEY(id)
            )
        ");
        $this->addSql("
            CREATE TABLE Configurationgame (
                id INTEGER GENERATED BY DEFAULT AS IDENTITY NOT NULL, 
                creator_id INTEGER NOT NULL, 
                aggregate_id INTEGER NOT NULL, 
                url VARCHAR(255) NOT NULL, 
                nom VARCHAR(255) NOT NULL, 
                port INTEGER DEFAULT NULL, 
                scenario VARCHAR(255) NOT NULL, 
                creation_date TIMESTAMP(0) NOT NULL, 
                publication_date TIMESTAMP(0) DEFAULT NULL, 
                PRIMARY KEY(id)
            )
        ");
        $this->addSql("
            CREATE INDEX IDX_A34CDBD461220EA6 ON Configurationgame (creator_id)
        ");
        $this->addSql("
            CREATE INDEX IDX_A34CDBD4D0BBCCBE ON Configurationgame (aggregate_id)
        ");
        $this->addSql("
            CREATE TABLE claro_game_aggregate (
                id INTEGER GENERATED BY DEFAULT AS IDENTITY NOT NULL, 
                resourceNode_id INTEGER DEFAULT NULL, 
                PRIMARY KEY(id)
            )
        ");
        $this->addSql("
            CREATE INDEX IDX_65F2B02CB87FAB32 ON claro_game_aggregate (resourceNode_id)
        ");
        $this->addSql("
            CREATE UNIQUE INDEX UNIQ_65F2B02CB87FAB32 ON claro_game_aggregate (resourceNode_id)
        ");
        $this->addSql("
            CREATE TABLE Activitegame (
                id INTEGER GENERATED BY DEFAULT AS IDENTITY NOT NULL, 
                creator_id INTEGER NOT NULL, 
                aggregate_id INTEGER NOT NULL, 
                nom VARCHAR(255) NOT NULL, 
                nomconfiguration VARCHAR(255) NOT NULL, 
                instructions VARCHAR(255) NOT NULL, 
                creation_date TIMESTAMP(0) NOT NULL, 
                publication_date TIMESTAMP(0) DEFAULT NULL, 
                PRIMARY KEY(id)
            )
        ");
        $this->addSql("
            CREATE INDEX IDX_A158178F61220EA6 ON Activitegame (creator_id)
        ");
        $this->addSql("
            CREATE INDEX IDX_A158178FD0BBCCBE ON Activitegame (aggregate_id)
        ");
        $this->addSql("
            ALTER TABLE Configurationgame 
            ADD CONSTRAINT FK_A34CDBD461220EA6 FOREIGN KEY (creator_id) 
            REFERENCES claro_user (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE Configurationgame 
            ADD CONSTRAINT FK_A34CDBD4D0BBCCBE FOREIGN KEY (aggregate_id) 
            REFERENCES claro_game_aggregate (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE claro_game_aggregate 
            ADD CONSTRAINT FK_65F2B02CB87FAB32 FOREIGN KEY (resourceNode_id) 
            REFERENCES claro_resource_node (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE Activitegame 
            ADD CONSTRAINT FK_A158178F61220EA6 FOREIGN KEY (creator_id) 
            REFERENCES claro_user (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE Activitegame 
            ADD CONSTRAINT FK_A158178FD0BBCCBE FOREIGN KEY (aggregate_id) 
            REFERENCES claro_game_aggregate (id) 
            ON DELETE CASCADE
        ");
    }

    public function down(Schema $schema)
    {
        $this->addSql("
            ALTER TABLE Configurationgame 
            DROP FOREIGN KEY FK_A34CDBD4D0BBCCBE
        ");
        $this->addSql("
            ALTER TABLE Activitegame 
            DROP FOREIGN KEY FK_A158178FD0BBCCBE
        ");
        $this->addSql("
            DROP TABLE \"Enable\"
        ");
        $this->addSql("
            DROP TABLE EnableCLA
        ");
        $this->addSql("
            DROP TABLE EnableLA
        ");
        $this->addSql("
            DROP TABLE Configurationgame
        ");
        $this->addSql("
            DROP TABLE claro_game_aggregate
        ");
        $this->addSql("
            DROP TABLE Activitegame
        ");
    }
}