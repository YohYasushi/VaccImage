create database vaccimage;
use vaccimage;

\. /opt/lampp/htdocs/vaccimage/sql/allmembers.sql
\. /opt/lampp/htdocs/vaccimage/sql/departments.sql
\. /opt/lampp/htdocs/vaccimage/sql/initsetupLinux.sql
\. /opt/lampp/htdocs/vaccimage/sql/persontypes.sql
\. /opt/lampp/htdocs/vaccimage/sql/vaccinecountevents.sql
\. /opt/lampp/htdocs/vaccimage/sql/vaccinecountsshusei.sql
\. /opt/lampp/htdocs/vaccimage/sql/vaccineevents.sql
\. /opt/lampp/htdocs/vaccimage/sql/vaccineorders.sql
\. /opt/lampp/htdocs/vaccimage/sql/vaccineterms.sql
\. /opt/lampp/htdocs/vaccimage/sql/vaccinetypes.sql


/* VIEW一覧 */

CREATE VIEW allmembersView
AS 
SELECT AL.ptid, AL.last_name, AL.first_name, AL.birthday, 
FLOOR((REPLACE(current_date(), '-', '') - REPLACE(birthday, '-', ''))/10000) as age,
PT.ptype_name, PT.ptype_symbol, DP.dpts_name, DP.dpts_symbol
FROM allmembers AS AL INNER JOIN persontypes AS PT
ON AL.ptype_symbol = PT.ptype_symbol
    INNER JOIN departments AS DP
        ON AL.dpts_symbol = DP.dpts_symbol;
/*
allmembersView で部署と分類を日本語化している
年齢も出している。
allmembers + persontypes + departments 
*/

CREATE VIEW allvaccinesView
AS
SELECT
VO.id, VO.vacc_date, VO.ptid, AL.last_name, AL.first_name, 
AL.birthday, 
FLOOR((REPLACE(vacc_date, '-', '') - REPLACE(birthday, '-', ''))/10000) as vacc_age,
VT.vacc_name, VE.vacc_cond, VO.vacc_memo, VT.vacc_type, VE.vacc_event
FROM vaccineorders AS VO INNER JOIN vaccinetypes AS VT
ON VO.vacc_symbol = VT.vacc_symbol
    INNER JOIN vaccineevents AS VE
        ON VO.vacc_event = VE.vacc_event
            INNER JOIN allmembers AS AL
                ON VO.ptid = AL.ptid
                order by vacc_date;
/*
ワクチンの一覧の表示のため　日本語での表示のためだけ
ワクチン接種時の年齢も出している。
接種も未接種も一覧している。
vaccineorders + vaccinetypes + vaccineevents + allmembers
ワクチンタイプと接種状況は英語で入れてある
*/


CREATE VIEW allvaccinesViewVed
AS
select * from allvaccinesView where vacc_date <= CURDATE() and vacc_event = 'vaccinated'
UNION
select * from allvaccinesView where vacc_date > CURDATE() and vacc_event = 'not_vaccinated'
order by vacc_date;
/*
当日&過去の接種済み と 未来日の未接種 の統合UNION allvaccinesViewをもとにして
*/



CREATE VIEW allvaccinesCountsView
AS
SELECT  VO.id, VO.vacc_date, VO.ptid, VO.vacc_symbol, VO.vacc_event, VT.vacc_type, VT.vacc_adltchld, VT.vacc_dose, VT.vacc_totalvialdose
FROM vaccineorders AS VO INNER JOIN vaccinetypes AS VT
ON VO.vacc_symbol = VT.vacc_symbol
ORDER BY vacc_date;
/*
まずカウントの元になるビュー　数字と記号しかない
*/


CREATE VIEW allvaccinesCountsViewVed
AS
select * from allvaccinesCountsView where vacc_date <= CURDATE() and vacc_event = 'vaccinated'
UNION
select * from allvaccinesCountsView where vacc_date > CURDATE() and vacc_event = 'not_vaccinated'
order by vacc_date;
/*
当日&過去の接種済み と 未来日の未接種 の統合UNION allvaccinesCountsViewをもとにして
*/



CREATE VIEW VialCountsVed
AS
SELECT vacc_date, vacc_type, sum(vacc_dose), 
SUM( CASE when vacc_adltchld = 'adlt' THEN 1 ELSE 0 END ) AS AdultCounts,
SUM( CASE when vacc_adltchld = 'chld' THEN 1 ELSE 0 END ) AS ChildCounts,
vacc_totalvialdose,
sum(vacc_dose) / vacc_totalvialdose AS Devide,
sum(vacc_dose) DIV vacc_totalvialdose AS SeisuuOfDevide,
CASE
WHEN (sum(vacc_dose) % vacc_totalvialdose) = 0 THEN (sum(vacc_dose) DIV vacc_totalvialdose)
ELSE (sum(vacc_dose) DIV vacc_totalvialdose)+1
END AS TotalVials
,

CASE
WHEN (sum(vacc_dose) % vacc_totalvialdose) = 0 THEN 0
ELSE (vacc_totalvialdose - (sum(vacc_dose) % vacc_totalvialdose)) 
END AS RemainderPoints
FROM allvaccinesCountsViewVed
GROUP by vacc_date, vacc_type;
/*
合計バイアル数と破棄バイアルを計算
大人と子供の接種人数(ポイントじゃなくて！)も計算しているので、一覧表にも使用可能
横方向の計算のみしかしてません。
縦方向の計算は、ワクチン種類を区切らないでおこなわないほうがいい
*/



