<?php require dirname(__FILE__) . '/files/header.php';?>
<?php require_once dirname(__FILE__) . '/files/mariadbconnect.php';?>

<?php

$db = getDb();
$db->beginTransaction();

try {
  $stt = $db->prepare('INSERT INTO vaccineall(vaccdate, ptid, last_name, first_name, birthday, department, vaccadlt, vaccchld, vaccevent, memo) 
  VALUES(:vaccdate, :ptid, :last_name, :first_name, :birthday, :department, :vaccadlt, :vaccchld, :vaccevent, :memo)');
  $stt->bindValue(':ptid', $_POST['ptid']);
  $stt->bindValue(':last_name', $_POST['last_name']);
  $stt->bindValue(':first_name', $_POST['first_name']);
  $stt->bindValue(':birthday', $_POST['birthday']);
  $stt->bindValue(':department', $_POST['department']);
  $stt->bindValue(':vaccdate', $_POST['vaccdate']);
  $stt->bindValue(':vaccadlt', $_POST['vaccadlt']);
  $stt->bindValue(':vaccchld', $_POST['vaccchld']);
  $stt->bindValue(':vaccevent', $_POST['vaccevent']);
  $stt->bindValue(':memo', $_POST['memo']);
  $stt->execute();
  $db->commit();

 echo "接種データを" ,$stt->rowCount(), "件、挿入しました。タブを閉じてください。<br>";


} catch(PDOException $e) {
  $db->rollback();
  //echo "エラーメッセージ：{$e->getMessage()}";
}

?>

<?php require dirname(__FILE__) . '/files/footer.php';?>
