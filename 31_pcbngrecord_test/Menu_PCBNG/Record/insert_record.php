<?php
session_start();
error_reporting(0);
include '../../../Include/class/connect_sql.php';
include "../../00_function/update_code_cd.php";
date_default_timezone_set("Asia/Bangkok");
$year_current = date("Y");
$year_month = date("Ym");
$conn = new CSQL;
$server = "172.22.64.11";
$db = "PCB_NG_DATA";
$conn->connect($server, $db);

$empcode = $_POST['code_emp'];
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
$qty = $_POST['qty'];
$position = $_POST['position'];
$ref = $_POST['ref'];

$response = array();

$replace_problem = str_replace("'", "/", $problem);
$replace_cause = str_replace("'", "/", $cause);
$replace_action = str_replace("'", "/", $action);

// array_push($response, $empcode);
// array_push($response, $line);
// array_push($response, $customer);
// array_push($response, $workord);
// array_push($response, $mdcode);
// array_push($response, $mdname);
// array_push($response, $case);
// array_push($response, $process);
// array_push($response, $problem);
// array_push($response, $cause);
// array_push($response, $action);
// array_push($response, $serial);
// array_push($response, $qty);
// array_push($response, $position);
// array_push($response, $ref);


/**
 * *ใส่ข้อมูล serial จำนวนหลาย serial
 */
$dataserial = "";
$ssize = sizeof($serial) - 1;
for ($i = 0; $i < sizeof($serial); $i++) {

    $dataserial .= $serial[$i];
    if ($i < $ssize) {
        $dataserial .= ',';
    }
}

$HREC = "SELECT * FROM [WEB_CODECD_TBL] WHERE CODE_CD = 'HREC'";
$conn->Query($HREC);
$HREC2 = $conn->FetchData();
$SET_HREC = FN_SET_RUNNO($HREC2[0]['CODE_RUNNO'], $year_month, $HREC2[0]['CODE_CD'], 6);

/**
 * TODO : 2024-02-21
 * * เพิ่มเงื่อนไขมาเพื่อมาตรวจสอบรหัสพนง. 2 ท่าน
 * * 3061061    = flow outsource-ems
 * * 2950224    = flow outsource-ems 
 * * อื่น ๆ       = flow ปกติที่ควรจะเป็น
 */
