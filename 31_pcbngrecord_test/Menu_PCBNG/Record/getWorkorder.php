<?php
include '../../../Include/class/connect_sql.php';
date_default_timezone_set("Asia/Bangkok");
$year_current = date("Y");
$year_month = date("Ym");
$conn = new CSQL;
$server = "172.22.64.11";
$database = 'PCB_NG_DATA';
$cus = $_POST['cus'];
$conn->connect($server , $database);
$getdata = "SELECT  LTRIM(RTRIM([WON])) AS [WON] , [MDLCD] , [MDLNM] FROM [VWORLIST2] WHERE BGCD = '".$cus."'";
$conn->Query($getdata);
$getdata2 = $conn->FetchData();
if(!empty($getdata2)){
    $rest = array('std' => true, 'data' => $getdata2);
}else{
    $rest = array('std' => false);
}
echo json_encode($rest);
?>