<?php
session_start();
error_reporting(0);
include '../../../Include/class/connect_sql.php';
$conn = new CSQL;
$server = "172.22.64.11";
$db = "PCB_NG_DATA";
$conn->connect($server, $db);
/**
 * TODO: เลือกดึงข้อมูลมาแสดง 
 */
$pdate  = date('Y-m-d', strtotime($_GET['startdate']));
$ldate = date('Y-m-d', strtotime($_GET['finishdate']));
$custom  = $_GET['custom'];
$lines = $_GET['lines'];
$section = $_GET['section'];
$case = $_GET['cases'];
$process  = $_GET['process'];
// $startdate = !empty($startdate) ? "'" . $startdate . "'" : "null";
// $finishdate = !empty($finishdate) ? "'" . $finishdate . "'" : "null";
// $custom = !empty($custom) ? "'" . $custom . "'" : "null";
// $lines = !empty($lines) ? "'" . $lines . "'" : "null";
// $section = !empty($section) ? "'" . $section . "'" : "null";
// $case = !empty($case) ? "'" . $case . "'" : "null";
// $process = !empty($process) ? "'" . $process . "'" : "null";

if(!empty($custom)) {
    $query[0] = "HREC_CUS = '".$custom."'";
} else {
    $query[0] = "";
}

if(!empty($lines)) {
    $query[1] = "HREC_LINE = '".$lines."'";
} else {
    $query[1] = "";
}

if(!empty($case)) {
    $query[2] = "HREC_NGCASE = '".$case."'";
} else {
    $query[2] = "";
}

if(!empty($process)) {
    $query[3] = "HREC_NGPROCESS = '".$process."'";
} else {
    $query[3] = "";
}

// if(!empty($section)) {
//     $query[4] = "HREC_SEC = '".$section."'";
// } else {
//     $query[4] = "";
// }

$WHERE = "";
for ($i=0; $i < sizeof($query); $i++) { 
    if(!empty($query[$i])) {
        if(empty($WHERE)) {
            $WHERE = " AND ".$query[$i];
        } else {
            $WHERE .= " AND ".$query[$i];
        }
    }
}

/**
 * TODO : 2024-03-05
 * * เพิ่มเงื่อนไขสำหรับการเรียกรายงานของ แผนก MAT , LC
 */
