\connect TICKET_RECOGNITION

REVOKE ALL PRIVILEGES ON ALL TABLES IN SCHEMA public FROM appuser;
GRANT SELECT,UPDATE,INSERT,DELETE ON ALL TABLES IN SCHEMA public TO appuser;

CREATE SEQUENCE TICKET_ID_SEQ START 1;
CREATE TABLE TICKET (
    ID BIGINT NOT NULL DEFAULT nextval('TICKET_ID_SEQ'),
    TICKET_TEMPLATE_ID BIGINT NOT NULL ,
    TOUR_ID BIGINT NOT NULL ,
    SCAN_DATE TIMESTAMP NOT NULL ,
    PRIMARY KEY (ID)
);
ALTER SEQUENCE TICKET_ID_SEQ OWNED BY TICKET.ID;

CREATE SEQUENCE TICKET_TEMPLATE_ID_SEQ START 1;
CREATE TABLE TICKET_TEMPLATE (
    ID BIGINT NOT NULL DEFAULT nextval('TICKET_TEMPLATE_ID_SEQ'),
    KEY VARCHAR(50) NOT NULL UNIQUE,
    IMAGE_FILE_EXTENSION VARCHAR(10) NOT NULL,
    TOUR_OPERATOR_ID BIGINT NOT NULL ,
    PRIMARY KEY (ID)
);
ALTER SEQUENCE TICKET_TEMPLATE_ID_SEQ OWNED BY TICKET_TEMPLATE.ID;

CREATE SEQUENCE TEXT_DEFINITION_ID_SEQ START 1;
CREATE TABLE TEXT_DEFINITION (
    ID BIGINT NOT NULL DEFAULT nextval('TEXT_DEFINITION_ID_SEQ'),
    TICKET_TEMPLATE_ID BIGINT NOT NULL ,
    KEY VARCHAR(50) NOT NULL ,
    DESCRIPTION VARCHAR(100) NOT NULL ,
    X int NOT NULL ,
    Y int NOT NULL ,
    WIDTH int NOT NULL ,
    HEIGHT int NOT NULL ,
    PRIMARY KEY (ID),
    UNIQUE (TICKET_TEMPLATE_ID, KEY)
);
ALTER SEQUENCE TEXT_DEFINITION_ID_SEQ OWNED BY TEXT_DEFINITION.ID;

CREATE SEQUENCE TOUR_OPERATOR_ID_SEQ START 1;
CREATE TABLE TOUR_OPERATOR (
    ID BIGINT NOT NULL DEFAULT nextval('TOUR_OPERATOR_ID_SEQ'),
    NAME VARCHAR(100) NOT NULL UNIQUE,
    PRIMARY KEY (ID)
);
ALTER SEQUENCE TOUR_OPERATOR_ID_SEQ OWNED BY TOUR_OPERATOR.ID;

CREATE SEQUENCE TOUR_ID_SEQ START 1;
CREATE TABLE TOUR (
    ID BIGINT NOT NULL DEFAULT nextval('TOUR_ID_SEQ'),
    DESCRIPTION VARCHAR(100) NOT NULL ,
    CODE int NOT NULL UNIQUE,
    PRIMARY KEY (ID)
);
ALTER SEQUENCE TOUR_ID_SEQ OWNED BY TOUR.ID;

CREATE TABLE TOUR_TOUR_POSITION (
    TOUR_ID BIGINT NOT NULL,
    TOUR_POSITION_ID BIGINT NOT NULL ,
    PRIMARY KEY (TOUR_ID, TOUR_POSITION_ID)
);

CREATE SEQUENCE TOUR_POSITION_ID_SEQ START 1;
CREATE TABLE TOUR_POSITION (
    ID BIGINT NOT NULL DEFAULT nextval('TOUR_POSITION_ID_SEQ'),
    DESCRIPTION VARCHAR(100) NOT NULL ,
    CODE int NOT NULL UNIQUE,
    PRIMARY KEY (ID)
);
ALTER SEQUENCE TOUR_POSITION_ID_SEQ OWNED BY TOUR_POSITION.ID;

CREATE SEQUENCE TICKET_POSITION_ID_SEQ START 1;
CREATE TABLE TICKET_POSITION (
    ID BIGINT NOT NULL DEFAULT nextval('TICKET_POSITION_ID_SEQ'),
    DESCRIPTION VARCHAR(100) NOT NULL ,
    CODE int NOT NULL,
    TICKET_ID int NOT NULL,
    PRIMARY KEY (ID),
    UNIQUE (ID, CODE)
);
ALTER SEQUENCE TICKET_POSITION_ID_SEQ OWNED BY TICKET_POSITION.ID;

ALTER TABLE TICKET ADD CONSTRAINT fk_TICKET_TICKET_TEMPLATE_ID FOREIGN KEY(TICKET_TEMPLATE_ID)
REFERENCES TICKET_TEMPLATE (ID);

ALTER TABLE TICKET ADD CONSTRAINT fk_TICKET_TOUR_ID FOREIGN KEY(TOUR_ID)
REFERENCES TOUR (ID);

