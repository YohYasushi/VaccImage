<?php require dirname(__FILE__) . '/files/header.php';?>
<?php require_once dirname(__FILE__) . '/files/mariadbconnect.php';?>
<?php require_once dirname(__FILE__) . '/files/funcUtils.php';?>
<?php require_once dirname(__FILE__) . '/files/funcShowVaccines.php';?>

<input type="button" value="画面更新" onClick="location.reload()">

<h2>ワクチン日付別一覧出力</h2>

<?php

$vacc_date = funcTrimFormsH($_POST['vacc_date']);
$vacc_type = funcTrimFormsH($_POST['vacc_type']);

funcShowVaccines("SELECT * FROM allvaccinesViewVed WHERE vacc_date = '$vacc_date' AND vacc_type = '$vacc_type';")

?>

<div class="annotation">接種済み患者の日付別の出力です。</div>

<?php require dirname(__FILE__) . '/files/footer.php';?>

