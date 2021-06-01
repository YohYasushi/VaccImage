<?php require dirname(__FILE__) . '/files/header.php';?>
<?php require_once dirname(__FILE__) . '/files/mariadbconnect.php';?>

<?php

$db = getDb();
$db->beginTransaction();


$id = $_POST['id'];

try {
  $stt = $db->prepare('UPDATE vaccineall SET vaccevent=\'接種済\' WHERE id = :id');
  $stt->bindValue(':id', $id);
  $stt->execute();
  $db->commit();

 echo "データを" ,$stt->rowCount(), "件、接種済にしました。タブを閉じて元ページの「画面更新」をクリックしてください。<br>";


} catch(PDOException $e) {
  $db->rollback();
  //echo "エラーメッセージ：{$e->getMessage()}";
}

?>

<?php require dirname(__FILE__) . '/files/footer.php';?>