ALTER TABLE TICKET_TEMPLATE ADD CONSTRAINT fk_TICKET_TEMPLATE_TOUR_OPERATOR_ID FOREIGN KEY(TOUR_OPERATOR_ID)
REFERENCES TOUR_OPERATOR (ID);

ALTER TABLE TEXT_DEFINITION ADD CONSTRAINT fk_TEXT_DEFINITION_TICKET_TEMPLATE_ID FOREIGN KEY(TICKET_TEMPLATE_ID)
REFERENCES TICKET_TEMPLATE (ID);

ALTER TABLE TOUR_TOUR_POSITION ADD CONSTRAINT fk_TOUR_TOUR_POSITION_TOUR_ID FOREIGN KEY(TOUR_ID)
REFERENCES TOUR (ID);

ALTER TABLE TOUR_TOUR_POSITION ADD CONSTRAINT fk_TOUR_TOUR_POSITION_TOUR_POSITION_ID FOREIGN KEY(TOUR_POSITION_ID)
REFERENCES TOUR_POSITION (ID);

ALTER TABLE TICKET_POSITION ADD CONSTRAINT fk_TICKET_POSITION_TICKET_ID FOREIGN KEY(TICKET_ID)
REFERENCES TICKET (ID);


INSERT INTO TOUR_OPERATOR(ID, NAME) VALUES(1, 'Example Tours AG');
INSERT INTO TOUR_OPERATOR(ID, NAME) VALUES(2, 'Müller Adventures GmbH');
INSERT INTO TOUR_OPERATOR(ID, NAME) VALUES(3, 'Touroperator A');
INSERT INTO TOUR_OPERATOR(ID, NAME) VALUES(4, 'Touroperator B');

select setval('TOUR_OPERATOR_ID_SEQ', (select max(ID) from TOUR_OPERATOR));

INSERT INTO TOUR_POSITION(ID, CODE, DESCRIPTION) VALUES(1, 1234, 'Romantisches Abendessen zu zweit');
INSERT INTO TOUR_POSITION(ID, CODE, DESCRIPTION) VALUES(2, 5678, 'Fahrt in der antiken Lokomotive');
INSERT INTO TOUR_POSITION(ID, CODE, DESCRIPTION) VALUES(3, 9876, 'Alpenpanorama-Tour');
INSERT INTO TOUR_POSITION(ID, CODE, DESCRIPTION) VALUES(4, 5432, 'Fondue im Iglu');
INSERT INTO TOUR_POSITION(ID, CODE, DESCRIPTION) VALUES(5, 1938, 'Übernachtung');
INSERT INTO TOUR_POSITION(ID, CODE, DESCRIPTION) VALUES(6, 6542, 'Adventure Bergtour');
INSERT INTO TOUR_POSITION(ID, CODE, DESCRIPTION) VALUES(7, 7645, 'Bootsfahrt auf dem Bodensee');

select setval('TOUR_POSITION_ID_SEQ', (select max(ID) from TOUR_POSITION));

INSERT INTO TOUR(ID, DESCRIPTION, CODE) VALUES(1, 'Adventure Bergtour & Übernachtung', 71234);
INSERT INTO TOUR(ID, DESCRIPTION, CODE) VALUES(2, 'Fondue mit Bootsfahrt', 34812);
INSERT INTO TOUR(ID, DESCRIPTION, CODE) VALUES(3, 'Tour A', 49844);
INSERT INTO TOUR(ID, DESCRIPTION, CODE) VALUES(4, 'Tour B', 98234);

select setval('TOUR_ID_SEQ', (select max(ID) from TOUR));

INSERT INTO TOUR_TOUR_POSITION(TOUR_ID, TOUR_POSITION_ID) VALUES(1, 5);
INSERT INTO TOUR_TOUR_POSITION(TOUR_ID, TOUR_POSITION_ID) VALUES(1, 6);

INSERT INTO TOUR_TOUR_POSITION(TOUR_ID, TOUR_POSITION_ID) VALUES(2, 4);
INSERT INTO TOUR_TOUR_POSITION(TOUR_ID, TOUR_POSITION_ID) VALUES(2, 7);

INSERT INTO TOUR_TOUR_POSITION(TOUR_ID, TOUR_POSITION_ID) VALUES(3, 1);
INSERT INTO TOUR_TOUR_POSITION(TOUR_ID, TOUR_POSITION_ID) VALUES(3, 2);
INSERT INTO TOUR_TOUR_POSITION(TOUR_ID, TOUR_POSITION_ID) VALUES(3, 5);

INSERT INTO TOUR_TOUR_POSITION(TOUR_ID, TOUR_POSITION_ID) VALUES(4, 3);
INSERT INTO TOUR_TOUR_POSITION(TOUR_ID, TOUR_POSITION_ID) VALUES(4, 1);

