CREATE TABLE vaccinecountsshusei (

vacccount_id INT NOT NULL AUTO_INCREMENT,
vacc_date DATE NOT NULL, 
vacc_type VARCHAR(30) NOT NULL,
vacccount_event  VARCHAR(30) NOT NULL, 
vacccount_count  INT NOT NULL,
vacccount_memo VARCHAR(300),
PRIMARY KEY(vacccount_id)

);

/*

*/