<?php 
require_once dirname(__FILE__) . '/mariadbconnect.php';

function funcShowVaccines(string $a): void
{

echo '<table>';
echo '<tr>';
echo '<th>接種日付</th><th>患者ID</th><th>苗字</th><th>名前</th><th>誕生日</th><th>接種時年齢</th><th>ワクチン名</th><th>接種状況</th><th>めも</th><th>ボタン</th>';
echo '</tr>';


$db = getDb();
$sql = $a;
$stt = $db->prepare($sql);
$stt->execute();
foreach($stt as $row)  {  

  echo '<tr>';
  echo '<td>', h($row['vacc_date']) , '</td>';
  echo '<td>', h($row['ptid']) , '</td>';
  echo '<td>', h($row['last_name']) , '</td>';
  echo '<td>', h($row['first_name']) , '</td>';
  echo '<td>', h($row['birthday']) , '</td>';
  echo '<td>', h($row['vacc_age']) , '</td>';
  echo '<td>', h($row['vacc_name']) , '</td>';
  echo '<td>', h($row['vacc_cond']) , '</td>';
  echo '<td>', h($row['vacc_memo']) , '</td>';
  echo '<td>', '<form action="PageOrderModify.php" method="post" target="_blank"><button type="submit" name="id" value=" ', h($row['id']) ,'">オーダー修正画面</button></form>', '</td>';
  echo '</tr>';
  
}

echo '</table>';

}



//現在の誕生日での年齢を示す。物故者への対応は？ allvaccinesView　および　allvaccinesViewVed　に対応している。