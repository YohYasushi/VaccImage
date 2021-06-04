<?php require dirname(__FILE__) . '/files/header.php';?>
<?php require_once dirname(__FILE__) . '/files/funcShowAllMember.php';?>
<input type="button" value="画面更新" onClick="location.reload()">
<?php

if ($_POST['ptid_s'] === null) {
  echo 'TopPageへ';
}
else {


$ptid = '%' . $_POST['ptid_s'] . '%'; 
$last_name = '%' . $_POST['last_name_s'] . '%'; 
$first_name = '%' . $_POST['first_name_s'] . '%'; 
$birthday = $_POST['birthday_s']; 
$department = '%' . $_POST['department_s'] . '%'; 


if ( $birthday != null ){
  showAllMember("SELECT * FROM allmember WHERE ptid like '$ptid' and last_name like '$last_name' and first_name like '$first_name'and department like '$department' and birthday = '$birthday';  ");

}else {
  
  showAllMember("SELECT * FROM allmember WHERE ptid like '$ptid' and last_name like '$last_name' and first_name like '$first_name' and department like '$department'; ");

}

}
?>

<?php require dirname(__FILE__) . '/files/footer.php';?>