if($section == 'MC') {
    $ldate_plus_one = date('Y-m-d', strtotime($ldate . ' +1 day'));
    // print("start date :".$pdate."<br>");
    // print("end date :".$ldate."<br>");
    // print("end date +1 :".$nextDay."<br>");
    // $join  = "SELECT 
    // rec.HREC_ID,
    // rec.HREC_WON,
    // rec.HREC_SEC,
    // rec.HREC_STD,
    // rec.HREC_REF_DOC,
    // rec.HREC_CUS,
    // rec.HREC_LINE,
    // rec.HREC_MDLCD,
    // rec.HREC_MDLNM,
    // rec.HREC_SERIAL,
    // rec.HREC_QTY,
    // rec.HREC_NGCASE,
    // rec.HREC_NGPROCESS,
    // rec.HREC_PROBLEM,
    // rec.HREC_CAUSE,
    // rec.HREC_ACTION,
    // rec.HREC_LSTDT,
    // rec.HREC_EMP_DTREC,
    // v.WONQT
    // FROM PCBREC_H_TBL AS rec INNER JOIN VWORLIST2 AS v ON rec.HREC_WON = v.WON 
    // WHERE rec.HREC_EMP_DREC BETWEEN '".$pdate."' AND '".$ldate."'
    // AND rec.[HREC_STD] = '1'
    // ".$WHERE."";

    /**
     * TODO : 2024-03-07
     * * เงื่อนไขปรับปรุงเรื่องการค้นหาวันที่อนุมัติของแผนก MC
     * * ระหว่างวันที่เริ่ม และ วันที่สิ้นสุด + 1
     */
    $join  = "SELECT rec.HREC_ID, rec.HREC_WON, 
    rec.HREC_SEC, rec.HREC_STD, 
    rec.HREC_REF_DOC, rec.HREC_CUS, 
    rec.HREC_LINE, rec.HREC_MDLCD, 
    rec.HREC_MDLNM, rec.HREC_SERIAL, 
    rec.HREC_QTY, rec.HREC_NGCASE, 
    rec.HREC_NGPROCESS, rec.HREC_PROBLEM, 
    rec.HREC_CAUSE, rec.HREC_ACTION, 
    rec.HREC_LSTDT, rec.HREC_EMP_DTREC, 
    pat.HAPPR_SEQ , pat.HAPPR_EMP_APPROVE,
    pat.HAPPR_LSTDT,v.WONQT 
    FROM PCBREC_H_TBL AS rec 
    INNER JOIN VWORLIST2 AS v 
    ON rec.HREC_WON = v.WON 
    INNER JOIN [PCBREC_APPROVE_TBL] AS pat
    ON rec.HREC_ID = pat.HREC_ID
    WHERE pat.HAPPR_LSTDT BETWEEN '".$pdate."' AND '".$ldate_plus_one."'
    AND rec.[HREC_STD] = '1'
    AND pat.HAPPR_SEQ = '4'
    ORDER BY rec.HREC_ID ASC";

    // print("section : ".$section."<br>");
    // print($join);

} else if($section == 'LC') {
    $ldate_plus_one = date('Y-m-d', strtotime($ldate . ' +1 day'));

    // $join  = "SELECT 
    // rec.HREC_ID,
    // rec.HREC_WON,
    // rec.HREC_SEC,
    // rec.HREC_STD,
    // rec.HREC_REF_DOC,
    // rec.HREC_CUS,
    // rec.HREC_LINE,
    // rec.HREC_MDLCD,
    // rec.HREC_MDLNM,
    // rec.HREC_SERIAL,
    // rec.HREC_QTY,
    // rec.HREC_NGCASE,
    // rec.HREC_NGPROCESS,
    // rec.HREC_PROBLEM,
    // rec.HREC_CAUSE,
    // rec.HREC_ACTION,
    // rec.HREC_LSTDT,
    // rec.HREC_EMP_DTREC,
    // v.WONQT
    // FROM PCBREC_H_TBL AS rec INNER JOIN VWORLIST2 AS v ON rec.HREC_WON = v.WON 
    // WHERE rec.HREC_EMP_DREC BETWEEN '".$pdate."' AND '".$ldate."'
    // AND rec.[HREC_APPRH_TRACKING] = '4'
    // ".$WHERE.""; 

    /**
     * TODO : 2024-03-07
     * * เงื่อนไขปรับปรุงเรื่องการค้นหาวันที่อนุมัติของแผนก LC
     * * ระหว่างวันที่เริ่ม และ วันที่สิ้นสุด + 1
     */
    $join  = "SELECT rec.HREC_ID, rec.HREC_WON, 
    rec.HREC_SEC, rec.HREC_STD, 
    rec.HREC_REF_DOC, rec.HREC_CUS, 
    rec.HREC_LINE, rec.HREC_MDLCD, 
    rec.HREC_MDLNM, rec.HREC_SERIAL, 
    rec.HREC_QTY, rec.HREC_NGCASE, 
    rec.HREC_NGPROCESS, rec.HREC_PROBLEM, 
    rec.HREC_CAUSE, rec.HREC_ACTION, 
    rec.HREC_LSTDT, rec.HREC_EMP_DTREC, 
    pat.HAPPR_SEQ , pat.HAPPR_EMP_APPROVE,
    pat.HAPPR_LSTDT,v.WONQT 
    FROM PCBREC_H_TBL AS rec 
    INNER JOIN VWORLIST2 AS v 
    ON rec.HREC_WON = v.WON 
    INNER JOIN [PCBREC_APPROVE_TBL] AS pat
    ON rec.HREC_ID = pat.HREC_ID
    WHERE pat.HAPPR_LSTDT BETWEEN '".$pdate."' AND '".$ldate_plus_one."'
    AND pat.HAPPR_SEQ = '3'
    ".$WHERE."
    ORDER BY rec.HREC_ID ASC"; 

    // print("section : ".$section."<br>");
    // print($join);
} else {
    if(empty($section)){
        $join  = "SELECT
        rec.HREC_ID,
        rec.HREC_WON,
        rec.HREC_SEC,
        rec.HREC_STD,
        rec.HREC_REF_DOC,
        rec.HREC_CUS,
        rec.HREC_LINE,
        rec.HREC_MDLCD,
        rec.HREC_MDLNM,
        rec.HREC_SERIAL,
        rec.HREC_QTY,
        rec.HREC_NGCASE,
        rec.HREC_NGPROCESS,
        rec.HREC_PROBLEM,
        rec.HREC_CAUSE,
        rec.HREC_ACTION,
        rec.HREC_LSTDT,
        rec.HREC_EMP_DTREC,
        v.WONQT
        FROM PCBREC_H_TBL AS rec INNER JOIN VWORLIST2 AS v ON rec.HREC_WON = v.WON 
        WHERE rec.HREC_EMP_DREC BETWEEN '".$pdate."' AND '".$ldate."'
        ".$WHERE."";
        print("section : empty");
    } else {
        $join  = "SELECT
        rec.HREC_ID,
        rec.HREC_WON,
        rec.HREC_SEC,
        rec.HREC_STD,
        rec.HREC_REF_DOC,
        rec.HREC_CUS,
        rec.HREC_LINE,
        rec.HREC_MDLCD,
        rec.HREC_MDLNM,
        rec.HREC_SERIAL,
        rec.HREC_QTY,
        rec.HREC_NGCASE,
        rec.HREC_NGPROCESS,
        rec.HREC_PROBLEM,
        rec.HREC_CAUSE,
        rec.HREC_ACTION,
        rec.HREC_LSTDT,
        rec.HREC_EMP_DTREC,
        v.WONQT
        FROM PCBREC_H_TBL AS rec INNER JOIN VWORLIST2 AS v ON rec.HREC_WON = v.WON 
        WHERE rec.HREC_EMP_DREC BETWEEN '".$pdate."' AND '".$ldate."'
        AND HREC_SEC = '".$section."'
        ".$WHERE."";        
        print("section : ".$section);

    }
}

    // $join  = "SELECT * FROM PCBREC_H_TBL AS rec INNER JOIN VWORLIST2 AS v ON rec.HREC_WON = v.WON 
    // WHERE  (HREC_SEC = $section OR $section IS NULL)
    // AND (HREC_LINE = $lines OR $lines IS NULL) 
    // AND (HREC_CUS = $custom OR $custom IS NULL)
    // AND (HREC_NGCASE = $case OR $case IS NULL)
    // AND (HREC_NGPROCESS = $process OR $process IS NULL)
    // AND (HREC_EMP_DREC BETWEEN $startdate AND $finishdate OR $startdate IS NULL OR $finishdate IS NULL)";

