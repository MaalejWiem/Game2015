<?php

namespace Aip\SeriousgameBundle\Migrations\drizzle_pdo_mysql;

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
            CREATE TABLE Enable (
                id INT AUTO_INCREMENT NOT NULL, 
                enable BOOLEAN NOT NULL, 
                creator INT NOT NULL, 
                PRIMARY KEY(id)
            ) COLLATE utf8_unicode_ci ENGINE = InnoDB
        ");
        $this->addSql("
            CREATE TABLE EnableCLA (
                id INT AUTO_INCREMENT NOT NULL, 
                enablecla BOOLEAN NOT NULL, 
                aggregate_id INT NOT NULL, 
                PRIMARY KEY(id)
            ) COLLATE utf8_unicode_ci ENGINE = InnoDB
        ");
        $this->addSql("
            CREATE TABLE EnableLA (
                id INT AUTO_INCREMENT NOT NULL, 
                enablela BOOLEAN NOT NULL, 
                aggregate_id INT NOT NULL, 
                PRIMARY KEY(id)
            ) COLLATE utf8_unicode_ci ENGINE = InnoDB
        ");
        $this->addSql("
            CREATE TABLE Configurationgame (
                id INT AUTO_INCREMENT NOT NULL, 
                creator_id INT NOT NULL, 
                aggregate_id INT NOT NULL, 
                url VARCHAR(255) NOT NULL, 
                nom VARCHAR(255) NOT NULL, 
                port INT DEFAULT NULL, 
                scenario VARCHAR(255) NOT NULL, 
                creation_date DATETIME NOT NULL, 
                publication_date DATETIME DEFAULT NULL, 
                INDEX IDX_A34CDBD461220EA6 (creator_id), 
                INDEX IDX_A34CDBD4D0BBCCBE (aggregate_id), 
                PRIMARY KEY(id)
            ) COLLATE utf8_unicode_ci ENGINE = InnoDB
        ");
        $this->addSql("
            CREATE TABLE claro_game_aggregate (
                id INT AUTO_INCREMENT NOT NULL, 
                resourceNode_id INT DEFAULT NULL, 
                INDEX IDX_65F2B02CB87FAB32 (resourceNode_id), 
                UNIQUE INDEX UNIQ_65F2B02CB87FAB32 (resourceNode_id), 
                PRIMARY KEY(id)
            ) COLLATE utf8_unicode_ci ENGINE = InnoDB
        ");
        $this->addSql("
            CREATE TABLE Activitegame (
                id INT AUTO_INCREMENT NOT NULL, 
                creator_id INT NOT NULL, 
                aggregate_id INT NOT NULL, 
                nom VARCHAR(255) NOT NULL, 
                nomconfiguration VARCHAR(255) NOT NULL, 
                instructions VARCHAR(255) NOT NULL, 
                creation_date DATETIME NOT NULL, 
                publication_date DATETIME DEFAULT NULL, 
                INDEX IDX_A158178F61220EA6 (creator_id), 
                INDEX IDX_A158178FD0BBCCBE (aggregate_id), 
                PRIMARY KEY(id)
            ) COLLATE utf8_unicode_ci ENGINE = InnoDB
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