INSERT INTO TICKET_TEMPLATE(ID, KEY, IMAGE_FILE_EXTENSION, TOUR_OPERATOR_ID) VALUES(1, 'boulderisland', 'jpg', 1);
INSERT INTO TICKET_TEMPLATE(ID, KEY, IMAGE_FILE_EXTENSION, TOUR_OPERATOR_ID) VALUES(2, 'massage', 'jpg', 2);
INSERT INTO TICKET_TEMPLATE(ID, KEY, IMAGE_FILE_EXTENSION, TOUR_OPERATOR_ID) VALUES(3, 'weihnachten', 'jpg', 3);

select setval('TICKET_TEMPLATE_ID_SEQ', (select max(ID) from TICKET_TEMPLATE));

/* TEXT_DEFINITIONS FOR TICKET_TEMPLATE 'boulderisland' */
INSERT INTO TEXT_DEFINITION(ID, TICKET_TEMPLATE_ID, KEY, DESCRIPTION, X, Y, WIDTH, HEIGHT) 
    VALUES(1, 1, 'for', 'Für', 286, 170, 436, 46);
INSERT INTO TEXT_DEFINITION(ID, TICKET_TEMPLATE_ID, KEY, DESCRIPTION, X, Y, WIDTH, HEIGHT) 
    VALUES(2, 1, 'tourcode', 'Tour-Code', 295, 216, 427, 47);

/* TEXT_DEFINITIONS FOR TICKET_TEMPLATE 'massage' */
INSERT INTO TEXT_DEFINITION(ID, TICKET_TEMPLATE_ID, KEY, DESCRIPTION, X, Y, WIDTH, HEIGHT) 
    VALUES(3, 2, 'tourcode', 'Tour-Code', 244, 257, 358, 50);
INSERT INTO TEXT_DEFINITION(ID, TICKET_TEMPLATE_ID, KEY, DESCRIPTION, X, Y, WIDTH, HEIGHT) 
    VALUES(4, 2, 'for', 'Für', 244, 184, 358, 50);
INSERT INTO TEXT_DEFINITION(ID, TICKET_TEMPLATE_ID, KEY, DESCRIPTION, X, Y, WIDTH, HEIGHT) 
    VALUES(5, 2, 'date', 'Datum', 244, 330, 358, 50);

/* TEXT_DEFINITIONS FOR TICKET_TEMPLATE 'weihnachten' */
INSERT INTO TEXT_DEFINITION(ID, TICKET_TEMPLATE_ID, KEY, DESCRIPTION, X, Y, WIDTH, HEIGHT) 
    VALUES(6, 3, 'tourcode', 'Tour-Code', 48, 317, 176, 38);
INSERT INTO TEXT_DEFINITION(ID, TICKET_TEMPLATE_ID, KEY, DESCRIPTION, X, Y, WIDTH, HEIGHT) 
    VALUES(7, 3, 'value', 'Wert', 277, 291, 265, 64);

select setval('TEXT_DEFINITION_ID_SEQ', (select max(ID) from TEXT_DEFINITION));

INSERT INTO TICKET(ID, TICKET_TEMPLATE_ID, TOUR_ID, SCAN_DATE) 
    VALUES(1, 1, 1, current_timestamp);
INSERT INTO TICKET(ID, TICKET_TEMPLATE_ID, TOUR_ID, SCAN_DATE) 
    VALUES(2, 2, 3, current_timestamp);
INSERT INTO TICKET(ID, TICKET_TEMPLATE_ID, TOUR_ID, SCAN_DATE) 
    VALUES(3, 3, 2, current_timestamp);
INSERT INTO TICKET(ID, TICKET_TEMPLATE_ID, TOUR_ID, SCAN_DATE) 
    VALUES(4, 1, 2, current_timestamp);
select setval('TICKET_ID_SEQ', (select max(ID) from TICKET));

INSERT INTO TICKET_POSITION(ID, CODE, DESCRIPTION, TICKET_ID) VALUES(1, 1234, 'Romantisches Abendessen zu zweit', 1);
INSERT INTO TICKET_POSITION(ID, CODE, DESCRIPTION, TICKET_ID) VALUES(2, 5678, 'Fahrt in der antiken Lokomotive', 1);
INSERT INTO TICKET_POSITION(ID, CODE, DESCRIPTION, TICKET_ID) VALUES(3, 9876, 'Alpenpanorama-Tour', 2);
INSERT INTO TICKET_POSITION(ID, CODE, DESCRIPTION, TICKET_ID) VALUES(4, 5432, 'Fondue im Iglu', 2);
INSERT INTO TICKET_POSITION(ID, CODE, DESCRIPTION, TICKET_ID) VALUES(5, 1234, 'Romantisches Abendessen zu zweit', 3);
INSERT INTO TICKET_POSITION(ID, CODE, DESCRIPTION, TICKET_ID) VALUES(6, 5678, 'Fahrt in der antiken Lokomotive', 3);
INSERT INTO TICKET_POSITION(ID, CODE, DESCRIPTION, TICKET_ID) VALUES(7, 9876, 'Alpenpanorama-Tour', 4);
INSERT INTO TICKET_POSITION(ID, CODE, DESCRIPTION, TICKET_ID) VALUES(8, 5432, 'Fondue im Iglu', 4);

select setval('TICKET_POSITION_ID_SEQ', (select max(ID) from TICKET_POSITION));