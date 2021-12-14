<?php 
require_once dirname(__FILE__) . '/mariadbconnect.php';

function showVaccineAllPtBtn(string $v): void
 {

echo '<table>';
echo '<tr>';
echo '<th>接種日付</th><th>ワクチン大人</th><th>ワクチン小人</th><th>接種状況</th><th>ptID</th><th>苗字</th><th>名前</th><th>誕生日</th><th>年齢</th><th>種別・所属部署</th><th>メモ</th>' ;
echo '</tr>';


$db = getDb();
$sql = $v;
$stt = $db->prepare($sql);
$stt->execute();
foreach($stt as $row)  {  

  

    echo '<tr>';
    echo '<td>', htmlspecialchars($row['vaccdate']) , '</td>';
    echo '<td>', htmlspecialchars($row['vaccadlt']), '</td>';
    echo '<td>', htmlspecialchars($row['vaccchld']), '</td>';
    echo '<td>', htmlspecialchars($row['vaccevent']), '</td>';
    echo '<td>', htmlspecialchars($row['ptid']) , '</td>';
    echo '<td>', htmlspecialchars($row['last_name']), '</td>';
    echo '<td>', htmlspecialchars($row['first_name']), '</td>';
    echo '<td>', htmlspecialchars($row['birthday']), '</td>';
    echo '<td>', floor((date("Ymd") - intval(str_replace("-", "", htmlspecialchars($row['birthday']))))/10000), '</td>';
    echo '<td>', htmlspecialchars($row['department']), '</td>';
    echo '<td>', htmlspecialchars($row['memo']), '</td>';
    echo '<td>', '<form action="ptInjectRegistry.php" target="_blank" method="post"><button type="submit" name="ptid_ss" value=" ', htmlspecialchars($row['ptid']) ,'">患者画面へ</button></form>', '</td>';
    echo '</tr>';

  }

echo '</table>';


//患者画面にいくボタンのもの。ptid_ssで受け取って、"ptinjectregistry.php"に渡す機能を備えたボタン。
}

