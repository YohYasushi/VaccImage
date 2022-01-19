INSERT INTO allmembers (ptid, last_name, first_name, birthday, ptype_symbol, dpts_symbol) 
VALUES ('7899790', '安倍', '晋三', '1954-9-21', 'outpt', 'gairai');

INSERT INTO allmembers (ptid, last_name, first_name, birthday, ptype_symbol, dpts_symbol) 
VALUES ('542712', '岸田', '文雄', '1957-7-29', 'inpt', 'ward4A');

INSERT INTO allmembers (ptid, last_name, first_name, birthday, ptype_symbol, dpts_symbol) 
VALUES ('35668', '麻生', '太郎', '1940-9-20', 'inpt', 'ward3A')


/*
ここまで患者でーた
*/

INSERT INTO departments (dpts_symbol, dpts_name) 
VALUES ('ward3A', '3A病棟');

INSERT INTO departments (dpts_symbol, dpts_name) 
VALUES ('ward3B', '3B病棟');

INSERT INTO departments (dpts_symbol, dpts_name) 
VALUES ('ward4A', '4A病棟');

INSERT INTO departments (dpts_symbol, dpts_name) 
VALUES ('ward4B', '4B病棟');

INSERT INTO departments (dpts_symbol, dpts_name) 
VALUES ('kensa', '検査科');

INSERT INTO departments (dpts_symbol, dpts_name) 
VALUES ('qq', '救急');

INSERT INTO departments (dpts_symbol, dpts_name) 
VALUES ('gairai', '外来');

INSERT INTO departments (dpts_symbol, dpts_name) 
VALUES ('ward5F', '5F病棟');

/*
ここまで部署のデータ
*/





INSERT INTO vaccineorders (vacc_date, ptid, vacc_symbol, vacc_event, vacc_memo) 
VALUES ('2021-12-19', '35668', 'influadlt', 'not_vaccinated', '午前来院');

INSERT INTO vaccineorders (vacc_date, ptid, vacc_symbol, vacc_event, vacc_memo) 
VALUES ('2021-12-19', '3789843', 'influchld', 'vaccinated', '');


INSERT INTO vaccineorders (vacc_date, ptid, vacc_symbol, vacc_event, vacc_memo) 
VALUES ('2021-12-19', '797723', 'influchld', 'vaccinated', '');


INSERT INTO vaccineorders (vacc_date, ptid, vacc_symbol, vacc_event, vacc_memo) 
VALUES ('2021-12-20', '542712', 'pfzCOVID19adlt', 'vaccinated', '午後来院');

/*
ここまで接種歴でーた
*/



/*
INSERT INTO vaccineterms (vacc_term_symbol, vacc_term_name, vacc_startdate, vacc_goaldate)
VALUES ('Jan2022', '2021年1月', '2022-01-01', '2022-01-31');
*/

/*
ここまでワクチンたーむ
*/


INSERT INTO vaccinecountsshusei (vacc_date, vacc_type, vacccount_event, vacccount_count, vacccount_memo) 
VALUES ('2021-12-01', 'influ', 'nyuka', '100', '薬剤部に入荷');

INSERT INTO vaccinecountsshusei (vacc_date, vacc_type, vacccount_event, vacccount_count, vacccount_memo) 
VALUES ('2021-12-10', 'influ', 'haraidashi', '-10', '分院へ払い出し');

INSERT INTO vaccinecountsshusei (vacc_date, vacc_type, vacccount_event, vacccount_count, vacccount_memo) 
VALUES ('2021-12-02', 'influ', 'nyuka', '15', '薬剤部に少しだけ入荷');

/*
カウント修正データためしに　
*/

