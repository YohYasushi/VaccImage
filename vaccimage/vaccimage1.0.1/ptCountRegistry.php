<?php require dirname(__FILE__) . '/files/header.php';?>
<?php require_once dirname(__FILE__) . '/files/mariadbconnect.php';?>

<?php

$db = getDb();
$db->beginTransaction();

try {
  $stt = $db->prepare('INSERT INTO countshusei(shuseidate, shuseitype, shuseievent, shuseicount, shuseimemo) VALUES(:shuseidate, :shuseitype, :shuseievent, :shuseicount, :shuseimemo);');
  $stt->bindValue(':shuseidate', $_POST['shuseidate']);
  $stt->bindValue(':shuseitype', $_POST['shuseitype']);
  $stt->bindValue(':shuseievent', $_POST['shuseievent']);
  $stt->bindValue(':shuseicount', $_POST['shuseicount']);
  $stt->bindValue(':shuseimemo', $_POST['shuseimemo']);
  $stt->execute();
  $db->commit();
  echo "バイアル修正・入荷データを" , $stt->rowCount(),  "件、挿入しました。タブを閉じてください。<br>";

} catch(PDOException $e) {
  $db->rollback();
 // echo "エラーメッセージ：{$e->getMessage()}"; 

}


?>
<?php require dirname(__FILE__) . '/files/footer.php';?>
