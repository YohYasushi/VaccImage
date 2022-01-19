<?php require dirname(__FILE__) . '/files/header.php';?>
<?php require_once dirname(__FILE__) . '/files/mariadbconnect.php';?>
<?php require_once dirname(__FILE__) . '/files/funcUtils.php';?>
<?php require_once dirname(__FILE__) . '/files/funcShowVaccines.php';?>
<?php require_once dirname(__FILE__) . '/files/funcShowMembers.php';?>

<input type="button" value="画面更新" onClick="location.reload()">

<br>

<?php
$ptid = funcTrimFormsH($_POST['ptid']);
?>


<h2>患者情報</h2>

<?php

$db = getDb();
$sql = "SELECT * FROM allmembersView WHERE ptid = $ptid;";
$stt = $db->prepare($sql);
$stt->execute();
foreach($stt as $row) {   

  echo h($row['ptid']);
  echo h($row['last_name']);
  echo h($row['first_name']);
  echo h($row['birthday']);
  echo h($row['age']);

}

?>


<h2>おーだー</h2>
<form action="subVaccineRegistation.php" method="post" target="_blank">
<table>
<tr>
<th>日付</th><th>ワクチン名</th><th>接種状況</th><th>めも</th><th>ボタン</th>
</tr>

<tr>
<td><input type="date" name="vacc_date">
</td>

<td>
<select name="vacc_symbol">
<option value=""></option>
<?php
funcListMake('SELECT * FROM vaccinetypes;', 'vacc_symbol', 'vacc_name' );
?>
</select>
</td>

<td>
<select name="vacc_event">
<option value=""></option>
<?php
funcListMake('SELECT * FROM vaccineevents;', 'vacc_event', 'vacc_cond' );
?>
</select>
</td>

<td><textarea name="vacc_memo" rows="2" cols="30"></textarea></td>


<td><input type="submit" value="送信"><input type="reset" value="クリア"></td>
</tr>

<?php
echo '<input type="hidden" name="ptid" value="', h($row['ptid']), '" >';  
?>
</table>
</form>



<h2>おーだー一覧出力</h2>

<?php 

funcShowVaccines("SELECT * FROM allvaccinesView WHERE ptid = $ptid;")

?>



<div class="annotation">個人のぺーじ。準備</div>

<?php require dirname(__FILE__) . '/files/footer.php';?>


<!-- 