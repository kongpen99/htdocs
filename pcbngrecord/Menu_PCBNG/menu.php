<?php
session_start();
// include '../Connect/connect.php';
include '../../Include/class/connect_sql.php';
include "../00_function/update_code_cd.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//required files
require '../vendor/phpmailer/phpmailer/src/Exception.php';
require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../vendor/phpmailer/phpmailer/src/SMTP.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);
date_default_timezone_set("Asia/Bangkok");
$year_current = date("Y");
$year_month = date("Ym");
$conn = new CSQL;
$server = "AOTHLP0135\SQLEXPRESS";
$db = "SYS-CHECK";
$conn->connect($server, $db);
$emp_id = $_SESSION['id'];

$sql = "SELECT * FROM USER_TBL";
$conn->Query($sql);
$stmt = $conn->FetchData();

// $ng = "SELECT * FROM NGCASE_MASTER";
// $conn->Query($ng);
// $data1 = $conn->FetchData();

// $processng = "SELECT * FROM PROCESS_MASTER";
// $conn->Query($processng);
// $data2 = $conn->FetchData();

/**
 * * insert ข้อมูลเข้าไปในระบบ
 */

if (isset($_GET['submit'])) {
    $empcode = $_GET['code_emp'];
    $line = $_GET['line'];
    $customer = $_GET['customer'];
    $workord = $_GET['wo'];
    $mdcode = $_GET['md_code'];
    $mdname = $_GET['md_name'];
    $case  = $_GET['cases'];
    $process = $_GET['process'];
    $problem  = $_GET['problem'];
    $cause = $_GET['cause'];
    $action = $_GET['action'];
    $serial = $_GET['serial'];
    $qty = $_GET['qty'];
    $position = $_GET['position'];
    $ref = $_GET['ref'];

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
    // print($dataserial);

    $HREC = "SELECT * FROM [WEB_CODECD_TBL] WHERE CODE_CD = 'HREC'";
    $conn->Query($HREC);
    $HREC2 = $conn->FetchData();
    $SET_HREC = FN_SET_RUNNO($HREC2[0]['CODE_RUNNO'], $year_month, $HREC2[0]['CODE_CD'], 6);

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
        N'" . $problem . "',
        N'" . $cause . "',
        N'" . $action . "',
        '" . $empcode . "',
        getdate(),
        getdate(),
        '" . $dataserial . "',
        '0',
        '" . $flow[0]['APPRH_ID'] . "',
        '" . $position . "',
        1,
        '" . $ref . "')";

    //print($insert);
    $conn->Query($insert);


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

    header('Location: menu.php');
}

/**
 * * การยืนยันอนุมัติข้อมูล และส่งอนุมัติตามลำดับ
 */

