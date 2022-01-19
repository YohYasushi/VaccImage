CREATE TABLE vaccinetypes (

vacc_symbol VARCHAR(30) NOT NULL,
vacc_name VARCHAR(30) NOT NULL,
vacc_typename VARCHAR(30) NOT NULL,
vacc_type VARCHAR(30) NOT NULL,
vacc_adltchld VARCHAR(10) NOT NULL,
vacc_dose INT NOT NULL,
vacc_totalvialdose INT NOT NULL,
PRIMARY KEY(vacc_symbol)

);

INSERT INTO vaccinetypes (vacc_symbol, vacc_name, vacc_typename, vacc_type, vacc_adltchld, vacc_dose, vacc_totalvialdose)
VALUES ('influadlt', 'インフルエンザ大人', 'インフルエンザ', 'influ','adlt', '2', '4');

INSERT INTO vaccinetypes (vacc_symbol, vacc_name, vacc_typename, vacc_type, vacc_adltchld, vacc_dose, vacc_totalvialdose)
VALUES ('influchld', 'インフルエンザ子供', 'インフルエンザ', 'influ','chld', '1', '4');

INSERT INTO vaccinetypes (vacc_symbol, vacc_name, vacc_typename, vacc_type, vacc_adltchld, vacc_dose, vacc_totalvialdose)
VALUES ('pfzCOVID19adlt', 'ファイザーコロナ大人', 'ファイザーコロナ', 'pfzCOVID19','adlt', '3', '18');

INSERT INTO vaccinetypes (vacc_symbol, vacc_name, vacc_typename, vacc_type, vacc_adltchld, vacc_dose, vacc_totalvialdose)
VALUES ('pfzCOVID19chld', 'ファイザーコロナ子供', 'ファイザーコロナ', 'pfzCOVID19','chld', '1', '18');

INSERT INTO vaccinetypes (vacc_symbol, vacc_name, vacc_typename, vacc_type, vacc_adltchld, vacc_dose, vacc_totalvialdose)
VALUES ('mrnaCOVID19adlt', 'モデルナコロナ大人', 'モデルナコロナ', 'mrnaCOVID19','adlt', '2', '20');

INSERT INTO vaccinetypes (vacc_symbol, vacc_name, vacc_typename, vacc_type, vacc_adltchld, vacc_dose, vacc_totalvialdose)
VALUES ('mrnaCOVID19adltAdd', 'モデルナコロナ大人追加', 'モデルナコロナ', 'mrnaCOVID19','adlt', '1', '20');

INSERT INTO vaccinetypes (vacc_symbol, vacc_name, vacc_typename, vacc_type, vacc_adltchld, vacc_dose, vacc_totalvialdose)
VALUES ('aznCOVID19adlt', 'アストラゼネカコロナ大人', 'アストラゼネカコロナ', 'aznCOVID19','adlt', '1', '10');



/*
ここまでワクチンでーた
設定変更はSQLのみから
*/