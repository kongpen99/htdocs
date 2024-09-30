<?php
session_start();
error_reporting(0);
include '../../../Include/class/connect_sql.php';
$conn = new CSQL;
$server = "172.22.64.11";
$db = "PCB_NG_DATA";
$conn->connect($server, $db);

$id = $_GET['hrec_id'];

$dlp = "DELETE FROM PCBREC_APPROVE_TBL WHERE HREC_ID = '".$id."'";
$conn->Query($dlp);

$dlp2 = "DELETE FROM PCBREC_H_TBL WHERE HREC_ID = '".$id."' ";
$conn->Query($dlp2);

$std = array('std'=> true);


echo json_encode($std);
?>