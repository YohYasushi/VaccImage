<?php require dirname(__FILE__) . '/files/header.php';?>
<?php require_once dirname(__FILE__) . '/files/mariadbconnect.php';?>
<?php require_once dirname(__FILE__) . '/files/funcUtils.php';?>
<?php require_once dirname(__FILE__) . '/files/funcShowVaccines.php';?>
<?php require_once dirname(__FILE__) . '/files/funcShowMembers.php';?>

<input type="button" value="画面更新" onClick="location.reload()">

<h2>確認用患者一覧出力</h2>

<?php

funcShowMembers('SELECT * FROM allmembersView;')

?>

<h2>ワクチン一覧出力</h2>

<?php

funcShowVaccines('SELECT * FROM allvaccinesView;')

?>





<div class="annotation">確認用のぺーじ。</div>

<?php require dirname(__FILE__) . '/files/footer.php';?>


<!-- 確認用のページ