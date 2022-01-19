CREATE TABLE vaccineevents (

vacc_event VARCHAR(30) NOT NULL,
vacc_cond VARCHAR(30) NOT NULL,
PRIMARY KEY(vacc_event)

);

INSERT INTO vaccineevents (vacc_event, vacc_cond) 
VALUES ('vaccinated', '接種済み');


INSERT INTO vaccineevents (vacc_event, vacc_cond) 
VALUES ('not_vaccinated', '未接種・接種予定');

/* 
接種済み　未接種の登録のため　ぶらさがったやつ
*/
