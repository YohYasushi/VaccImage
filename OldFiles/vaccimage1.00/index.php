<?php require dirname(__FILE__) . '/files/header.php';?>
<?php require_once dirname(__FILE__) . '/files/funcShowVaccineAllPtBtn.php';?>

<input type="button" value="画面更新" onClick="location.reload()">

<h1>接種の全体状況</h1>
<div class="annotation">本日のワクチン接種の状況を把握するためのページです。こちらがTopPageです。</div>

<h2>本日の接種予定者</h2>
<?php
ShowVaccineAllPtBtn("SELECT * FROM vaccineall WHERE vaccdate = current_date() AND vaccevent = '未接種・予約' ;");
?>


<h2>本日の接種済者</h2>
<?php
ShowVaccineAllPtBtn("SELECT  * FROM vaccineall WHERE vaccdate = current_date() AND vaccevent = '接種済' ;");
?>

<h2>過去の未接種者</h2>
<div class="annotation">接種・未接種の確認を行ってください。未接種の方の予約は削除してください。</div>
<?php
ShowVaccineAllPtBtn("SELECT  * FROM vaccineall WHERE vaccdate < current_date() AND vaccevent = '未接種・予約' ORDER BY vaccdate ASC ;");
?>

<h2>未来日の接種済者</h2>
<div class="annotation">必ず訂正してください。</div>

<?php
ShowVaccineAllPtBtn("SELECT  * FROM vaccineall WHERE vaccdate > current_date() AND vaccevent = '接種済' ORDER BY vaccdate ASC ;");
?>

<?php require dirname(__FILE__) . '/files/footer.php';?>