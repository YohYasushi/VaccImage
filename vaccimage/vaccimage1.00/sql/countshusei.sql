CREATE TABLE countshusei (

shuseiid INT NOT NULL AUTO_INCREMENT,
shuseidate DATE NOT NULL, 
shuseitype  VARCHAR(30) NOT NULL, 
shuseievent  VARCHAR(30) NOT NULL, 
shuseicount  INT NOT NULL,
shuseimemo VARCHAR(200),
PRIMARY KEY(shuseiid)

);