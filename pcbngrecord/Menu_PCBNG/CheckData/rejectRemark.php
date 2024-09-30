<?php
session_start();
include '../../../Include/class/connect_sql.php';
$conn = new CSQL;
$server = "172.22.64.11";
$db = "PCB_NG_DATA";
$conn->connect($server, $db);


$id = $_GET['hrec_id'];
$entertext  = $_GET['remark'];
$stdrj = $_GET['rejectstd'];

$stdrj = 1;

//** ดึงข้อมูล tracking จาก HREC_ID */
$rejectstd = "SELECT [HREC_APPRH_TRACKING] FROM PCBREC_H_TBL WHERE HREC_ID = '" . $id."'";
$conn->Query($rejectstd);
$rj = $conn->FetchData();


/**
 * TODO: ดึงสถานะการ reject มาตรวจสอบเงื่อนไข
 */
$stdRject  ="SELECT * FROM PCBREC_H_TBL WHERE HREC_ID = '".$id."'";
$conn->Query($stdRject);
$rject = $conn->FetchData();

$prevtracking = $rj[0]['HREC_APPRH_TRACKING']  - 1;



//** อัพเดทสถานะการ approve เมื่อลำดับอื่น reject */
$updatestdapp = "UPDATE [PCBREC_APPROVE_TBL] SET HAPPR_STD = '2' WHERE HREC_ID = '" . $id."' AND HAPPR_SEQ ='".$prevtracking."'";
$conn->Query($updatestdapp);

//** อัพเดทข้อความเหตุผมการ Reject , เปลี่ยนสถานะการ reject , เปลี่ยนสถานะ tracking */
$remark = "UPDATE [PCBREC_H_TBL] SET HREC_REJECT_REMARK = N'".$entertext."' , HREC_REJECT_STD = '".$stdrj."' , HREC_APPRH_TRACKING='".$prevtracking."' WHERE HREC_ID = '" . $id."'";
$conn->Query($remark);





$std = array('std'=> true);


echo json_encode($std);
?>