if (isset($_GET['submitapp'])) {
    $id = $_GET['hrec_id'];
    $track = $_GET['track'];
    // $stat = "UPDATE [PCBREC_H_TBL] SET HREC_APPRH_TRACKING = 1 WHERE HREC_ID = '" . $id . "'";
    // $conn->Query($stat);
    //print($track);
    if ($track == 4) {
        $stat = "UPDATE [PCBREC_H_TBL] SET HREC_STD = 1 WHERE HREC_ID = '" . $id . "'";
        $conn->Query($stat);
        $apptk = "UPDATE [PCBREC_APPROVE_TBL] SET HAPPR_STD = 1 , HAPPR_EMP_APPROVE = '" . $emp_id . "' , HAPPR_LSTDT = GETDATE() WHERE HREC_ID = '" . $id . "' AND HAPPR_SEQ = '" . $track . "'";
        $conn->Query($apptk);
    } else {
        $nexttrack = $track + 1;
        $stat = "UPDATE [PCBREC_H_TBL] SET HREC_APPRH_TRACKING = $nexttrack WHERE HREC_ID = '" . $id . "'";
        $conn->Query($stat);
        $apptk = "UPDATE [PCBREC_APPROVE_TBL] SET HAPPR_STD = 1 , HAPPR_EMP_APPROVE = '" . $emp_id . "' , HAPPR_LSTDT = GETDATE() WHERE HREC_ID = '" . $id . "' AND HAPPR_SEQ = '" . $track . "'";
        $conn->Query($apptk);
        // if ($nexttrack == 4) {
        //     $dts = "SELECT * FROM [PCBREC_H_TBL] AS ph INNER JOIN [PCBREC_APPROVE_TBL] AS pa ON ph.HREC_ID = pa.HREC_ID WHERE ph.HREC_ID = '" . $id . "' AND pa.HAPPR_SEQ = 3";
        //     $conn->Query($dts);
        //     $senddata = $conn->FetchData();
           
        //     try {
        //         $mail = new PHPMailer(true);
        //         $mail->CharSet = "utf-8";

        //         // * ตั้งค่าการส่งอีเมล์ โดยใช้ SMTP ของ โฮสต์
        //         $mail->IsSMTP();
        //         $mail->IsHTML(true);
        //         $mail->Mailer = "smtp";
        //         // * To address and name
        //         // * SMTP Mail Server
        //         $mail->Host = '10.10.10.3';
        //         // * หมายเลข Port สำหรับส่งอีเมล์
        //         $mail->Port = '25';
        //         //Recipients
        //         $mail->setFrom("msl-mail-alert@aoth.in.th", 'fact');
        //         $mail->addAddress('natdanai@aoth.in.th', 'Natdanai');     //Add a recipient
        //         //Optional name

        //         //Content
        //         $mail->Subject = 'PCB-NG Record : แจ้งเตือนผลอนุมัติจากแผนก LC';

        //         $body = "";
        //         $body .= "<p style='font-size: 16px;'>Dear ผ</p>";
        //         $body .= "<p style='font-size: 18px;'>แผนก LC ได้ทำการอนุมัติ PCB NG เป็นที่เรียบร้อยแล้ว</p>";
        //         $body .= "<br>";
        //         $body .= "<table border=1 style='border-collapse:collapse; width:1000px; font-size:20px;'>";
        //         $body .= "<thead style='background-color: #ffbe0b;'>";
        //         $body .= "<tr>";
        //         $body .= "<td>Name</td>";
        //         $body .= "<td>Customer</td>";
        //         $body .= "<td>Line</td>";
        //         $body .= "<td>Work Order</td>";
        //         $body .= "<td>Model Code</td>";
        //         $body .= "<td>Model Name</td>";
        //         $body .= "<td>NG Case</td>";
        //         $body .= "<td>Q'TY</td>";
        //         $body .= "</tr>";
        //         $body .= "</thead>";
        //         $body .= "<tbody style=''>";
        //         $body .= "<tr>";
        //         $body .= "<td>" .$senddata[0]['HAPPR_EMP_APPROVE']."</td>";
        //         $body .= "<td>" .$senddata[0]['HREC_CUS']."</td>";
        //         $body .= "<td>" .$senddata[0]['HREC_LINE']."</td>";
        //         $body .= "<td>" .$senddata[0]['HREC_WON']."</td>";
        //         $body .= "<td>" .$senddata[0]['HREC_MDLCD']."</td>";
        //         $body .= "<td>" .$senddata[0]['HREC_MDLNM']."</td>";
        //         $body .= "<td>" .$senddata[0]['HREC_NGCASE']."</td>";
        //         $body .= "<td>" .$senddata[0]['HREC_QTY']."</td>";
        //         $body .= "</tr>";
        //         $body .= "</tbody>";
        //         $body .= "</table>";

        //         $mail->Body    = $body;

        //         $mail->send();
        //     } catch (Exception $e) {
        //         echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        //     }
        // }
    }
    header('Location: menu.php');
}


/**
 * TODO : Menu_PCBNG/ApproveFlow/approve.php
 * * การกดยืนยันให้สิทธิ์อนุมัติแต่ละลำดับการอนุมัติ
 */
