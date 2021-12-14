--インフルエンザ
CREATE VIEW CountInfluenza
AS
SELECT vaccdate , sum(AdCount), sum(CdCount)
FROM (
SELECT vaccdate, ptid, vaccadlt
,
CASE
WHEN vaccadlt = "インフル大人" THEN 1
ELSE 0
END AS AdCount
,
vaccchld
,
CASE
WHEN vaccchld = "インフル小人" THEN 1
ELSE 0
END AS CdCount
FROM vaccineall
WHERE (vaccevent = '未接種・予約' AND vaccdate >= current_date ) OR (vaccevent = '接種済' AND vaccdate <= current_date ) 
ORDER BY vaccdate
)
AS CountInfluenza
GROUP BY vaccdate;



--ファイザー
CREATE VIEW CountPFECOVID19
AS
SELECT vaccdate , sum(AdCount), sum(CdCount)
FROM (
SELECT vaccdate, ptid, vaccadlt
,
CASE
WHEN vaccadlt = "ファイザー大人" THEN 1
ELSE 0
END AS AdCount
,
vaccchld
,
CASE
WHEN vaccchld = "ファイザー小人" THEN 1
ELSE 0
END AS CdCount
FROM vaccineall
WHERE (vaccevent = '未接種・予約' AND vaccdate >= current_date ) OR (vaccevent = '接種済' AND vaccdate <= current_date ) 
ORDER BY vaccdate
)
AS CountPFECOVID19
GROUP BY vaccdate;


--モデルナ
CREATE VIEW CountMRNACOVID19
AS
SELECT vaccdate , sum(AdCount), sum(CdCount)
FROM (
SELECT vaccdate, ptid, vaccadlt
,
CASE
WHEN vaccadlt = "モデルナ大人" THEN 1
ELSE 0
END AS AdCount
,
vaccchld
,
CASE
WHEN vaccchld = "モデルナ小人" THEN 1
ELSE 0
END AS CdCount
FROM vaccineall
WHERE (vaccevent = '未接種・予約' AND vaccdate >= current_date ) OR (vaccevent = '接種済' AND vaccdate <= current_date ) 
ORDER BY vaccdate
)
AS CountMRNACOVID19
GROUP BY vaccdate;

--アストラゼネカ
CREATE VIEW CountAZNCOVID19
AS
SELECT vaccdate , sum(AdCount), sum(CdCount)
FROM (
SELECT vaccdate, ptid, vaccadlt
,
CASE
WHEN vaccadlt = "モデルナ大人" THEN 1
ELSE 0
END AS AdCount
,
vaccchld
,
CASE
WHEN vaccchld = "モデルナ小人" THEN 1
ELSE 0
END AS CdCount
FROM vaccineall
WHERE (vaccevent = '未接種・予約' AND vaccdate >= current_date ) OR (vaccevent = '接種済' AND vaccdate <= current_date ) 
ORDER BY vaccdate
)
AS CountAZNCOVID19
GROUP BY vaccdate;


--インフルエンザバイアル
CREATE VIEW CountInfluenzaV
AS
SELECT * FROM countshusei WHERE shuseitype = 'インフルエンザ';


--ファイザーバイアル
CREATE VIEW CountPFECOVID19V
AS
SELECT * FROM countshusei WHERE shuseitype = 'ファイザーコロナ';

--モデルナバイアル
CREATE VIEW CountMRNACOVID19V
AS
SELECT * FROM countshusei WHERE shuseitype = 'モデルナコロナ';


--アストラゼネカバイアル
CREATE VIEW CountAZNCOVID19V
AS
SELECT * FROM countshusei WHERE shuseitype = 'アストラゼネカコロナ';