if ($empcode == '3061061') {

    $select_flow = "SELECT * FROM APPROVE_H_TBL  WHERE ARRRH_DEPT = 'OUTSOURCE' AND APPRH_STD = 1";
    $conn->Query($select_flow);
    $flow = $conn->FetchData();

    $insert = "INSERT INTO [dbo].[PCBREC_H_TBL] 
        ([HREC_ID],
        [HREC_SEC],
        [HREC_CUS],
        [HREC_LINE],       
        [HREC_MDLCD],
        [HREC_MDLNM],
        [HREC_WON],
        [HREC_QTY],
        [HREC_NGCASE],
        [HREC_NGPROCESS],
        [HREC_PROBLEM],
        [HREC_CAUSE],
        [HREC_ACTION],
        [HREC_EMP],
        [HREC_EMP_DREC],
        [HREC_EMP_DTREC],
        [HREC_SERIAL],
        [HREC_STD],
        [APPRH_ID],
        [HREC_NG_POSITION],
        [HREC_APPRH_TRACKING],
        [HREC_REF_DOC])
        VALUES (
        '" . $SET_HREC . "',
        'OUTSOURCE',
        '" . $customer . "',
        '" . $line . "',      
        '" . $mdcode . "',
        '" . $mdname . "',
        '" . $workord . "',
        '" . $qty . "',        
        '" . $case . "',
        '" . $process . "',
        N'" . $replace_problem . "',
        N'" . $replace_cause . "',
        N'" . $replace_action . "',
        '" . $empcode . "',
        getdate(),
        getdate(),
        '" . $dataserial . "',
        '0',
        '" . $flow[0]['APPRH_ID'] . "',
        '" . $position . "',
        1,
        '" . $ref . "')";
    $conn->Query($insert);
} else if ($empcode == '2950224') {

    $select_flow = "SELECT * FROM APPROVE_H_TBL  WHERE ARRRH_DEPT = 'OUTSOURCE' AND APPRH_STD = 1";
    $conn->Query($select_flow);
    $flow = $conn->FetchData();

    $insert = "INSERT INTO [dbo].[PCBREC_H_TBL] 
        ([HREC_ID],
        [HREC_SEC],
        [HREC_CUS],
        [HREC_LINE],       
        [HREC_MDLCD],
        [HREC_MDLNM],
        [HREC_WON],
        [HREC_QTY],
        [HREC_NGCASE],
        [HREC_NGPROCESS],
        [HREC_PROBLEM],
        [HREC_CAUSE],
        [HREC_ACTION],
        [HREC_EMP],
        [HREC_EMP_DREC],
        [HREC_EMP_DTREC],
        [HREC_SERIAL],
        [HREC_STD],
        [APPRH_ID],
        [HREC_NG_POSITION],
        [HREC_APPRH_TRACKING],
        [HREC_REF_DOC])
        VALUES (
        '" . $SET_HREC . "',
        'OUTSOURCE',
        '" . $customer . "',
        '" . $line . "',      
        '" . $mdcode . "',
        '" . $mdname . "',
        '" . $workord . "',
        '" . $qty . "',        
        '" . $case . "',
        '" . $process . "',
        N'" . $replace_problem . "',
        N'" . $replace_cause . "',
        N'" . $replace_action . "',
        '" . $empcode . "',
        getdate(),
        getdate(),
        '" . $dataserial . "',
        '0',
        '" . $flow[0]['APPRH_ID'] . "',
        '" . $position . "',
        1,
        '" . $ref . "')";
    $conn->Query($insert);
} else {

    $select_flow = "SELECT * FROM APPROVE_H_TBL  WHERE ARRRH_DEPT = '" . $_SESSION['emp_sec'] . "' AND APPRH_STD = 1";
    $conn->Query($select_flow);
    $flow = $conn->FetchData();

    $insert = "INSERT INTO [dbo].[PCBREC_H_TBL] 
        ([HREC_ID],
        [HREC_SEC],
        [HREC_CUS],
        [HREC_LINE],       
        [HREC_MDLCD],
        [HREC_MDLNM],
        [HREC_WON],
        [HREC_QTY],
        [HREC_NGCASE],
        [HREC_NGPROCESS],
        [HREC_PROBLEM],
        [HREC_CAUSE],
        [HREC_ACTION],
        [HREC_EMP],
        [HREC_EMP_DREC],
        [HREC_EMP_DTREC],
        [HREC_SERIAL],
        [HREC_STD],
        [APPRH_ID],
        [HREC_NG_POSITION],
        [HREC_APPRH_TRACKING],
        [HREC_REF_DOC])
        VALUES (
        '" . $SET_HREC . "',
        '" . $_SESSION['emp_sec'] . "',
        '" . $customer . "',
        '" . $line . "',      
        '" . $mdcode . "',
        '" . $mdname . "',
        '" . $workord . "',
        '" . $qty . "',        
        '" . $case . "',
        '" . $process . "',
        N'" . $replace_problem . "',
        N'" . $replace_cause . "',
        N'" . $replace_action . "',
        '" . $empcode . "',
        getdate(),
        getdate(),
        '" . $dataserial . "',
        '0',
        '" . $flow[0]['APPRH_ID'] . "',
        '" . $position . "',
        1,
        '" . $ref . "')";
    $conn->Query($insert);
}

$select_app = "SELECT * FROM APPROVE_D_TBL WHERE APPRH_ID = '" . $flow[0]['APPRH_ID'] . "' ";
$conn->Query($select_app);
$app = $conn->FetchData();

for ($i = 0; $i < sizeof($app); $i++) {

    $HAPPR = "SELECT * FROM [WEB_CODECD_TBL] WHERE CODE_CD = 'HAPPR'";
    $conn->Query($HAPPR);
    $HAPPR2 = $conn->FetchData();
    $SET_HAPPR = FN_SET_RUNNO($HAPPR2[0]['CODE_RUNNO'], $year_month, $HAPPR2[0]['CODE_CD'], 6);

    $insert2 = "INSERT INTO [dbo].[PCBREC_APPROVE_TBL]
        ([HREC_ID]
        ,[APPRH_ID]
        ,[HAPPR_ID]
        ,[HAPPR_SEQ]
        ,[HAPPR_EMP]
        ,[HAPPR_STD]
        )
        VALUES
        ('" . $SET_HREC . "',
        '" . $flow[0]['APPRH_ID'] . "',
        '" . $SET_HAPPR . "',
        '" . $app[$i]['APPRD_SEQ'] . "',
        '" . $app[$i]['APPRD_EMPID'] . "',
        0)";
    $conn->Query($insert2);

    $year_original = date_format($HAPPR2[0]['CODE_LSTDT'], "Y");
    if ($year_original == $year_current) {
        $RUNNO = $HAPPR2[0]['CODE_RUNNO'] + 1;
        UPDATE_RUNNO($RUNNO, $conn, 'HAPPR');
    } else {
        $RUNNO = 1;
        UPDATE_RUNNO($RUNNO, $conn, 'HAPPR');
    }
}

$year_original = date_format($HREC2[0]['CODE_LSTDT'], "Y");
if ($year_original == $year_current) {
    $RUNNO = $HREC2[0]['CODE_RUNNO'] + 1;
    UPDATE_RUNNO($RUNNO, $conn, 'HREC');
} else {
    $RUNNO = 1;
    UPDATE_RUNNO($RUNNO, $conn, 'HREC');
}
// header('Location: menu.php');
echo json_encode(true);
