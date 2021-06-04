<?php require dirname(__FILE__) . '/files/header.php';?>
<?php require_once dirname(__FILE__) . '/files/mariadbconnect.php';?>

<?php

$db = getDb();
$db->beginTransaction();

try {
  $stt = $db->prepare('INSERT INTO allmember(ptid, last_name, first_name, birthday, department) VALUES(:ptid, :last_name, :first_name, :birthday, :department)');
  $stt->bindValue(':ptid', $_POST['ptid']);
  $stt->bindValue(':last_name', $_POST['last_name']);
  $stt->bindValue(':first_name', $_POST['first_name']);
  $stt->bindValue(':birthday', $_POST['birthday']);
  $stt->bindValue(':department', $_POST['department']);
  $stt->execute();
  $db->commit();
  echo "患者データを" , $stt->rowCount(),  "件、挿入しました。タブを閉じてください。<br>";

} catch(PDOException $e) {
  $db->rollback();
 // echo "エラーメッセージ：{$e->getMessage()}"; 

}


?>
<?php require dirname(__FILE__) . '/files/footer.php';?>
