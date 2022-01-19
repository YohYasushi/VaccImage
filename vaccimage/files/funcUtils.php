<?php

//＜判定＞に関する関数

// 空欄判定 Trimしても0なら空欄 1ならなんかある ってこと。
function funcEmptyJudge(string $value): int {
  $value = trim($value); //funcTrimFormsHでもTrimしているけど漏れ防止のため
  if ($value != null) {
    $isEmpty = 1;
   }
   else{
  $isEmpty = 0;
  }
  return $isEmpty;
};

// 英数字の判定 英数字以外なら0
function funcChkEngNum(string $value): int {
  if (preg_match("/^[a-zA-Z0-9]+$/", $value)) {
      $isEngNum = 1;
  } 
  else{
    $isEngNum = 0;
  }
  return $isEngNum;
};



// 日付の判定 不適切な日付なら0
function funcChkDate(string $value): int {
  list($year, $month, $day) = explode('-', $value);
  if (checkdate($month, $day, $year)) {
    $isDate = 1;
   }
   else{
  $isDate = 0;
  }
  return $isDate;
};

//LISTMAKEに関して、SQLの中に含まれているかどうかのチェック
function funcChckList(string $value ,string $a, string $b): int
{
$ArraySQL = array();
$isList = 0;

$db = getDb();
$sql = $a;
$stt = $db->prepare($sql);
$stt->execute();

foreach($stt as $row)
{  
  $ArraySQL[] = h($row[$b]);
}
if (in_array($value, $ArraySQL)) {
  $isList = 1;
 }
 else{
$isList = 0;
}
return $isList;
};


//＜変換＞
// Shift-JISからUTF-8へのチェックと変換
// どの型式からもUTF-8にする、のは無理みたい
function funcCvrtEncode(string $value): string {
  if(mb_check_encoding($value)){
    $result = $value;
  }
  else{
    $result = mb_convert_encoding($value, 'UTF-8',  'Shift-JIS');
  }
  return $result;
};


// HTMLチャート変換
function h(string $value): string {
  $result =  htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
  return $result;
};

// 頭とケツの空白を消去した機能を追加+h関数を追加した『Trimの最終の関数』
function funcTrimFormsH(string $value): string {
  $value = funcCvrtEncode($value);
  $result = trim($value);
  $result = h($result);
  return $result;
};


//SQLの結果表示のための関数
function funcQueryExp(string $a, string $b): void
{
    
$db = getDb();
$sql = $a;
$stt = $db->prepare($sql);
$stt->execute();

foreach($stt as $row)
{  
    echo '', h($row[$b]) ,'';
}
};
//一応、スカラー量で使うことを想定しております
// funcQueryExp('SELECT SUM(TotalVials) FROM VialCountsInflu;', 'SUM(TotalVials)'); のように使う



//ListをDBから引用するためだけの関数　テーブルの全体構造はHTML側で作るように。
function funcListMake(string $a, string $b, string $c): void
{
    
$db = getDb();
$sql = $a;
$stt = $db->prepare($sql);
$stt->execute();

foreach($stt as $row)
{  

    echo '<option value="', h($row[$b]) , '">';
    echo '', h($row[$c]) , '</option>';
 
}
};



