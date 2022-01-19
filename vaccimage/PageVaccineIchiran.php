<?php require dirname(__FILE__) . '/files/header.php';?>
<?php require_once dirname(__FILE__) . '/files/mariadbconnect.php';?>
<?php require_once dirname(__FILE__) . '/files/funcUtils.php';?>

<h1>ワクチン種別一覧出力</h1>

<form action="subVaccineIchiran.php" method="post" target="_blank">

<table>

<tr>
<td>ワクチン種別</td>
<td>
<select name="vacc_type">

<?php
funcListMake('SELECT * FROM vaccinetypes;', 'vacc_type', 'vacc_typename' );
?>
</select>
</td>
</tr>


<tr>
<td>ボタン</td>
<td><input type="submit" value="送信"><input type="reset" value="クリア"></td>
</tr>

</table>
</form>

<div class="annotation">ワクチン種類を選択してください</div>
<div class="annotation">ワクチン種類が2つずつ出力されますが、エラーではありません。</div>

<?php require dirname(__FILE__) . '/files/footer.php';?>