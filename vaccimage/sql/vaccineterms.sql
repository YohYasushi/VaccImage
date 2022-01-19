CREATE TABLE vaccineterms (

vacc_term_symbol VARCHAR(30) NOT NULL,
vacc_term_name VARCHAR(30) NOT NULL,
vacc_startdate DATE NOT NULL, 
vacc_goaldate DATE NOT NULL, 
PRIMARY KEY(vacc_term_symbol)

);

/* 
ワクチンカウントの区切りのため。
*/
