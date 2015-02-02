<?php

namespace Aip\SeriousgameBundle\Migrations\oci8;

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
                id NUMBER(10) NOT NULL, 
                enable NUMBER(1) NOT NULL, 
                creator NUMBER(10) NOT NULL, 
                PRIMARY KEY(id)
            )
        ");
        $this->addSql("
            DECLARE constraints_Count NUMBER; BEGIN 
            SELECT COUNT(CONSTRAINT_NAME) INTO constraints_Count 
            FROM USER_CONSTRAINTS 
            WHERE TABLE_NAME = 'ENABLE' 
            AND CONSTRAINT_TYPE = 'P'; IF constraints_Count = 0 
            OR constraints_Count = '' THEN EXECUTE IMMEDIATE 'ALTER TABLE ENABLE ADD CONSTRAINT ENABLE_AI_PK PRIMARY KEY (ID)'; END IF; END;
        ");
        $this->addSql("
            CREATE SEQUENCE ENABLE_SEQ START WITH 1 MINVALUE 1 INCREMENT BY 1
        ");
        $this->addSql("
            CREATE TRIGGER ENABLE_AI_PK BEFORE INSERT ON ENABLE FOR EACH ROW DECLARE last_Sequence NUMBER; last_InsertID NUMBER; BEGIN 
            SELECT ENABLE_SEQ.NEXTVAL INTO : NEW.ID 
            FROM DUAL; IF (
                : NEW.ID IS NULL 
                OR : NEW.ID = 0
            ) THEN 
            SELECT ENABLE_SEQ.NEXTVAL INTO : NEW.ID 
            FROM DUAL; ELSE 
            SELECT NVL(Last_Number, 0) INTO last_Sequence 
            FROM User_Sequences 
            WHERE Sequence_Name = 'ENABLE_SEQ'; 
            SELECT : NEW.ID INTO last_InsertID 
            FROM DUAL; WHILE (last_InsertID > last_Sequence) LOOP 
            SELECT ENABLE_SEQ.NEXTVAL INTO last_Sequence 
            FROM DUAL; END LOOP; END IF; END;
        ");
        $this->addSql("
            CREATE TABLE EnableCLA (
                id NUMBER(10) NOT NULL, 
                enablecla NUMBER(1) NOT NULL, 
                aggregate_id NUMBER(10) NOT NULL, 
                PRIMARY KEY(id)
            )
        ");
        $this->addSql("
            DECLARE constraints_Count NUMBER; BEGIN 
            SELECT COUNT(CONSTRAINT_NAME) INTO constraints_Count 
            FROM USER_CONSTRAINTS 
            WHERE TABLE_NAME = 'ENABLECLA' 
            AND CONSTRAINT_TYPE = 'P'; IF constraints_Count = 0 
            OR constraints_Count = '' THEN EXECUTE IMMEDIATE 'ALTER TABLE ENABLECLA ADD CONSTRAINT ENABLECLA_AI_PK PRIMARY KEY (ID)'; END IF; END;
        ");
        $this->addSql("
            CREATE SEQUENCE ENABLECLA_SEQ START WITH 1 MINVALUE 1 INCREMENT BY 1
        ");
        $this->addSql("
            CREATE TRIGGER ENABLECLA_AI_PK BEFORE INSERT ON ENABLECLA FOR EACH ROW DECLARE last_Sequence NUMBER; last_InsertID NUMBER; BEGIN 
            SELECT ENABLECLA_SEQ.NEXTVAL INTO : NEW.ID 
            FROM DUAL; IF (
                : NEW.ID IS NULL 
                OR : NEW.ID = 0
            ) THEN 
            SELECT ENABLECLA_SEQ.NEXTVAL INTO : NEW.ID 
            FROM DUAL; ELSE 
            SELECT NVL(Last_Number, 0) INTO last_Sequence 
            FROM User_Sequences 
            WHERE Sequence_Name = 'ENABLECLA_SEQ'; 
            SELECT : NEW.ID INTO last_InsertID 
            FROM DUAL; WHILE (last_InsertID > last_Sequence) LOOP 
            SELECT ENABLECLA_SEQ.NEXTVAL INTO last_Sequence 
            FROM DUAL; END LOOP; END IF; END;
        ");
        $this->addSql("
            CREATE TABLE EnableLA (
                id NUMBER(10) NOT NULL, 
                enablela NUMBER(1) NOT NULL, 
                aggregate_id NUMBER(10) NOT NULL, 
                PRIMARY KEY(id)
            )
        ");
        $this->addSql("
            DECLARE constraints_Count NUMBER; BEGIN 
            SELECT COUNT(CONSTRAINT_NAME) INTO constraints_Count 
            FROM USER_CONSTRAINTS 
            WHERE TABLE_NAME = 'ENABLELA' 
            AND CONSTRAINT_TYPE = 'P'; IF constraints_Count = 0 
            OR constraints_Count = '' THEN EXECUTE IMMEDIATE 'ALTER TABLE ENABLELA ADD CONSTRAINT ENABLELA_AI_PK PRIMARY KEY (ID)'; END IF; END;
        ");
        $this->addSql("
            CREATE SEQUENCE ENABLELA_SEQ START WITH 1 MINVALUE 1 INCREMENT BY 1
        ");
        $this->addSql("
            CREATE TRIGGER ENABLELA_AI_PK BEFORE INSERT ON ENABLELA FOR EACH ROW DECLARE last_Sequence NUMBER; last_InsertID NUMBER; BEGIN 
            SELECT ENABLELA_SEQ.NEXTVAL INTO : NEW.ID 
            FROM DUAL; IF (
                : NEW.ID IS NULL 
                OR : NEW.ID = 0
            ) THEN 
            SELECT ENABLELA_SEQ.NEXTVAL INTO : NEW.ID 
            FROM DUAL; ELSE 
            SELECT NVL(Last_Number, 0) INTO last_Sequence 
            FROM User_Sequences 
            WHERE Sequence_Name = 'ENABLELA_SEQ'; 
            SELECT : NEW.ID INTO last_InsertID 
            FROM DUAL; WHILE (last_InsertID > last_Sequence) LOOP 
            SELECT ENABLELA_SEQ.NEXTVAL INTO last_Sequence 
            FROM DUAL; END LOOP; END IF; END;
        ");
        $this->addSql("
            CREATE TABLE Configurationgame (
                id NUMBER(10) NOT NULL, 
                creator_id NUMBER(10) NOT NULL, 
                aggregate_id NUMBER(10) NOT NULL, 
                url VARCHAR2(255) NOT NULL, 
                nom VARCHAR2(255) NOT NULL, 
                port NUMBER(10) DEFAULT NULL NULL, 
                scenario VARCHAR2(255) NOT NULL, 
                creation_date TIMESTAMP(0) NOT NULL, 
                publication_date TIMESTAMP(0) DEFAULT NULL NULL, 
                PRIMARY KEY(id)
            )
        ");
        $this->addSql("
            DECLARE constraints_Count NUMBER; BEGIN 
            SELECT COUNT(CONSTRAINT_NAME) INTO constraints_Count 
            FROM USER_CONSTRAINTS 
            WHERE TABLE_NAME = 'CONFIGURATIONGAME' 
            AND CONSTRAINT_TYPE = 'P'; IF constraints_Count = 0 
            OR constraints_Count = '' THEN EXECUTE IMMEDIATE 'ALTER TABLE CONFIGURATIONGAME ADD CONSTRAINT CONFIGURATIONGAME_AI_PK PRIMARY KEY (ID)'; END IF; END;
        ");
        $this->addSql("
            CREATE SEQUENCE CONFIGURATIONGAME_SEQ START WITH 1 MINVALUE 1 INCREMENT BY 1
        ");
        $this->addSql("
            CREATE TRIGGER CONFIGURATIONGAME_AI_PK BEFORE INSERT ON CONFIGURATIONGAME FOR EACH ROW DECLARE last_Sequence NUMBER; last_InsertID NUMBER; BEGIN 
            SELECT CONFIGURATIONGAME_SEQ.NEXTVAL INTO : NEW.ID 
            FROM DUAL; IF (
                : NEW.ID IS NULL 
                OR : NEW.ID = 0
            ) THEN 
            SELECT CONFIGURATIONGAME_SEQ.NEXTVAL INTO : NEW.ID 
            FROM DUAL; ELSE 
            SELECT NVL(Last_Number, 0) INTO last_Sequence 
            FROM User_Sequences 
            WHERE Sequence_Name = 'CONFIGURATIONGAME_SEQ'; 
            SELECT : NEW.ID INTO last_InsertID 
            FROM DUAL; WHILE (last_InsertID > last_Sequence) LOOP 
            SELECT CONFIGURATIONGAME_SEQ.NEXTVAL INTO last_Sequence 
            FROM DUAL; END LOOP; END IF; END;
        ");
        $this->addSql("
            CREATE INDEX IDX_A34CDBD461220EA6 ON Configurationgame (creator_id)
        ");
        $this->addSql("
            CREATE INDEX IDX_A34CDBD4D0BBCCBE ON Configurationgame (aggregate_id)
        ");
        $this->addSql("
            CREATE TABLE claro_game_aggregate (
                id NUMBER(10) NOT NULL, 
                resourceNode_id NUMBER(10) DEFAULT NULL NULL, 
                PRIMARY KEY(id)
            )
        ");
        $this->addSql("
            DECLARE constraints_Count NUMBER; BEGIN 
            SELECT COUNT(CONSTRAINT_NAME) INTO constraints_Count 
            FROM USER_CONSTRAINTS 
            WHERE TABLE_NAME = 'CLARO_GAME_AGGREGATE' 
            AND CONSTRAINT_TYPE = 'P'; IF constraints_Count = 0 
            OR constraints_Count = '' THEN EXECUTE IMMEDIATE 'ALTER TABLE CLARO_GAME_AGGREGATE ADD CONSTRAINT CLARO_GAME_AGGREGATE_AI_PK PRIMARY KEY (ID)'; END IF; END;
        ");
        $this->addSql("
            CREATE SEQUENCE CLARO_GAME_AGGREGATE_SEQ START WITH 1 MINVALUE 1 INCREMENT BY 1
        ");
        $this->addSql("
            CREATE TRIGGER CLARO_GAME_AGGREGATE_AI_PK BEFORE INSERT ON CLARO_GAME_AGGREGATE FOR EACH ROW DECLARE last_Sequence NUMBER; last_InsertID NUMBER; BEGIN 
            SELECT CLARO_GAME_AGGREGATE_SEQ.NEXTVAL INTO : NEW.ID 
            FROM DUAL; IF (
                : NEW.ID IS NULL 
                OR : NEW.ID = 0
            ) THEN 
            SELECT CLARO_GAME_AGGREGATE_SEQ.NEXTVAL INTO : NEW.ID 
            FROM DUAL; ELSE 
            SELECT NVL(Last_Number, 0) INTO last_Sequence 
            FROM User_Sequences 
            WHERE Sequence_Name = 'CLARO_GAME_AGGREGATE_SEQ'; 
            SELECT : NEW.ID INTO last_InsertID 
            FROM DUAL; WHILE (last_InsertID > last_Sequence) LOOP 
            SELECT CLARO_GAME_AGGREGATE_SEQ.NEXTVAL INTO last_Sequence 
            FROM DUAL; END LOOP; END IF; END;
        ");
        $this->addSql("
            CREATE INDEX IDX_65F2B02CB87FAB32 ON claro_game_aggregate (resourceNode_id)
        ");
        $this->addSql("
            CREATE UNIQUE INDEX UNIQ_65F2B02CB87FAB32 ON claro_game_aggregate (resourceNode_id)
        ");
        $this->addSql("
            CREATE TABLE Activitegame (
                id NUMBER(10) NOT NULL, 
                creator_id NUMBER(10) NOT NULL, 
                aggregate_id NUMBER(10) NOT NULL, 
                nom VARCHAR2(255) NOT NULL, 
                nomconfiguration VARCHAR2(255) NOT NULL, 
                instructions VARCHAR2(255) NOT NULL, 
                creation_date TIMESTAMP(0) NOT NULL, 
                publication_date TIMESTAMP(0) DEFAULT NULL NULL, 
                PRIMARY KEY(id)
            )
        ");
        $this->addSql("
            DECLARE constraints_Count NUMBER; BEGIN 
            SELECT COUNT(CONSTRAINT_NAME) INTO constraints_Count 
            FROM USER_CONSTRAINTS 
            WHERE TABLE_NAME = 'ACTIVITEGAME' 
            AND CONSTRAINT_TYPE = 'P'; IF constraints_Count = 0 
            OR constraints_Count = '' THEN EXECUTE IMMEDIATE 'ALTER TABLE ACTIVITEGAME ADD CONSTRAINT ACTIVITEGAME_AI_PK PRIMARY KEY (ID)'; END IF; END;
        ");
        $this->addSql("
            CREATE SEQUENCE ACTIVITEGAME_SEQ START WITH 1 MINVALUE 1 INCREMENT BY 1
        ");
        $this->addSql("
            CREATE TRIGGER ACTIVITEGAME_AI_PK BEFORE INSERT ON ACTIVITEGAME FOR EACH ROW DECLARE last_Sequence NUMBER; last_InsertID NUMBER; BEGIN 
            SELECT ACTIVITEGAME_SEQ.NEXTVAL INTO : NEW.ID 
            FROM DUAL; IF (
                : NEW.ID IS NULL 
                OR : NEW.ID = 0
            ) THEN 
            SELECT ACTIVITEGAME_SEQ.NEXTVAL INTO : NEW.ID 
            FROM DUAL; ELSE 
            SELECT NVL(Last_Number, 0) INTO last_Sequence 
            FROM User_Sequences 
            WHERE Sequence_Name = 'ACTIVITEGAME_SEQ'; 
            SELECT : NEW.ID INTO last_InsertID 
            FROM DUAL; WHILE (last_InsertID > last_Sequence) LOOP 
            SELECT ACTIVITEGAME_SEQ.NEXTVAL INTO last_Sequence 
            FROM DUAL; END LOOP; END IF; END;
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
            DROP CONSTRAINT FK_A34CDBD4D0BBCCBE
        ");
        $this->addSql("
            ALTER TABLE Activitegame 
            DROP CONSTRAINT FK_A158178FD0BBCCBE
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