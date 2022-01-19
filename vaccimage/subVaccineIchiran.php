<?php require dirname(__FILE__) . '/files/header.php';?>
<?php require_once dirname(__FILE__) . '/files/mariadbconnect.php';?>
<?php require_once dirname(__FILE__) . '/files/funcUtils.php';?>

<input type="button" value="画面更新" onClick="location.reload()">

<?php
$vacc_type = funcTrimFormsH($_POST['vacc_type']);
?>


<h2>バイアルの状況</h2>

<table>
<tr>
<tr><th>日付</th><th>ワクチン種</th><th>大人</th><th>小人</th><th>1日の合計バイアル</th><th>合計バイアル累計</th><th>破棄ポイント</th><th>破棄ポイント累計</th></tr>
</tr>

<?php

$db = getDb();
$sql = "SELECT vacc_date, vacc_type, AdultCounts, ChildCounts, 
TotalVials, SUM(TotalVials) OVER (ORDER BY vacc_date) AS SiyouSUM,
RemainderPoints, SUM(RemainderPoints) OVER (ORDER BY vacc_date) AS HakiSUM
FROM VialCountsVed
WHERE vacc_type = '$vacc_type'; ";
$stt = $db->prepare($sql);
$stt->execute();
foreach($stt as $row)  {  

  echo '<tr>';
  echo '<td>', h($row['vacc_date']) , '</td>';
  echo '<td>', h($row['vacc_type']) , '</td>';
  echo '<td>', h($row['AdultCounts']) , '</td>';
  echo '<td>', h($row['ChildCounts']) , '</td>';
  echo '<td>', h($row['TotalVials']) , '</td>';
  echo '<td>', h($row['SiyouSUM']) , '</td>';
  echo '<td>', h($row['RemainderPoints']) , '</td>';
  echo '<td>', h($row['HakiSUM']) , '</td>';
  echo '<td>', '<form action="subsubVaccineIchiran.php" method="post" target="_blank"><button type="submit" name="vacc_date" value=" ', h($row['vacc_date']) ,'">この日のオーダー</button><input type="hidden" name="vacc_type" value=" ', h($row['vacc_type']) ,'"></form>', '</td>';
  echo '</tr>';

}

?>
</table>

<h2>バイアル入荷・払い出し経過(未来日含む)</h2>

<table>
<tr>
<tr><th>修正日付</th><th>ワクチン種</th><th>イベント</th><th>修正バイアル数</th><th>入荷・払い出しの累積</th><th>メモ</th><th></th></tr>
</tr>

<?php

$db = getDb();
$sql = "SELECT 
vacc_date, vacc_type, vacccount_eventjp, 
vacccount_count, SUM(vacccount_count) OVER (ORDER BY vacc_date) AS NyukaSUM,
vacccount_memo, vacccount_id
FROM
vaccinecountsshusei AS S INNER JOIN vaccinecountevents AS E
ON S.vacccount_event = E.vacccount_event
WHERE vacc_type ='$vacc_type'
ORDER BY vacc_date;" ;
$stt = $db->prepare($sql);
$stt->execute();
foreach($stt as $row)  {  

  echo '<tr>';
  echo '<td>', h($row['vacc_date']) , '</td>';
  echo '<td>', h($row['vacc_type']) , '</td>';
  echo '<td>', h($row['vacccount_eventjp']) , '</td>';
  echo '<td>', h($row['vacccount_count']) , '</td>';
  echo '<td>', h($row['NyukaSUM']) , '</td>';
  echo '<td>', h($row['vacccount_memo']) , '</td>';
  echo '<td>', '<form action="subsubCountsDelete.php" method="post" target="_blank"><button type="submit" name="vacccount_id" value=" ', h($row['vacccount_id']) ,'">削除</button></form>', '</td>'; 
  echo '</tr>';
}

?>
</table>

<h2>まとめ</h2>

<table>
<tr>
<tr><th>日付</th><th>ワクチン種</th><th>バイアル</th><th>バイアル残</th></tr>
</tr>

<?php

$db = getDb();
$sql = "SELECT vacc_date, vacc_type, Vials,
SUM(Vials) OVER (ORDER BY vacc_date) AS FinalAnswer
FROM
(
SELECT vacc_date, vacc_type, -1 * TotalVials AS Vials
FROM VialCountsVed
UNION
SELECT vacc_date, vacc_type, vacccount_count AS Vials
FROM vaccinecountsshusei
ORDER BY vacc_date
) AS VialSemiFinal
WHERE vacc_type = '$vacc_type';";
$stt = $db->prepare($sql);
$stt->execute();
foreach($stt as $row)  {  

  echo '<tr>';
  echo '<td>', h($row['vacc_date']) , '</td>';  
  echo '<td>', h($row['vacc_type']) , '</td>';
  echo '<td>', h($row['Vials']) , '</td>';
  echo '<td>', h($row['FinalAnswer']) , '</td>';
  echo '</tr>';
}

?>
</table>
<div class="annotation">マイナス値は接種による使用や払出、不足を意味します。</div>

<h2>ワクチンバイアルカウント修正</h2>
<form action="subCountsShusei.php" method="post" target="_blank">
<table>
<tr>
<td>日付</td>
<td><input type="date" name="vacc_date"></td>
</tr>

<tr>
<td>イベント</td>
<td>
<select name="vacccount_event">
<option value=""></option>

<?php
funcListMake('SELECT * FROM vaccinecountevents;', 'vacccount_event', 'vacccount_eventjp' );
?>
</select>
</td>
</tr>

<tr>
<td>数値</td>
<td><input type="number" name="vacccount_count"></td>
</tr>

<tr>
<td>めも</td>
<td><textarea name="vacccount_memo" rows="2" cols="30"></textarea></td>
</tr>

<tr>
<td>ボタン</td>
<td><input type="submit" value="送信">
<?php echo '<input type="hidden" name="vacc_type" value="', h($row['vacc_type']) ,'">', ''; ?>
<input type="reset" value="クリア"></td>
</tr>
</table>
</form>

<div class="annotation">ワクチン種別一覧出力のページ</div>

<?php require dirname(__FILE__) . '/files/footer.php';?>


<!-- 確認用のページSELECT 
vacc_date, vacc_type, vacccount_eventjp, 
vacccount_count, SUM(vacccount_count) OVER (ORDER BY vacc_date) AS NyukaSUM,
vacccount_memo, vacccount_id
FROM
vaccinecountsshusei AS S INNER JOIN vaccinecountevents AS E
ON S.vacccount_event = E.vacccount_event, 
WHERE vacc_type = '$vacc_type'
ORDER BY vacc_date; 