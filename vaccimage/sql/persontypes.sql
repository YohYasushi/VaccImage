CREATE TABLE persontypes (

ptype_symbol VARCHAR(120) NOT NULL,
ptype_name VARCHAR(120) NOT NULL,
PRIMARY KEY(ptype_symbol)

);

INSERT INTO persontypes (ptype_symbol, ptype_name) 
VALUES ('outpt', '外来患者');

INSERT INTO persontypes (ptype_symbol, ptype_name) 
VALUES ('inpt', '入院患者');

INSERT INTO persontypes (ptype_symbol, ptype_name) 
VALUES ('staff', '職員');

INSERT INTO persontypes (ptype_symbol, ptype_name) 
VALUES ('stafffamily', '職員家族');

