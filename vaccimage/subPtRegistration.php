<?php require dirname(__FILE__) . '/files/header.php';?>
<?php require_once dirname(__FILE__) . '/files/mariadbconnect.php';?>
<?php require_once dirname(__FILE__) . '/files/funcUtils.php';?>

<?php

$db = getDb();
$db->beginTransaction(); 

$ptid = funcTrimFormsH($_POST['ptid']);
$last_name = funcTrimFormsH($_POST['last_name']);
$first_name = funcTrimFormsH($_POST['first_name']);
$birthday = funcTrimFormsH($_POST['birthday']);
$ptype_symbol = funcTrimFormsH($_POST['ptype_symbol']);
$dpts_symbol = funcTrimFormsH($_POST['dpts_symbol']);
// ここでトリム関数でふるいにかけたあと値を代入

$FullHantei
= funcEmptyJudge($ptid)
+ funcEmptyJudge($last_name)
+ funcEmptyJudge($first_name)
+ funcEmptyJudge($birthday)
+ funcEmptyJudge($ptype_symbol)
+ funcEmptyJudge($dpts_symbol);
//空欄がないか判定


if ( ($FullHantei == 6)
and (funcChkEngNum($ptid) == 1)
and  (funcChkDate($birthday) == 1)
and (funcChckList($ptype_symbol,'SELECT ptype_symbol FROM persontypes;', 'ptype_symbol') == 1)
and (funcChckList($dpts_symbol,'SELECT dpts_symbol FROM departments;', 'dpts_symbol') == 1)
) {

  try {
    $stt = $db->prepare('INSERT INTO allmembers(ptid, last_name, first_name, birthday, ptype_symbol, dpts_symbol) VALUES(:ptid, :last_name, :first_name, :birthday , :ptype_symbol, :dpts_symbol)');
    $stt->bindValue(':ptid', $_POST['ptid']);
    $stt->bindValue(':last_name', $_POST['last_name']);
    $stt->bindValue(':first_name', $_POST['first_name']);
    $stt->bindValue(':birthday', $_POST['birthday']);
    $stt->bindValue(':ptype_symbol', $_POST['ptype_symbol']);
    $stt->bindValue(':dpts_symbol', $_POST['dpts_symbol']);
    $stt->execute();
    $db->commit();
    echo "患者データを" , $stt->rowCount(),  "件、挿入しました。タブを閉じてください。<br>";
  
  } catch(PDOException $e) {
    $db->rollback();
    // echo "エラーメッセージ：{$e->getMessage()}"; 
  
  }

} 
else{
  echo 'データは入力できませんでした。';
}
// 総合判定とInsert



?>
<?php require dirname(__FILE__) . '/files/footer.php';?>