if (isset($_GET['app'])) {
    $flowmaster  = $_GET['flowmaster'];
    $section = $_GET['section'];
    $first = $_GET['first'];
    $second = $_GET['second'];
    $third = $_GET['third'];
    $fourth = $_GET['fourth'];
    if (sizeof($first) == 1) {
        $first2 = $first[0];
    } else {
        $first2 = "";
        $fsize = sizeof($first) - 1;
        for ($i = 0; $i < sizeof($first); $i++) {

            $first2 .= $first[$i];
            if ($i < $fsize) {
                $first2 .= ',';
            }
        }
    }
    if (sizeof($second) == 1) {
        $second2 = $second[0];
    } else {
        $second2 = "";
        $ssize = sizeof($second) - 1;
        for ($i = 0; $i < sizeof($second); $i++) {
            $second2 .= $second[$i];
            if ($i < $ssize) {
                $second2 .= ',';
            }
        }
    }
    if (sizeof($third) == 1) {
        $third2 = $third[0];
    } else {
        $third2 = "";
        $tsize = sizeof($third) - 1;
        for ($i = 0; $i < sizeof($third); $i++) {
            $third2 .= $third[$i];
            if ($i < $tsize) {
                $third2 .= ',';
            }
        }
    }
    if (sizeof($fourth) == 1) {
        $fourth2 = $fourth[0];
    } else {
        $fourth2 = "";
        $fosize = sizeof($fourth) - 1;
        for ($i = 0; $i < sizeof($fourth); $i++) {

            $fourth2 .= $fourth[$i];
            if ($i < $fosize) {
                $fourth2 .= ',';
            }
        }
    }

    $arr = [];
    // print_r($first);

    array_push($arr, $first2);
    array_push($arr, $second2);
    array_push($arr, $third2);
    array_push($arr, $fourth2);
    // print_r($arr);

    // $checkFlow = "SELECT * FROM APPROVE_H_TBL WHERE ARRRH_DEPT = '" . $section . "'";
    // $conn->Query($checkFlow);
    // $check = $conn->FetchData();
    // if (!empty($check)) {
    //     $update  = "UPDATE APPROVE_H_TBL SET APPRH_STD = '0' WHERE ARRRH_DEPT = '" . $section . "'";
    //     $conn->Query($update);
    // }


    $APPRH = "SELECT * FROM [WEB_CODECD_TBL] WHERE CODE_CD = 'APPRH'";
    $conn->Query($APPRH);
    $APPRH2 = $conn->FetchData();
    $SET_APPRH = FN_SET_RUNNO($APPRH2[0]['CODE_RUNNO'], $year_month, $APPRH2[0]['CODE_CD'], 6);

    /**
     * TODO : 2024-02-17
     * * เงื่อนไขตรวจสอบว่าสายอนุมัติของแผนกนั้น ๆ มีแล้วหรือยัง
     * * ถ้ามีก็ให้ไปเปลี่ยน [APPRH_STD] = 0 
     */
    $checkApproveFlowCurrentDept = "SELECT [APPRH_ID] FROM APPROVE_H_TBL WHERE [ARRRH_DEPT] = '".$section."' AND [APPRH_STD] = 1";
    $conn->Query($checkApproveFlowCurrentDept);
    $checkApproveFlowCurrentDept2 = $conn->FetchData();
    if(!empty($checkApproveFlowCurrentDept2)) {
        $updateStd = "UPDATE [APPROVE_H_TBL] SET [APPRH_STD] = 0  WHERE [ARRRH_DEPT] = '".$section."'";
        $conn->Query($updateStd);
    }

    $insert = "INSERT INTO [dbo].[APPROVE_H_TBL]
    ([APPRH_ID]
    ,[APPRH_NAME]
    ,[ARRRH_DEPT]
    ,[APPRH_STD]
    ,[APPRH_CREATED]
    ,[APPRH_LSTDT])
    VALUES
    ('" . $SET_APPRH . "', 
    '" . $flowmaster . "',
    '" . $section . "',
    '1',
    '" . $_SESSION['id'] . "',
    getdate())";
    $conn->Query($insert);
    //echo $insert;
    $year_original = date_format($APPRH2[0]['CODE_LSTDT'], "Y");
    if ($year_original == $year_current) {
        $RUNNO = $APPRH2[0]['CODE_RUNNO'] + 1;
        UPDATE_RUNNO($RUNNO, $conn, 'APPRH');
    } else {
        $RUNNO = 1;
        UPDATE_RUNNO($RUNNO, $conn, 'APPRH');
    }

    $num = 1;
    for ($i = 0; $i < 4; $i++) {
        $APPRD = "SELECT * FROM [WEB_CODECD_TBL] WHERE CODE_CD = 'APPRD'";
        $conn->Query($APPRD);
        $APPRD2 = $conn->FetchData();
        $SET_APPRD = FN_SET_RUNNO($APPRD2[0]['CODE_RUNNO'], $year_month, $APPRD2[0]['CODE_CD'], 6);
        $insert2 = "INSERT INTO [dbo].[APPROVE_D_TBL]
        ([APPRH_ID]
        ,[APPRD_ID]
        ,[APPRD_SEQ]
        ,[APPRD_EMPID]
        ,[APPRD_LSTDT])
        VALUES
        ('" . $SET_APPRH . "',
        '" . $SET_APPRD . "',
        '" . $num . "',
        '" . $arr[$i] . "',
        getdate())";
        $conn->Query($insert2);
        // print($insert2);
        $year_original = date_format($APPRD2[0]['CODE_LSTDT'], "Y");
        if ($year_original == $year_current) {
            $RUNNO = $APPRD2[0]['CODE_RUNNO'] + 1;
            UPDATE_RUNNO($RUNNO, $conn, 'APPRD');
        } else {
            $RUNNO = 1;
            UPDATE_RUNNO($RUNNO, $conn, 'APPRD');
        }
        $num++;
    }
    //! End if (isset($_GET['app']))
}