$conn->Query($join);
$stmt = $conn->FetchData();
// print($join);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายงานโดยแผนกระหว่างวันที่ <?php print($pdate);?> ถึงวันที่ <?php print($ldate);?></title>
    <link rel="shortcut icon" href="../../images/cloud-data.png" type="image/x-icon">
    <link rel="stylesheet" href="../ListData/data.css?v=4">
    
    <link rel="stylesheet" href="../../node_modules/@fortawesome/fontawesome-free/css/all.min.css"></link>
    <link rel="stylesheet" href="../../node_modules/sweetalert2/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="../../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../custome/datatables/dataTables.bootstrap5.min.css">
    <!-- <link rel="stylesheet" href="../../custome/datatables/fixedColumns.dataTables.min.css"> -->
    <link rel="stylesheet" href="../../node_modules/jquery/dist/jquery.min.js">
    <link rel="stylesheet" href="../../node_modules/bootstrap-icons/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../../custome/datatables/responsive.dataTables.min.css">


    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
    <!-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css"> -->
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css"> -->
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.dataTables.min.css"> -->
    <!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css"> -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"> -->
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css"> -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css"> -->
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css"> -->
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css"> -->
    <!-- <script src="../../JQuery/jquery-3.7.1.js"></script> -->
</head>

<body>
    <div class="container-fluid">
        <div class="header ">
            <div class="beautiful d-flex justify-content-center ">
                <p style="font-family: 'Mitr', sans-serif; color:black;">ประวัติการบันทึกความเสียหายแผ่น PCB ทั้งหมด</p>
            </div>
        </div>
       
        <div class="px-5">
            <table class="table table-bordered table-hover border-dark bg-white display nowrap" id="PCB_Table">
                <thead>
                    <tr>
                        <th >วันที่รับข้อมูลครั้งแรก</th>
                        <?php
                        if($section == 'MC') {
                            print("<th>วันที่อนุมัติของ MC Dept</th>");
                        } else if($section == 'LC') {
                            print("<th>วันที่อนุมัติของ LC Dept</th>");
                        } else {
                            print("<th>เปลี่่ยนแปลงล่าสุด</th>");
                        }
                        ?>
                        <!-- <th >เปลี่่ยนแปลงล่าสุด</th> -->
                        <th class="text-center">Work Order</th>
                        <th class="text-center">Section</th>
                        <th >Status</th>
                        <th >ผู้อนุมัติที่ 1</th>
                        <th >ผู้อนุมัติที่ 2 (PROD)</th>
                        <th >ผู้อนุมัติที่ 3 (LC)</th>
                        <th >ผู้อนุมัติที่ 4 (MAT)</th>
                        <th  class="text-center">Ref. Document</th>
                        <th >Customer</th>
                        <th >Line</th>
                        <th >Model Code</th>
                        <th >Model Name</th>
                        <th >Serial Number</th>
                        <th >Lot Size</th>
                        <th >Q'ty</th>
                        <th >NG Case</th>
                        <th >NG Pocess</th>
                        <th  class="text-center">Problem</th>
                        <th  class="text-center">Cause</th>
                        <th  class="text-center">Corrective & Preventive</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    if(!empty($stmt)){
                        for ($i = 0; $i < sizeof($stmt); $i++) {
                            // $userapp = "SELECT 
                            // a.HAPPR_EMP_APPROVE
                            // FROM PCBREC_H_TBL AS r 
                            // INNER JOIN  PCBREC_APPROVE_TBL AS a 
                            // ON r.HREC_ID = a.HREC_ID 
                            // WHERE a.HREC_ID = '" . $stmt[$i]['HREC_ID'] . "'";
                            $userapp = "SELECT 
                            a.HAPPR_EMP_APPROVE ,
                            mainuser.MUSR_NAME
                            FROM PCBREC_H_TBL AS r 
                            INNER JOIN PCBREC_APPROVE_TBL AS a 
                            ON r.HREC_ID = a.HREC_ID 
                            INNER JOIN [WEBSERVER].[dbo].[MUSR_TBL] AS mainuser 
                            ON a.HAPPR_EMP_APPROVE = mainuser.MUSR_ID COLLATE SQL_Latin1_General_CP1_CI_AS
                            WHERE a.HREC_ID = '" . $stmt[$i]['HREC_ID'] . "'
                            ORDER BY a.HAPPR_SEQ ASC";

                            $conn->Query($userapp);
                            $userapr = $conn->FetchData();
                        ?>
                            <tr>
                                <td><?php echo date_format($stmt[$i]['HREC_EMP_DTREC'], "Y-m-d"); ?></td>
                                <?php
                                if($section == 'MC' || $section == 'LC') {
                                    echo "<td>".date_format($stmt[$i]['HAPPR_LSTDT'], "Y-m-d,  H:i:s")."</td>";
                                } else {
                                    $getDatetimeApprovalLasttime = "SELECT TOP(1) HAPPR_LSTDT FROM [PCBREC_APPROVE_TBL] WHERE HREC_ID ='".$stmt[$i]['HREC_ID']."'
                                    AND HAPPR_EMP_APPROVE IS NOT NULL
                                    ORDER BY HAPPR_SEQ DESC ";
                                    $conn->Query($getDatetimeApprovalLasttime);
                                    $getDatetimeApprovalLasttime2 = $conn->FetchData();
                                    if(!empty($getDatetimeApprovalLasttime2)) {
                                        echo "<td>" . date_format($getDatetimeApprovalLasttime2[0]['HAPPR_LSTDT'], "Y-m-d,  H:i:s") . "</td>";
                                    } else {
                                        echo "<td></td>";
                                    }
                                }



                                // if (!empty($stmt[$i]['HREC_LSTDT'])) {
                                //     echo "<td>" . date_format($stmt[$i]['HREC_LSTDT'], "Y-m-d,  H:i:s") . "</td>";
                                // } else {
                                //     echo "<td></td>";
                                // }
                                ?>
                                <td><?php echo $stmt[$i]['HREC_WON']; ?></td>
                                <td><?php echo $stmt[$i]['HREC_SEC']; ?></td>

                                <?php
                                if ($stmt[$i]['HREC_STD'] == 0) {
                                ?>
                                    <td>ดำเนินการ</td>
                                <?php
                                } else {
                                ?>
                                    <td>เสร็จสิ้น</td>
                                <?php
                                }
                                ?>

                                <?php 
                                    if(!empty($userapr[0]['MUSR_NAME'])) {
                                        $explode_name = explode(" ",$userapr[0]['MUSR_NAME']);
                                        echo "<td class=\"text-uppercase\">".$explode_name[0]."</td>"; 
                                    } else {
                                        echo "<td style=\"background-color:#FCF0CC;\">Pending</td>"; 
                                    }
                                ?>

                                <?php 
                                    if(!empty($userapr[1]['MUSR_NAME'])) {
                                        $explode_name = explode(" ",$userapr[1]['MUSR_NAME']);
                                        echo "<td class=\"text-uppercase\">".$explode_name[0]."</td>"; 
                                    } else {
                                        echo "<td style=\"background-color:#FCF0CC;\">Pending</td>"; 
                                    }
                                ?>

                                <?php 
                                    if(!empty($userapr[2]['MUSR_NAME'])) {
                                        $explode_name = explode(" ",$userapr[2]['MUSR_NAME']);
                                        echo "<td class=\"text-uppercase\">".$explode_name[0]."</td>"; 
                                    } else {
                                        echo "<td style=\"background-color:#FCF0CC;\">Pending</td>"; 
                                    }
                                ?>

                                <?php 
                                    if(!empty($userapr[3]['MUSR_NAME'])) {
                                        $explode_name = explode(" ",$userapr[3]['MUSR_NAME']);
                                        echo "<td class=\"text-uppercase\">".$explode_name[0]."</td>"; 
                                    } else {
                                        echo "<td style=\"background-color:#FCF0CC;\">Pending</td>"; 
                                    }
                                ?>

                                <td><?php echo $stmt[$i]['HREC_REF_DOC']; ?></td>
                                <td><?php echo $stmt[$i]['HREC_CUS']; ?></td>
                                <td><?php echo $stmt[$i]['HREC_LINE']; ?></td>
                                <td><?php echo $stmt[$i]['HREC_MDLCD']; ?></td>
                                <td><?php echo $stmt[$i]['HREC_MDLNM']; ?></td>
                                <td><?php echo $stmt[$i]['HREC_SERIAL']; ?></td>
                                <td><?php echo number_format($stmt[$i]['WONQT']); ?></td>
                                <td><?php echo number_format($stmt[$i]['HREC_QTY']); ?></td>
                                <td><?php echo $stmt[$i]['HREC_NGCASE']; ?></td>
                                <td><?php echo $stmt[$i]['HREC_NGPROCESS']; ?></td>
                                <td><?php echo $stmt[$i]['HREC_PROBLEM']; ?></td>
                                <td><?php echo $stmt[$i]['HREC_CAUSE']; ?></td>
                                <td><?php echo $stmt[$i]['HREC_ACTION']; ?></td>
                                <!-- <td><?php echo $stmt[$i]['HREC_STD']; ?></td> -->
                            </tr>
                        <?php
                        }
                    } 
                    ?>
                </tbody>
            </table>
        </div>

    </div>
    <script src="../../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../../node_modules/jquery-ui/dist/jquery-ui.min.js"></script>
    <script src="../../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../../node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <script src="../../custome/datatables/jquery.dataTables.min.js"></script>
    <!-- <script src="../../custome/datatables/buttons.html5.min.js"></script> -->
    <script src="../../custome/datatables/dataTables.buttons.min.js"></script>
    <script src="../../custome/datatables/dataTables.bootstrap5.min.js"></script>
    <script src="../../custome/datatables/dataTables.responsive.min.js"></script>
    <!-- <script src="../../custome/datatables/dataTables.fixedColumns.min.js"></script> -->
    <script src="../../custome/datatables/pdfmake.min.js"></script>
    <script src="../../custome/datatables/vfs_fonts.js"></script>
    <script src="../../custome/datatables/jszip.min.js"></script>
    <script src="../../custome/datatables/buttons.html5.min.js"></script>

    <!-- <script src="https://code.jquery.com/jquery-3.7.0.js"></script> -->
    <!-- <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script> -->
    <!-- <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script> -->
    <!-- <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script> -->
    <!-- <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script> -->
    <!-- <script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script> -->
    <!-- <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script> -->
    <!-- <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script> -->
    <!-- <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script> -->
    <script>
        $(document).ready(function() {
            var table = $('#PCB_Table').dataTable({
                paging: true,
                pageLength : 100,
                scrollX: true,
                scrollY: "65vh",
                scrollCollapse: true,
                columnDefs: [
                // {
                //     width: 100,
                //     targets: [9]
                // }, {
                //     width: 200,
                //     targets: [2, 3, 7, 8,  17, 18, 19, 20, 21] //0, 1, 2, 3,14
                // }, {
                //     // width: 250,
                //     targets: [0]
                // }, {
                //     width: 300,
                //     targets: [1, 5, 6, 10, 11] //4, 5, 6, 7, 8
                // }, {
                //     width: 300,
                //     targets: [15, 16] //4, 5, 6, 7, 8
                // }, {
                //     width: 400,
                //     targets: [4, 12, 13,14,] //11, 12, 13
                // }, 
                {
                    className: 'dt-left',
                    targets: [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21] 
                }, 
                // {
                //     className: 'dt-center',
                //     targets: [2,3,4,5,6,9,10,11,15,16,17,18,19,20,21] 
                // }
                ],
                dom: 'Blfrtip',
                buttons: ['excel','copy'],
                fixedColumns: {
                    left: 1
                },
            });
        })
    </script>
</body>

</html>