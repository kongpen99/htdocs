<?php
include '../../../Include/class/connect_sql.php';
date_default_timezone_set("Asia/Bangkok");
$year_current = date("Y");
$year_month = date("Ym");
$mDBConn = new CSQL;
$server = "172.22.64.11";
$database = 'PCB_NG_DATA';
$hrec = $_POST['hrec_id'];
$mDBConn->connect($server , $database);
$getdata = "SELECT * FROM PCBREC_H_TBL WHERE HREC_ID = '".$hrec."' ";
$mDBConn->Query($getdata);
$getdata2 = $mDBConn->FetchData();
echo json_encode($getdata2);
?>