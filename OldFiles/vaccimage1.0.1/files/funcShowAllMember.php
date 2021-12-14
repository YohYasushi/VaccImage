<?php 
//DBへのコネクトのクラスインポート
require_once dirname(__FILE__) . '/mariadbconnect.php';

function showAllMember(string $a): void
{

echo '<table>';
echo '<tr>';
echo '<th>ptID</th><th>苗字</th><th>名前</th><th>誕生日</th><th>年齢</th><th>種別・所属部署</th><th>ボタン</th>';
echo '</tr>';


$db = getDb();
$sql = $a;
$stt = $db->prepare($sql);
$stt->execute();
foreach($stt as $row) {   
  
      echo '<tr>';
      echo '<td>', htmlspecialchars($row['ptid']) , '</td>';
      echo '<td>', htmlspecialchars($row['last_name']), '</td>';
      echo '<td>', htmlspecialchars($row['first_name']), '</td>';
      echo '<td>', htmlspecialchars($row['birthday']), '</td>';
      echo '<td>', floor((date("Ymd") - intval(str_replace("-", "", htmlspecialchars($row['birthday']))))/10000), '</td>';
      echo '<td>', htmlspecialchars($row['department']), '</td>';
      echo '<td>', '<form action="ptInjectRegistry.php" method="post"><button type="submit" name="ptid_ss" value=" ', htmlspecialchars($row['ptid']) ,'">患者画面へ</button></form>', '</td>';
      echo '</tr>';
}
  
echo '</table>';

//オブジェクト形式も考慮を。

}