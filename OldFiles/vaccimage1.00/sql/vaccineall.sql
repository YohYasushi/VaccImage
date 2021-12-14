CREATE TABLE vaccineall (

 id INT NOT NULL AUTO_INCREMENT,
 vaccdate DATE NOT NULL, 
 ptid   INT NOT NULL,
 last_name  VARCHAR(60) NOT NULL,
 first_name  VARCHAR(60) NOT NULL,
 birthday DATE NOT NULL, 
 department VARCHAR(100),
 vaccadlt  VARCHAR(30), 
 vaccchld  VARCHAR(30), 
 vaccevent  VARCHAR(30) NOT NULL, 
 memo VARCHAR(200),
 PRIMARY KEY(id)

);




