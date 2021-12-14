<?php require dirname(__FILE__) . '/files/header.php';?>
<?php require_once dirname(__FILE__) . '/files/funcShowVaccineAllPtBtn.php';?>

<input type="button" value="画面更新" onClick="location.reload()">

<?php

if ($_POST['ptid_os'] === null) {
  echo 'TopPageへ';
}
else {

$vaccdateA = $_POST['vaccdateA_os']; 
$vaccdateB = $_POST['vaccdateB_os']; 
$vaccadlt = '%' . $_POST['vaccadlt_os'] . '%';
$vaccchld = '%' . $_POST['vaccchld_os'] . '%';
$vaccevent = '%' . $_POST['vaccevent_os'] . '%';

$ptid = '%' . $_POST['ptid_os'] . '%'; 
$last_name = '%' . $_POST['last_name_os'] . '%'; 
$first_name = '%' . $_POST['first_name_os'] . '%'; 

$department = '%' . $_POST['department_os'] . '%'; 

$memo = '%' . $_POST['memo_os'] . '%'; 


if ($vaccdateA == null and $vaccdateB == null) {
  showVaccineAllPtBtn("SELECT * FROM vaccineall WHERE vaccadlt like '$vaccadlt' and vaccchld like '$vaccchld' and vaccevent like '$vaccevent' and ptid like '$ptid' and last_name like '$last_name' and first_name like '$first_name' and department like '$department'  and memo like '$memo' ORDER BY vaccdate;  ");
}
elseif ($vaccdateA == null) {
  showVaccineAllPtBtn("SELECT * FROM vaccineall WHERE vaccadlt like '$vaccadlt' and vaccchld like '$vaccchld' and vaccevent like '$vaccevent' and ptid like '$ptid' and last_name like '$last_name' and first_name like '$first_name' and department like '$department'  and memo like '$memo' and vaccdate <='$vaccdateB' ORDER BY vaccdate;  ");  
}
elseif ($vaccdateB == null) {
  showVaccineAllPtBtn("SELECT * FROM vaccineall WHERE vaccadlt like '$vaccadlt' and vaccchld like '$vaccchld' and vaccevent like '$vaccevent' and ptid like '$ptid' and last_name like '$last_name' and first_name like '$first_name' and department like '$department'  and memo like '$memo' and vaccdate >='$vaccdateA' ORDER BY vaccdate;  ");  
} 

elseif ($vaccdateA > $vaccdateB ) {
  showVaccineAllPtBtn("SELECT * FROM vaccineall WHERE vaccadlt like '$vaccadlt' and vaccchld like '$vaccchld' and vaccevent like '$vaccevent' and ptid like '$ptid' and last_name like '$last_name' and first_name like '$first_name' and department like '$department'  and memo like '$memo' and ( vaccdate >='$vaccdateB' and vaccdate <='$vaccdateA') ORDER BY vaccdate;  ");  
} 

else {
  showVaccineAllPtBtn("SELECT * FROM vaccineall WHERE vaccadlt like '$vaccadlt' and vaccchld like '$vaccchld' and vaccevent like '$vaccevent' and ptid like '$ptid' and last_name like '$last_name' and first_name like '$first_name' and department like '$department'  and memo like '$memo' and ( vaccdate >='$vaccdateA' and vaccdate <='$vaccdateB') ORDER BY vaccdate;  ");  
} 


}
?>

<?php require dirname(__FILE__) . '/files/footer.php';?>