CREATE TABLE vaccinecountevents (

vacccount_event  VARCHAR(30) NOT NULL, 
vacccount_eventjp  VARCHAR(30) NOT NULL, 
PRIMARY KEY(vacccount_event)

);

INSERT INTO vaccinecountevents (vacccount_event, vacccount_eventjp)
VALUES ('nyuka', '入荷');

INSERT INTO vaccinecountevents (vacccount_event, vacccount_eventjp)
VALUES ('haraidashi', '払出');

INSERT INTO vaccinecountevents (vacccount_event, vacccount_eventjp)
VALUES ('shusei', '修正');

/*
vaccinecount.sql　へのぶら下がり
基本的にいじらせない

*/
