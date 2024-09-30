<?php
include "../../../Include/class/connect_sql.php";
$mDBConn = new CSQL;
$server = '172.22.64.11';
$database = 'PRODOC';
$mDBConn->connect($server , $database);
date_default_timezone_set("Asia/Bangkok");
$zone = $_POST['zone'];
$dochtype = $_POST['dochtype'];

//* หาไลน์ผลิตที่เกี่ยวข้องกับโซนที่เลือก
$line = "SELECT * FROM [MLINE_TBL] WHERE [MLINE_ZONE] = '".$zone."'ORDER BY [MLINE_NAME] ASC";
$mDBConn->Query($line);
$line2 = $mDBConn->FetchData();

//* หาเครื่องจักรผลิตที่เกี่ยวข้องกับโซนที่เลือก
$mc = "SELECT * FROM [MMC_TBL] WHERE [MMC_ZONE] = '".$zone."'ORDER BY [MMC_NAME] ASC";
$mDBConn->Query($mc);
$mc2 = $mDBConn->FetchData();

//* หาประเภทเครื่องจักร
$type_mc = "SELECT DISTINCT ([MMC_DESC]) FROM [MMC_TBL] WHERE MMC_ZONE = '".$zone."'";
$mDBConn->Query($type_mc);
$type_mc2 = $mDBConn->FetchData();

if(!empty($line2) && !empty($mc2)) {
    $array_data = array('std' => true , 'line' => $line2 , 'mc' => $mc2 , 'type_mc' => $type_mc2);
} else {
    $array_data = array('std' => false , 'line' => null , 'mc' => null , 'type_mc' => null);
}
echo json_encode($array_data);
?>