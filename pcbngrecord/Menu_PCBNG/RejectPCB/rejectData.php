<?php
include '../../../Include/class/connect_sql.php';
$conn = new CSQL;
$server = "172.22.64.11";
$db = "PCB_NG_DATA";
$conn->connect($server, $db);

$line = $_POST['line'];
$customer = $_POST['customer'];
$workord = $_POST['wo'];
$mdcode = $_POST['md_code'];
$mdname = $_POST['md_name'];
$case  = $_POST['cases'];
$process = $_POST['process'];
$problem  = $_POST['problem'];
$cause = $_POST['cause'];
$action = $_POST['action'];
$serial = $_POST['serial'];
$position = $_POST['position'];
$qty = $_POST['qty'];
$id = $_POST['id'];
$ref = $_POST['ref'];




/**
 * *: อัพเดทข้อมูลตอนถูก reject กลับมา , เพิ่มการอัพเดท ref doc.
 */

$update = "UPDATE PCBREC_H_TBL 
SET HREC_LINE = '" . $line . "' ,
HREC_CUS = '" . $customer . "' , 
HREC_WON = '" . $workord . "' , 
HREC_MDLCD = '" . $mdcode . "' , 
HREC_MDLNM = '" . $mdname . "' , 
HREC_NGCASE = '" . $case . "' , 
HREC_NGPROCESS = '" . $process . "' , 
HREC_PROBLEM = N'" . $problem . "' , 
HREC_CAUSE = N'" . $cause . "' ,
HREC_ACTION = N'" . $action . "' , 
HREC_SERIAL = '" . $serial . "' , 
HREC_QTY = '" . $qty . "' , 
HREC_REJECT_STD = 0,
HREC_LSTDT = GETDATE(),
HREC_REF_DOC = '" . $ref . "' WHERE HREC_ID = '" . $id . "'";
$conn->Query($update);


$update2 = "UPDATE PCBREC_APPROVE_TBL SET HAPPR_STD = 0 , HAPPR_LSTDT = GETDATE() WHERE HAPPR_ID = '" . $id . "'";
$conn->Query($update2);

echo json_encode(true);
