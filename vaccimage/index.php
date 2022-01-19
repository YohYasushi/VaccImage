<?php require dirname(__FILE__) . '/files/header.php';?>
<?php require_once dirname(__FILE__) . '/files/funcUtils.php';?>
<?php require_once dirname(__FILE__) . '/files/funcShowVaccines.php';?>

<h1>VaccImage</h1>

<input type="button" value="画面更新" onClick="location.reload()">

<br>


<h2>過去の未接種</h2>

<?php

funcShowVaccines("SELECT * FROM allvaccinesView WHERE vacc_event = 'not_vaccinated' AND vacc_date <  CURDATE();")

?>

<h2>未来日の接種済み</h2>

<?php

funcShowVaccines("SELECT * FROM allvaccinesView WHERE vacc_event = 'vaccinated' AND vacc_date > CURDATE();")

?>

<div class="annotation">ここに出力されている患者は、オーダー修正をしてください。</div>


<?php require dirname(__FILE__) . '/files/footer.php';?>