<?php
include "../../../Include/class/connect_sql.php";
$mDBConn = new CSQL;
$server = '172.22.64.11';
$database = 'PRODOC';
$mDBConn->connect($server , $database);
date_default_timezone_set("Asia/Bangkok");
$mcType = $_POST['mctype'];

//* หาเครื่องจักรผลิตที่เกี่ยวข้องกับโซนที่เลือก
$mc = "SELECT * FROM [MMC_TBL] WHERE [MMC_DESC] = '".$mcType."'ORDER BY [MMC_NAME] ASC";
$mDBConn->Query($mc);
$mc2 = $mDBConn->FetchData();


if(!empty($mc2)) {
    $array_data = array('std' => true , 'mc' => $mc2);
} else {
    $array_data = array('std' => false , 'mc' => null);
}
echo json_encode($array_data);
?>