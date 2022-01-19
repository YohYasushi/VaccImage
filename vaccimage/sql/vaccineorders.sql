CREATE TABLE vaccineorders (

id INT NOT NULL AUTO_INCREMENT,
vacc_date DATE NOT NULL, 
ptid  INT NOT NULL,
vacc_symbol VARCHAR(30) NOT NULL,
vacc_event  VARCHAR(30) NOT NULL, 
vacc_memo VARCHAR(300),
PRIMARY KEY(id)

);

/*
ワクチンオーダーの要。
*/