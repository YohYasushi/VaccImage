<?php require dirname(__FILE__) . '/files/header.php';?>
<?php require_once dirname(__FILE__) . '/files/funcShowMembers.php';?>
<?php require_once dirname(__FILE__) . '/files/funcUtils.php';?>
<?php


$ptid = funcTrimFormsH($_POST['ptid']);
$last_name = funcTrimFormsH($_POST['last_name']);
$first_name = funcTrimFormsH($_POST['first_name']);
$ptype_symbol = funcTrimFormsH($_POST['ptype_symbol']);
$dpts_symbol = funcTrimFormsH($_POST['dpts_symbol']);

$FullHanteiNyuRyoku
= funcEmptyJudge($ptid)
+ funcEmptyJudge($last_name)
+ funcEmptyJudge($first_name);

$FullHanteiList
= funcEmptyJudge($ptype_symbol)
+ funcEmptyJudge($dpts_symbol);

/*
funcChkEngNum($ptid) != 1
(funcChckList($ptype_symbol,'SELECT ptype_symbol FROM persontypes;', 'ptype_symbol') != 1) OR
(funcChckList($dpts_symbol,'SELECT dpts_symbol FROM departments;', 'dpts_symbol') != 1)
*/


if( ($FullHanteiNyuRyoku != 0) AND ($FullHanteiList == 0) )
{
    funcShowMembers("SELECT * FROM allmembersView WHERE ptid like '%$ptid%' AND last_name like '%$last_name%' AND first_name like '%$first_name%';");
}
elseif((funcEmptyJudge($ptype_symbol) == 1) AND (funcEmptyJudge($dpts_symbol) == 0))
{
    funcShowMembers("SELECT * FROM allmembersView WHERE ptid like '%$ptid%' AND last_name like '%$last_name%' AND first_name like '%$first_name%' AND ptype_symbol = '$ptype_symbol';");
}

elseif((funcEmptyJudge($ptype_symbol) == 0) AND (funcEmptyJudge($dpts_symbol) == 1))
{
    funcShowMembers("SELECT * FROM allmembersView WHERE ptid like '%$ptid%' AND last_name like '%$last_name%' AND first_name like '%$first_name%' AND dpts_symbol = '$dpts_symbol';");
}

elseif($FullHanteiList == 2)
{
    funcShowMembers("SELECT * FROM allmembersView WHERE ptid like '%$ptid%' AND last_name like '%$last_name%' AND first_name like '%$first_name%' AND ptype_symbol = '$ptype_symbol' AND dpts_symbol = '$dpts_symbol';");
}
else{
echo 'データ出力できませんでした。';
}

?>

<?php require dirname(__FILE__) . '/files/footer.php';?>