<?php require dirname(__FILE__) . '/files/header.php';?>
<?php require_once dirname(__FILE__) . '/files/mariadbconnect.php';?>
<?php require_once dirname(__FILE__) . '/files/funcUtils.php';?>

<?php

$db = getDb();
$db->beginTransaction();

$vacccount_id = funcTrimFormsH($_POST['vacccount_id']);

{ $stt = $db->prepare("DELETE FROM vaccinecountsshusei WHERE vacccount_id = :vacccount_id");
  $stt->bindValue(':vacccount_id', $vacccount_id);
  $stt->execute();
  $db->commit();

 echo "データを" ,$stt->rowCount(), "件、削除しました。タブを閉じて元ページの「画面更新」をクリックしてください。<br>";
}


