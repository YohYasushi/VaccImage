<?php require dirname(__FILE__) . '/files/header.php';?>
<?php require_once dirname(__FILE__) . '/files/mariadbconnect.php';?>
<?php require_once dirname(__FILE__) . '/files/funcUtils.php';?>

<?php

$db = getDb();
$db->beginTransaction(); 

$vacc_date = funcTrimFormsH($_POST['vacc_date']);
$vacc_type = funcTrimFormsH($_POST['vacc_type']);
$vacccount_event = funcTrimFormsH($_POST['vacccount_event']);
$vacccount_count = funcTrimFormsH($_POST['vacccount_count']);
$vacccount_memo = funcTrimFormsH($_POST['vacccount_memo']);

// ここでトリム関数でふるいにかけたあと値を代入

$FullHantei
= funcEmptyJudge($vacc_date)
+ funcEmptyJudge($vacc_type)
+ funcEmptyJudge($vacccount_event)
+ funcEmptyJudge($vacccount_count);
//空欄がないか判定


if ( ($FullHantei == 4)
and (funcChkDate($vacc_date) == 1)
and (funcChckList($vacc_type,'SELECT * FROM vaccinetypes;', 'vacc_type', 'vacc_typename' ) == 1)
and (funcChckList($vacccount_event,'SELECT * FROM vaccinecountevents;', 'vacccount_event', 'vacccount_eventjp' ) == 1)
and is_numeric($vacccount_count) == true
) {

  try {
    $stt = $db->prepare('INSERT INTO vaccinecountsshusei (vacc_date, vacc_type, vacccount_event, vacccount_count, vacccount_memo) VALUES(:vacc_date, :vacc_type, :vacccount_event, :vacccount_count, :vacccount_memo)');
    $stt->bindValue(':vacc_date', $_POST['vacc_date']);
    $stt->bindValue(':vacc_type', $_POST['vacc_type']);
    $stt->bindValue(':vacccount_event', $_POST['vacccount_event']);
    $stt->bindValue(':vacccount_count', $_POST['vacccount_count']);
    $stt->bindValue(':vacccount_memo', $_POST['vacccount_memo']);
    $stt->execute();
    $db->commit();
    echo "カウント修正データを" , $stt->rowCount(),  "件、挿入しました。タブを閉じ、元の画面の「画面更新」ボタンを押してください。<br>";
  
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

