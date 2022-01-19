<?php require dirname(__FILE__) . '/files/header.php';?>
<?php require_once dirname(__FILE__) . '/files/mariadbconnect.php';?>
<?php require_once dirname(__FILE__) . '/files/funcUtils.php';?>

<?php

$db = getDb();
$db->beginTransaction();

$id = funcTrimFormsH($_POST['id']);

{ $stt = $db->prepare("DELETE FROM vaccineorders WHERE id = :id");
  $stt->bindValue(':id', $id);
  $stt->execute();
  $db->commit();

 echo "データを" ,$stt->rowCount(), "件、削除しました。タブを閉じて元ページの「画面更新」をクリックしてください。<br>";
}


