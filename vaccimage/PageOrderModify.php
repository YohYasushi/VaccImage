<?php require dirname(__FILE__) . '/files/header.php';?>
<?php require_once dirname(__FILE__) . '/files/mariadbconnect.php';?>
<?php require_once dirname(__FILE__) . '/files/funcShowMembers.php';?>
<?php require_once dirname(__FILE__) . '/files/funcShowVaccines.php';?>
<?php require_once dirname(__FILE__) . '/files/funcUtils.php';?>

<input type="button" value="画面更新" onClick="location.reload()">

<br>

<h2>患者情報</h2>

<?php
$id = funcTrimFormsH($_POST['id']);
?>


<?php
$db = getDb();
$sql = "SELECT * FROM allvaccinesView WHERE id = $id;";
$stt = $db->prepare($sql);
$stt->execute();
foreach($stt as $row) {   

  echo h($row['ptid']);
  echo h($row['last_name']);
  echo h($row['first_name']);
  echo h($row['vacc_age']);
}
?>



<h2>オーダー修正</h2>

<table>
<tr>
<th>接種日付</th><th>ワクチン名</th><th>接種状況</th><th>めも</th>
</tr>

<?php
$db = getDb();
$sql = "SELECT * FROM allvaccinesView WHERE id = $id;";
$stt = $db->prepare($sql);
$stt->execute();
foreach($stt as $row)  {  


  echo '<td>', h($row['vacc_date']) , '</td>';
  echo '<td>', h($row['vacc_name']) , '</td>';
  echo '<td>', h($row['vacc_cond']) , '</td>';
  echo '<td>', h($row['vacc_memo']) , '</td>';
  echo '<td>', '<form action="subPageOrderModifyVed.php" method="post" target="_blank"><button type="submit" name="id" value=" ', h($row['id']) ,'">接種済み にする</button></form>', '</td>';
  echo '<td>', '<form action="subPageOrderModifyDelete.php" method="post" target="_blank"><button type="submit" name="id" value=" ', h($row['id']) ,'">削除</button></form>', '</td>';

}
?>

</table>


<div class="annotation">オーダー変更のページ。</div>

<?php require dirname(__FILE__) . '/files/footer.php';?>


<!-- 接種済みにするボタン　削除ボタン　めも追加　日付変更　ワクチン種類変更はしない