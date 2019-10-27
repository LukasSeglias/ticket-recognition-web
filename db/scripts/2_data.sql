\connect TICKET_RECOGNITION

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

INSERT INTO TOUR(ID, DESCRIPTION, CODE) VALUES(1, 'Adventure Bergtour & Übernachtung', 5436);
INSERT INTO TOUR(ID, DESCRIPTION, CODE) VALUES(2, 'Fondue mit Bootsfahrt', 9973);
INSERT INTO TOUR(ID, DESCRIPTION, CODE) VALUES(3, 'Tour A', 3721);
INSERT INTO TOUR(ID, DESCRIPTION, CODE) VALUES(4, 'Tour B', 9345);

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

INSERT INTO TICKET_TEMPLATE(ID, KEY, IMAGE_FILE_NAME, TOUR_OPERATOR_ID) VALUES(1, 'template-a', '1.jpg', 1);
INSERT INTO TICKET_TEMPLATE(ID, KEY, IMAGE_FILE_NAME, TOUR_OPERATOR_ID) VALUES(2, 'template-b', '2.jpg', 2);
INSERT INTO TICKET_TEMPLATE(ID, KEY, IMAGE_FILE_NAME, TOUR_OPERATOR_ID) VALUES(3, 'template-c', '3.jpg', 3);

select setval('TICKET_TEMPLATE_ID_SEQ', (select max(ID) from TICKET_TEMPLATE));

INSERT INTO TEXT_DEFINITION(ID, TICKET_TEMPLATE_ID, KEY, DESCRIPTION, X, Y, WIDTH, HEIGHT) 
    VALUES(1, 1, 'tourcode', 'Tour-Code', 10, 15, 100, 50);
INSERT INTO TEXT_DEFINITION(ID, TICKET_TEMPLATE_ID, KEY, DESCRIPTION, X, Y, WIDTH, HEIGHT) 
    VALUES(2, 2, 'tourcode', 'Tour-Code', 15, 10, 50, 100);
INSERT INTO TEXT_DEFINITION(ID, TICKET_TEMPLATE_ID, KEY, DESCRIPTION, X, Y, WIDTH, HEIGHT) 
    VALUES(3, 3, 'tourcode', 'Tour-Code', 15, 10, 50, 100);

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