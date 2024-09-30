<?php
include '../../../Include/class/connect_sql.php';
$conn = new CSQL;
$server = "172.22.64.11";
$db = "PCB_NG_DATA";
$conn->connect($server, $db);
$predate = $_POST['Previous'];
$lastdate  = $_POST['Last'];
$selectdata = "SELECT * FROM PCBREC_H_TBL WHERE HREC_EMP_DREC BETWEEN '".$predate."' AND '".$lastdate."'";
$conn->Query($selectdata);
$data = $conn->FetchData();
$getdata = array();
foreach ($data as $row){
    $getdata[] = $row;
}
header('Content-Type: application/json');
echo json_encode($getdata);
?>