$output = "SELECT * FROM [APPROVE_H_TBL] WHERE APPRH_STD = '1'";
$conn->Query($output);
$otp = $conn->FetchData();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id="title">PCB_NG MENU
    </title>
    <link rel="shortcut icon" href="../images/selectmenu.png" type="image/x-icon" id="favicon">
    <link rel="stylesheet" href="menu.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />


    <!-- <script src="../../JQuery/jquery-3.7.1.js"></script> -->


</head>

<body>
    <nav class="navbar navbar-expand-lg ">
        <div class="container-fluid">

            <span class="ms-1 fs-4" style="
            color: #DD1C1A;
            -webkit-text-stroke: 1px #fff;
            font-family: 'Lilita One', sans-serif;">PCB NG</span>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-2 ">
                    <li class="nav-item">
                        <a class="nav-link " aria-current="page" href="" id="record"><i class="bi bi-1-square-fill fs-5"></i><span class="ms-2">บันทึกข้อมูล</span> </a>
                    </li>
                    <div class="vr" style="color: #F80054; padding: 1px;"></div>
                    <li class="nav-item">
                        <a class="nav-link " href="" id="check"><i class="bi bi-2-square-fill fs-5"></i><span class="ms-2">ตรวจสอบข้อมูล</span> </a>
                    </li>
                    <div class="vr" style="color: #F80054; padding: 1px;"></div>
                    <li class="nav-item">
                        <a class="nav-link" href="" id="data" data-bs-toggle="modal" data-bs-target="#btndata" onclick="setbtndata()"><i class="bi bi-3-square-fill fs-5"></i><span class="ms-2">ข้อมูล PCB NG</span> </a>
                    </li>
                    <div class="vr" style="color: #F80054; padding: 1px;"></div>
                    <li class="nav-item">
                        <a class="nav-link" href="" id="report" data-bs-toggle="modal" data-bs-target="#btnreport">
                            <i class="bi bi-4-square-fill fs-5"></i><span class="ms-2">Report</span> </a>
                    </li>
                    <div class="vr" style="color: #F80054; padding: 1px;"></div>
                    <li class="nav-item">
                        <a class="nav-link" href="" id="approvepage"><i class="bi bi-5-square-fill fs-5"></i><span class="ms-2">สิทธิ์การอนุมัติ</span> </a>
                    </li>



                </ul>
                <form class="d-flex align-items-center ">
                    <p class="text-light mt-3 mx-5" style="font-size: 11pt;"><?php echo $_SESSION['username'] ?> &nbsp;(<?php echo $_SESSION['id'] ?>)</p>
                    <a href="../logout.php" id="" class="btn btn-danger text-light">logout</a>
                </form>
            </div>
        </div>
    </nav>
    <div class="modal fade" id="btnreport" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="ReportData/report.php" method="get" target="_blank">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">เลือกวันที่แสดงรายงาน</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label for="">เริ่มตั้งแต่วันที่</label>
                        <input type="date" id="predate" class="timeprevious form-control " name="predate">
                        <label for="" class="mt-3">สิ้นสุดวันที่</label>
                        <input type="date" id="lastdate" class="timenext form-control " name="lastdate">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-success" value="OK">
                    </div>
                </div>
            </form>
        </div>

    </div>
    <div class="modal fade" id="btndata" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="ListData/datalist.php" method="get" target="_blank">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">เลือกวันที่แสดงรายละเอียดข้อมูล</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label for="">เริ่มตั้งแต่วันที่</label>
                        <input type="date" id="startdate" class="timeprevious form-control " name="startdate">
                        <label for="" class="mt-3">สิ้นสุดวันที่</label>
                        <input type="date" id="finishdate" class="timenext form-control " name="finishdate">
                        <label for="" class="mt-3">เลือก Customer</label>
                        <select class="form-select w-100" id="custom" name="custom" onchange="autowon()">
                            <option value="" selected disabled>เลือกลูกค้า</option>
                            <?php
                            for ($i = 0; $i < sizeof($stmt); $i++) {

                            ?>
                                <option value="<?php echo $stmt[$i]['BGCD'] ?>"><?php echo $stmt[$i]['BGCD'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <label for="" class="mt-3">เลือก NG Case</label>
                        <select class="form-select mt-1 w-100" id="cases" name="cases">
                            <option value="" selected disabled>เหตุที่เสีย</option>
                            <?php
                            for ($i = 0; $i < sizeof($data1); $i++) {
                            ?>


                                <option value="<?php echo $data1[$i]['CASE_NAME'] ?>"><?php echo $data1[$i]['CASE_NAME'] . " " . $data1[$i]['CASE_NAMETHA'] ?></option>
                            <?php
                            }

                            ?>
                        </select>
                        <label for="" class="mt-3">เลือก NG Process</label>
                        <select class="form-select mt-1 w-100" id="process" name="process">
                            <option value="" selected disabled>เลือกกระบวนการผลิต</option>
                            <?php
                            for ($i = 0; $i < sizeof($data2); $i++) {
                            ?>


                                <option value="<?php echo $data2[$i]['PRO_NAME'] ?>"><?php echo $data2[$i]['PRO_NAME'] ?></option>



                            <?php
                            }

                            ?>
                        </select>
                        <label for="" class="mt-3">เลือก Section</label>
                        <select name="section" id="section" class="form-select w-100">
                            <option value="" selected disabled>เลือกแผนก</option>
                            <option value="MT">MT</option>
                            <option value="QC">QC</option>
                            <option value="AM">AM</option>
                            <option value="LC">LC</option>
                            <option value="MC">MC</option>


                        </select>
                        <label for="" class="mt-3">เลือก Line</label>
                        <select class="form-select w-100" id="lines" name="lines">
                            <option value="" selected disabled>เลือกไลน์ผลิต</option>
                            <optgroup label="Line-MT" class="line1">
                                <option value="MT-1">MT-1</option>
                                <option value="MT-2">MT-2</option>
                                <option value="MT-3">MT-3</option>
                                <option value="MT-4">MT-4</option>
                                <option value="MT-5">MT-5</option>
                                <option value="MT-6">MT-6</option>
                                <option value="MT-7">MT-7</option>
                                <option value="MT-8">MT-8</option>
                                <option value="MT-9">MT-9</option>
                                <option value="MT-10">MT-10</option>
                                <option value="MT-11">MT-11</option>
                                <option value="MT-12">MT-12</option>
                                <option value="MT-13">MT-13</option>
                                <option value="MT-14">MT-14</option>
                                <option value="MT-15">MT-15</option>
                            </optgroup>
                            <optgroup label="Line-SMT" class="line2">
                                <option value="SMT-1">SMT-1</option>
                                <option value="SMT-2">SMT-2</option>
                                <option value="SMT-3">SMT-3</option>
                                <option value="SMT-4">SMT-4</option>
                                <option value="SMT-5">SMT-5</option>
                                <option value="SMT-6">SMT-6</option>
                                <option value="SMT-7">SMT-7</option>
                                <option value="SMT-8">SMT-8</option>
                                <option value="SMT-9">SMT-9</option>
                                <option value="SMT-10">SMT-10</option>
                                <option value="SMT-11">SMT-11</option>
                                <option value="SMT-12">SMT-12</option>
                                <option value="SMT-13">SMT-13</option>
                                <option value="SMT-14">SMT-14</option>
                                <option value="SMT-15">SMT-15</option>
                                <option value="SMT-16">SMT-16</option>
                                <option value="SMT-17">SMT-17</option>
                                <option value="SMT-18">SMT-18</option>
                                <option value="SMT-19">SMT-19</option>
                                <option value="SMT-20">SMT-20</option>
                            </optgroup>
                            <optgroup label="Line-AV" class="line3">
                                <option value="AV-1">AV-1</option>
                                <option value="AV-2">AV-2</option>
                                <option value="AV-3">AV-3</option>
                                <option value="AV-4">AV-4</option>
                            </optgroup>
                            <optgroup label="Line-RH" class="line4">
                                <option value="RH-1">RH-1</option>
                                <option value="RH-2">RH-2</option>
                                <option value="RH-3">RH-3</option>
                                <option value="RH-4">RH-4</option>
                                <option value="RH-5">RH-5</option>
                            </optgroup>
                            <optgroup label="TPP" class="line5">
                                <option value="TPP">TPP</option>
                            </optgroup>
                        </select>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-success" value="OK" onclick="submitForm()">
                    </div>
                </div>
            </form>
        </div>

    </div>




    <div id="canva">
        <div class="img">
            <img src="../images/PCBimagebg.jpg" alt="" width="100%">
        </div>

        <div class="contenttxt">
            <div class="txtthai">
                <p class="animate__animated animate__pulse animate__infinite">ระบบจัดการบันทึกและอนุมัติข้อมูล &nbsp;<span>PCB NG</span>&nbsp; Online</p>
            </div>

        </div>
        <div class="contenttxt2">
            <div class="txtEng">
                <p class="">Online &nbsp;<span>PCB NG</span>&nbsp; data recording and approval management system</p>

            </div>
        </div>
       

        <div class="contenttxt3">
            <p style="font-size: 18pt;">วิธีการบันทึกข้อมูลสำหรับผู้ดำเนินการกรอกข้อมูลในระบบ</p>
            <p style="font-size: 14pt; text-align:left;" class="ms-3"><span style="color: red;">**</span>ขั้นตอนที่&nbsp;1&nbsp;:&nbsp;ให้กำหนดสิทธิ์อนุมัติการบันทึก PCB NG ในหน้าสิทธิ์การอนุมัติ<span style="color: red;">**</span></p>
            <p style="font-size: 14pt; text-align:left;" class="ms-4">ขั้นตอนที่&nbsp;2&nbsp;:&nbsp;บันทึกข้อมูลตามปกติ <span style="color: orange;">(ข้อมูลจริง)</span> ในหน้าบันทึกข้อมูล</p>
            <p style="font-size: 14pt; text-align:left;" class="ms-4">ขั้นตอนที่&nbsp;3&nbsp;:&nbsp;ตรวจสอบข้อมูลที่บันทึกเข้ามาจะอยู่ในหน้าตรวจสอบข้อมูล</p>
            <p style="font-size: 14pt; text-align:left;" class="ms-4">ขั้นตอนที่&nbsp;4&nbsp;:&nbsp; ให้หน้าข้อมูล PCB NG สามารถ <span style="color: green;">กด Export เป็น MS Excel ได้</span> และ <span style="color: green;">สามารถติดตามผลได้ว่าอนุมัติถึงลำดับที่เท่าไหร่แล้ว</span> </p>
            <a href="../Menu_PCBNG/openfile.php" class="btn btn-info">คู่มือ</a>
        </div>

    </div>

    <script src="../JQuery/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-ui.autocomplete.scroll@0.1.9/jquery.ui.autocomplete.scroll.min.js"></script>
    <script src="https://momentjs.com/downloads/moment.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.3/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script> -->



    <script>
        $(document).ready(function() {

            // $("#canva").load("./Record/record.php");
            //$("#canva").load("./ApproveFlow/approve.php");

            let startdate = moment().format('YYYY-MM-DD')
            console.log(startdate);
            $('#startdate').val(startdate)



            $("#record").on('click', function(event) {

                event.preventDefault(); // prevent the default behavior of the click event
                $("#canva").load("./Record/record.php");
                $('#favicon').attr('href', '../images/recordSave.png')
                document.title = "หน้าบันทึกข้อมูล"

            });

            $("#check").on('click', function(event) {
                event.preventDefault(); // prevent the default behavior of the click event
                $("#canva").load("./CheckData/check.php");
                $('#favicon').attr('href', '../images/check.png')
                document.title = "หน้าตรวจสอบข้อมูล"

            });



            $("#approvepage").on('click', function(event) {
                event.preventDefault(); // prevent the default behavior of the click event
                $("#canva").load("./ApproveFlow/approve.php");
                $('#favicon').attr('href', '../images/process.png')
                document.title = "หน้ากำหนดสิทธิ์อนุมัติ"

            });

            $("#menu").on('click', function(event) {
                event.preventDefault(); // prevent the default behavior of the click event
                $("#bg").load("menu.php");


            });

        });

        function setbtndata() {
            let startdate = moment().format('DD/MM/YYYY')
            console.log(startdate);
            $('#startdate').val(startdate)
        }

        $(document).ready(function() {
            $(".navbar-nav").on('click', 'a', function() {

                $(".navbar-nav a.active").removeClass('active');
                $(this).addClass('active');
            });
        });


        // $(document).ready(function() {
        //     $('#predate').datepicker({
        //         dateFormat: "dd-mm-yy"
        //     })
        // })
        // $(document).ready(function() {
        //     $('#lastdate').datepicker({
        //         dateFormat: "dd-mm-yy"
        //     })
        // })

        function displayCurrentDate() {
            var currentDate = new Date();
            var year = currentDate.getFullYear();
            var month = (currentDate.getMonth() + 1).toString().padStart(2, '0');
            var day = currentDate.getDate().toString().padStart(2, '0');
            var formattedDate = year + '-' + month + '-' + day;

            // Populate current date into input fields
            document.getElementById('startdate').value = formattedDate;
            document.getElementById('finishdate').value = formattedDate;
        }

        // Call the function when the modal is shown
        $('#btndata').on('shown.bs.modal', function() {
            displayCurrentDate();
        });

        function displayCurrentDate2() {
            var currentDate = new Date();
            var year = currentDate.getFullYear();
            var month = (currentDate.getMonth() + 1).toString().padStart(2, '0');
            var day = currentDate.getDate().toString().padStart(2, '0');
            var formattedDate = year + '-' + month + '-' + day;

            // Populate current date into input fields
            document.getElementById('predate').value = formattedDate;
            document.getElementById('lastdate').value = formattedDate;
        }

        // Call the function when the modal is shown
        $('#btnreport').on('shown.bs.modal', function() {
            displayCurrentDate2();
        });

        function submitForm() {
            document.getElementById("dataForm").submit(); // ส่งฟอร์มไปยัง datalist.php โดยไม่ต้องใส่ข้อมูลให้ครบ
        }
    </script>

</body>

</html>