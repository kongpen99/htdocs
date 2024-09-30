<?php
include '../../../Include/class/connect_sql.php';
date_default_timezone_set("Asia/Bangkok");
$conn = new CSQL;
$server = "172.22.64.11";
$db = "PCB_NG_DATA";
$conn->connect($server, $db);

$problem = $_POST['problem'];
$cause = $_POST['cause'];
$action = $_POST['action'];
$ref = $_POST['ref'];
$id = $_POST['id'];

$update = "UPDATE PCBREC_H_TBL SET HREC_PROBLEM = N'".$problem."' , HREC_CAUSE = N'".$cause."' ,
    HREC_ACTION = N'".$action."' ,HREC_REF_DOC = '" . $ref . "', HREC_LSTDT = GETDATE() WHERE HREC_ID = '" . $id . "'";
$conn->Query($update);

echo json_encode(true);
?>