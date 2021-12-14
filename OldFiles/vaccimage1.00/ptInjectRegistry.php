<?php require dirname(__FILE__) . '/files/header.php';?>
<?php require_once dirname(__FILE__) . '/files/mariadbconnect.php';?>


<script type="text/javascrirpt"><!--

function orderMiniOpen(){

}

//--></script>

<input type="button" value="画面更新" onClick="location.reload()">


<h2>患者情報</h2>

<table>
<tr>
<th>ptID</th><th>苗字</th><th>名前</th><th>誕生日</th><th>年齢</th><th>種別・所属部署</th>
</tr>

<?php
$ptid = $_POST['ptid_ss'];

$db = getDb();
$sql = "SELECT * FROM allmember WHERE ptid = '$ptid' ";
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
  
  
    }
//患者情報表示欄ここまで。
?>


</table>

<h2>オーダー欄</h2>

<form action="vaccRegistry.php" method="post">
<table>
<tr>
<th>接種・予約日付</th>
<th>大人</th>
<th>小人</th>
<th>接種状況</th>
<th>メモ</th>
<th>ボタン</th>
</tr>
<td><input type="date" name="vaccdate"></td>
<td>
<select name="vaccadlt">
<optgroup label="大人">
 <option value=""></option>
 <option value="インフル大人">インフル大人</option>
 <option value="ファイザー大人">ファイザー大人</option>
 <option value="モデルナ大人">モデルナ大人</option>
</select>
</td>
<td>
<select name="vaccchld">
<optgroup label="小人">
 <option value=""></option>
 <option value="インフル小人">インフル小人</option>
 <option value="ファイザー小人">ファイザー小人</option>
 <option value="モデルナ小人">モデルナ小人</option>
</select></td>
<td>
<input type="radio" value="接種済" name="vaccevent">接種済<br>
<input type="radio" value="未接種・予約" name="vaccevent">未接種・予約
</td>
<td><textarea name="memo" rows="2" cols="30"></textarea></td>
<td><input type="submit" value="送信"><input type="reset" value="クリア"></td>
</tr>

<?php

echo '<input type="hidden" name="ptid" value="', htmlspecialchars($row['ptid']), '" >';  
echo '<input type="hidden" name="last_name" value="', htmlspecialchars($row['last_name']), '" >';  
echo '<input type="hidden" name="first_name" value="', htmlspecialchars($row['first_name']), '" >';  
echo '<input type="hidden" name="birthday" value="', htmlspecialchars($row['birthday']), '" >';
echo '<input type="hidden" name="department" value="', htmlspecialchars($row['department']), '" >';

?>
</table>
</form>

<h2>オーダー履歴</h2>

<?php

echo '<table>';
echo '<tr>';
echo '<th>接種日付</th><th>ワクチン大人</th><th>ワクチン小人</th><th>接種状況</th><th>ptID</th><th>苗字</th><th>名前</th><th>誕生日</th><th>年齢</th><th>種別・所属部署</th><th>メモ</th><th>ボタン</th>' ;
echo '</tr>';

$db = getDb();
$sql = "SELECT * FROM vaccineall WHERE ptid = '$ptid' order by vaccdate asc";
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
    echo '<td>', '<form action="vaccCondChange.php" target="_blank" method="post"><button type="submit" name="id" value=" ', htmlspecialchars($row['id']) ,'">接種済にする</button></form>';
    echo  '<form action="vaccDelete.php" target="_blank" method="post"><button type="submit" name="id" value=" ', htmlspecialchars($row['id']) ,'">オーダー削除</button></form>', '</td>';
    echo '</tr>';

  }

echo '</table>';

?>

<div class="annotation">安全のためオーダーの変更は設けておりません。変更の場合はいったん削除してから入力し直してください。</div>

<?php require dirname(__FILE__) . '/files/footer.php';?>

