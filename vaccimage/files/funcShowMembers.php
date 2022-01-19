<?php 
require_once dirname(__FILE__) . '/mariadbconnect.php';

function funcShowMembers(string $a): void
{

echo '<table>';
echo '<tr>';
echo '<th>患者ID</th><th>苗字</th><th>名前</th><th>誕生日</th><th>年齢</th><th>分類</th><th>部署</th><th>ボタン</th>';
echo '</tr>';


$db = getDb();
$sql = $a;
$stt = $db->prepare($sql);
$stt->execute();
foreach($stt as $row)  {  

  echo '<tr>';
  echo '<td>', h($row['ptid']) , '</td>';
  echo '<td>', h($row['last_name']), '</td>';
  echo '<td>', h($row['first_name']), '</td>';
  echo '<td>', h($row['birthday']), '</td>';
  echo '<td>', h($row['age']), '</td>';
  echo '<td>', h($row['ptype_name']), '</td>';
  echo '<td>', h($row['dpts_name']), '</td>';
  echo '<td>', '<form action="PagePtPersonal.php" method="post" target="_blank"><button type="submit" name="ptid" value=" ', h($row['ptid']) ,'">個人画面</button></form>', '</td>';
  echo '</tr>';

}
  
echo '</table>';



}

//現在の誕生日での年齢を示す。物故者への対応は？ allmembersViewに対応している。
