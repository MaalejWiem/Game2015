<?php

namespace Aip\SeriousgameBundle\Migrations\pdo_sqlite;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated migration based on mapping information: modify it with caution
 *
 * Generation date: 2015/02/02 05:37:34
 */
class Version20150202173731 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("
            CREATE TABLE Enable (
                id INTEGER NOT NULL, 
                enable BOOLEAN NOT NULL, 
                creator INTEGER NOT NULL, 
                PRIMARY KEY(id)
            )
        ");
        $this->addSql("
            CREATE TABLE EnableCLA (
                id INTEGER NOT NULL, 
                enablecla BOOLEAN NOT NULL, 
                aggregate_id INTEGER NOT NULL, 
                PRIMARY KEY(id)
            )
        ");
        $this->addSql("
            CREATE TABLE EnableLA (
                id INTEGER NOT NULL, 
                enablela BOOLEAN NOT NULL, 
                aggregate_id INTEGER NOT NULL, 
                PRIMARY KEY(id)
            )
        ");
        $this->addSql("
            CREATE TABLE Configurationgame (
                id INTEGER NOT NULL, 
                creator_id INTEGER NOT NULL, 
                aggregate_id INTEGER NOT NULL, 
                url VARCHAR(255) NOT NULL, 
                nom VARCHAR(255) NOT NULL, 
                port INTEGER DEFAULT NULL, 
                scenario VARCHAR(255) NOT NULL, 
                creation_date DATETIME NOT NULL, 
                publication_date DATETIME DEFAULT NULL, 
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
                id INTEGER NOT NULL, 
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
                id INTEGER NOT NULL, 
                creator_id INTEGER NOT NULL, 
                aggregate_id INTEGER NOT NULL, 
                nom VARCHAR(255) NOT NULL, 
                nomconfiguration VARCHAR(255) NOT NULL, 
                instructions VARCHAR(255) NOT NULL, 
                creation_date DATETIME NOT NULL, 
                publication_date DATETIME DEFAULT NULL, 
                PRIMARY KEY(id)
            )
        ");
        $this->addSql("
            CREATE INDEX IDX_A158178F61220EA6 ON Activitegame (creator_id)
        ");
        $this->addSql("
            CREATE INDEX IDX_A158178FD0BBCCBE ON Activitegame (aggregate_id)
        ");
    }

    public function down(Schema $schema)
    {
        $this->addSql("
            DROP TABLE Enable
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