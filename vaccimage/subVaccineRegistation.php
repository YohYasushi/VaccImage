<?php require dirname(__FILE__) . '/files/header.php';?>
<?php require_once dirname(__FILE__) . '/files/mariadbconnect.php';?>
<?php require_once dirname(__FILE__) . '/files/funcUtils.php';?>

<?php

$db = getDb();
$db->beginTransaction();

$vacc_date = funcTrimFormsH($_POST['vacc_date']);
$ptid = funcTrimFormsH($_POST['ptid']);
$vacc_symbol = funcTrimFormsH($_POST['vacc_symbol']);
$vacc_event = funcTrimFormsH($_POST['vacc_event']);
$vacc_memo = funcTrimFormsH($_POST['vacc_memo']);
// ここでトリム関数でふるいにかけたあと値を代入

$FullHantei
= funcEmptyJudge($vacc_date)
+ funcEmptyJudge($ptid)
+ funcEmptyJudge($vacc_symbol)
+ funcEmptyJudge($vacc_event);
//メモ以外の空欄を判断する

if ( ($FullHantei == 4) 
and (funcChkEngNum($ptid) == 1) 
and  (funcChkDate($vacc_date) == 1)
and (funcChckList($vacc_symbol,'SELECT vacc_symbol FROM vaccinetypes;', 'vacc_symbol') ==1 )
and (funcChckList($vacc_event,'SELECT vacc_event FROM vaccineevents;', 'vacc_event') == 1)

) {

  try {
    $stt = $db->prepare('INSERT INTO vaccineorders(vacc_date, ptid, vacc_symbol, vacc_event, vacc_memo) VALUES(:vacc_date, :ptid, :vacc_symbol, :vacc_event, :vacc_memo)');
    $stt->bindValue(':vacc_date', $vacc_date);
    $stt->bindValue(':ptid', $ptid);
    $stt->bindValue(':vacc_symbol', $vacc_symbol);
    $stt->bindValue(':vacc_event', $vacc_event);
    $stt->bindValue(':vacc_memo', $vacc_memo);
    $stt->execute();
    $db->commit();
  
   echo "接種データを" ,$stt->rowCount(), "件、挿入しました。タブを閉じ、元の画面の「画面更新」ボタンを押してください。<br>";
  
  
  } catch(PDOException $e) {
    $db->rollback();
    //echo "エラーメッセージ：{$e->getMessage()}";
  }

}
else{
  echo 'データは入力できませんでした。';
}
// 総合判定 日付 PtIDが英数字化 など





?>

<?php require dirname(__FILE__) . '/files/footer.php';?>
