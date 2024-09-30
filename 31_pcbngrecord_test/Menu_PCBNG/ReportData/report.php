<?php
session_start();
require_once('../../vendor/autoload.php');
$generator = new \Picqer\Barcode\BarcodeGeneratorHTML();
include '../../../Include/class/connect_sql.php';
date_default_timezone_set("Asia/Bangkok");
$conn = new CSQL;
$server = "172.22.64.11";
$db = "PCB_NG_DATA";
$conn->connect($server, $db);
$predate = date('Y-m-d', strtotime($_GET['predate']));
$lastdate = date('Y-m-d', strtotime($_GET['lastdate']));
//print($_GET['predate']);
//print($_GET['lastdate']);
$selectdata = "SELECT * FROM PCBREC_H_TBL WHERE HREC_EMP_DREC BETWEEN '" . $predate . "' AND '" . $lastdate . "'";
$conn->Query($selectdata);
$data = $conn->FetchData();
//print($selectdata);

$case_select = "SELECT * FROM NGCASE_MASTER";
$conn->Query($case_select);
$select = $conn->FetchData();

$cus_select  = "SELECT * FROM VBG ";
$conn->Query($cus_select);
$cus = $conn->FetchData();

/**
 * TODO : 2024-02-27
 * * SQL Condition ที่เรียกรายงานตามที่ Excel report by MT Dept.
 */
// $selectdata2 = "SELECT * FROM PCBREC_H_TBL WHERE HREC_EMP_DREC BETWEEN '" . $predate . "' AND '" . $lastdate . "'";
// $conn->Query($selectdata2);
// $data2 = $conn->FetchData();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>หน้ารายงานข้อมูล PCB NG
    </title>
    <link rel="shortcut icon" href="../../images/Report.png" type="image/x-icon">
    <!-- <link rel="stylesheet" href="../menu.css"> -->
    <link rel="stylesheet" href="report.css?v=4">
    <!-- <script src="../../JQuery/jquery-3.7.1.js"></script> -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
    <!-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css"> -->
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css"> -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"> -->
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.dataTables.min.css"> -->
    <!-- <script src="../../JQuery/jquery-3.7.1.js"></script> -->
    <link rel="stylesheet" href="../../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../node_modules/select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.min.css">
    <link rel="stylesheet" href="../../node_modules/bootstrap-icons/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../../node_modules/animate.css/animate.min.css">
    <link rel="stylesheet" href="../../node_modules/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="../../node_modules/sweetalert2/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="../../node_modules/jquery-ui/themes/base/all.css">
    <link rel="stylesheet" href="../../node_modules/@fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../../custome/datatables/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="../../custome/datatables/fixedColumns.dataTables.min.css">
    <link rel="stylesheet" href="../../custome/datatables/responsive.dataTables.min.css">
</head>

<body>
    <div class="card">
        <div class="card-body">
            <p class="textdate">ข้อมูลรายงานระหว่างวันที่ &nbsp;<?php echo date("d/m/Y", strtotime($predate)); ?>&nbsp;ถึง&nbsp;<?php echo date("d/m/Y", strtotime($lastdate)); ?></p>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered border-dark nowrap" id="tb-mtreport">
                <thead>
                    <tr>
                        <th colspan='18'>ผู้ร้องขอ</th>
                        <th colspan='3'>ผู้ตรวจสอบ</th>
                        <th colspan='3'>ผู้อนุมัติ MT</th>
                        <th colspan='3'>ผู้อนุมัติ LC</th>
                        <th colspan='3'>ผู้อนุมัติ MAT</th>
                    </tr>
                    <tr>
                        <th>วันที่บันทึกข้อมูล</th>
                        <th>รหัสพนักงาน</th>
                        <th>ชื่อผู้ใช้งาน</th>
                        <th>แผนก</th>
                        <th>ลูกค้า</th>
                        <th>ไลน์ผลิต</th>
                        <th>model code</th>
                        <th>model name</th>
                        <th>work order</th>
                        <th>lot size</th>
                        <th>q'ty</th>
                        <th>serial no</th>
                        <th>pcb ng case</th>
                        <th>position</th>
                        <th>ng process</th>
                        <th>problem</th>
                        <th>cause</th>
                        <th>Corrective & Preventive Action</th>
                        <th>วันที่ตรวจสอบ</th>
                        <th>รหัสพนักงาน</th>
                        <th>ชื่อผู้ตรวจสอบ</th>

                        <th>วันที่อนุมัติ MT</th>
                        <th>รหัสพนักงาน MT</th>
                        <th>ชื่อผู้อนุมัติ MT</th>

                        <th>วันที่อนุมัติ LC</th>
                        <th>รหัสพนักงาน LC</th>
                        <th>ชื่อผู้อนุมัติ LC</th>

                        <th>วันที่อนุมัติ MAT</th>
                        <th>รหัสพนักงาน MAT</th>
                        <th>ชื่อผู้อนุมัติ MAT</th>
                    </tr>
                </thead>
                <tbody id="tbody-mtreport">
                    <?php
                    for ($i = 0; $i < sizeof($data); $i++) {
                    ?>
                        <tr>
                            <td><?php print(date_format($data[$i]['HREC_EMP_DTREC'], "Y-m-d h:i:s")); ?></td>
                            <td><?php print($data[$i]['HREC_EMP']); ?></td>
                            <?php
                            $username = "SELECT MUSR_NAME
                            FROM [WEBSERVER].[dbo].[MUSR_TBL]
                            WHERE MUSR_ID = '" . $data[$i]['HREC_EMP'] . "'";
                            $conn->Query($username);
                            $username2 = $conn->FetchData();
                            ?>
                            <td><?php print($username2[0]['MUSR_NAME']); ?></td>
                            <td><?php print($data[$i]['HREC_SEC']); ?></td>
                            <td><?php print($data[$i]['HREC_CUS']); ?></td>
                            <td><?php print($data[$i]['HREC_LINE']); ?></td>
                            <td><?php print($data[$i]['HREC_MDLCD']); ?></td>
                            <td><?php print($data[$i]['HREC_MDLNM']); ?></td>
                            <td><?php print($data[$i]['HREC_WON']); ?></td>
                            <td><?php print($data[$i]['HREC_LOT']); ?></td>
                            <td><?php print($data[$i]['HREC_QTY']); ?></td>
                            <td><?php print($data[$i]['HREC_SERIAL']); ?></td>
                            <td><?php print($data[$i]['HREC_NGCASE']); ?></td>
                            <td><?php print($data[$i]['HREC_NG_POSITION']); ?></td>
                            <td><?php print($data[$i]['HREC_NGPROCESS']); ?></td>
                            <td><?php print($data[$i]['HREC_PROBLEM']); ?></td>
                            <td><?php print($data[$i]['HREC_CAUSE']); ?></td>
                            <td><?php print($data[$i]['HREC_ACTION']); ?></td>

                            <?php
                            $userapp = "SELECT 
                            a.HAPPR_EMP_APPROVE ,
                            mainuser.MUSR_NAME , 
                            a.HAPPR_LSTDT
                            FROM PCBREC_H_TBL AS r 
                            INNER JOIN PCBREC_APPROVE_TBL AS a 
                            ON r.HREC_ID = a.HREC_ID 
                            INNER JOIN [WEBSERVER].[dbo].[MUSR_TBL] AS mainuser 
                            ON a.HAPPR_EMP_APPROVE = mainuser.MUSR_ID COLLATE SQL_Latin1_General_CP1_CI_AS
                            WHERE a.HREC_ID = '" . $data[$i]['HREC_ID'] . "'
                            ORDER BY a.HAPPR_SEQ ASC";
                            $conn->Query($userapp);
                            $userapr = $conn->FetchData();
                    
                            if (!empty($userapr[0]['MUSR_NAME'])) {
                                $explode_name = explode(" ", $userapr[0]['MUSR_NAME']);
                                echo "<td class=\"text-uppercase\">" . date_format($userapr[0]['HAPPR_LSTDT'], "Y-m-d h:i:s") . "</td>";
                                echo "<td class=\"text-uppercase\">" . $userapr[0]['HAPPR_EMP_APPROVE'] . "</td>";
                                echo "<td class=\"text-uppercase\">" . $explode_name[0] . "</td>";
                            } else {
                                echo "<td style=\"background-color:#FCF0CC;\">Pending</td>";
                                echo "<td style=\"background-color:#FCF0CC;\">Pending</td>";
                                echo "<td style=\"background-color:#FCF0CC;\">Pending</td>";
                            }

                            //* MT
                            if (!empty($userapr[1]['MUSR_NAME'])) {
                                $explode_name = explode(" ", $userapr[1]['MUSR_NAME']);
                                echo "<td class=\"text-uppercase\">" . date_format($userapr[1]['HAPPR_LSTDT'], "Y-m-d h:i:s") . "</td>";
                                echo "<td class=\"text-uppercase\">" . $userapr[1]['HAPPR_EMP_APPROVE'] . "</td>";
                                echo "<td class=\"text-uppercase\">" . $explode_name[0] . "</td>";
                            } else {
                                echo "<td style=\"background-color:#FCF0CC;\">Pending</td>";
                                echo "<td style=\"background-color:#FCF0CC;\">Pending</td>";
                                echo "<td style=\"background-color:#FCF0CC;\">Pending</td>";
                            }

                            //* LC
                            if (!empty($userapr[2]['MUSR_NAME'])) {
                                $explode_name = explode(" ", $userapr[2]['MUSR_NAME']);
                                echo "<td class=\"text-uppercase\">" . date_format($userapr[2]['HAPPR_LSTDT'], "Y-m-d h:i:s") . "</td>";
                                echo "<td class=\"text-uppercase\">" . $userapr[2]['HAPPR_EMP_APPROVE'] . "</td>";
                                echo "<td class=\"text-uppercase\">" . $explode_name[0] . "</td>";
                            } else {
                                echo "<td style=\"background-color:#FCF0CC;\">Pending</td>";
                                echo "<td style=\"background-color:#FCF0CC;\">Pending</td>";
                                echo "<td style=\"background-color:#FCF0CC;\">Pending</td>";
                            }

                            //* MAT
                            if (!empty($userapr[3]['MUSR_NAME'])) {
                                $explode_name = explode(" ", $userapr[3]['MUSR_NAME']);
                                echo "<td class=\"text-uppercase\">" . date_format($userapr[3]['HAPPR_LSTDT'], "Y-m-d h:i:s") . "</td>";
                                echo "<td class=\"text-uppercase\">" . $userapr[3]['HAPPR_EMP_APPROVE'] . "</td>";
                                echo "<td class=\"text-uppercase\">" . $explode_name[0] . "</td>";
                            } else {
                                echo "<td style=\"background-color:#FCF0CC;\">Pending</td>";
                                echo "<td style=\"background-color:#FCF0CC;\">Pending</td>";
                                echo "<td style=\"background-color:#FCF0CC;\">Pending</td>";
                            }
                            ?>

                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="container">
                <p>แผนภูมิแสดงจำนวนการบันทึกงานเสียทั้งหมดระหว่างวันที่ &nbsp;<?php echo date("d/m/Y", strtotime($predate)); ?>&nbsp;ถึง&nbsp;<?php echo date("d/m/Y", strtotime($lastdate)); ?></p>
                <canvas id="myChart"></canvas>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <p class="card-title">ตารางแสดงข้อมูลรายงานการผลิต PCB ที่ผิดปกติ</p>
            <table class="table table-bordered border-dark nowrap" id="reportPCB">
                <thead>
                    <tr>
                        <th>Model Code</th>
                        <th>Serial Number</th>
                        <th>Quantity</th>
                        <th>NG Case</th>
                        <th>Cause</th>
                        <th>Corrective & Preventive</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    for ($i = 0; $i < sizeof($data); $i++) {
                    ?>
                        <tr>
                            <td><?php echo $data[$i]['HREC_MDLCD'] ?></td>
                            <td><?php echo $data[$i]['HREC_SERIAL'] ?></td>
                            <td><?php echo $data[$i]['HREC_QTY'] ?></td>
                            <td><?php echo $data[$i]['HREC_NGCASE'] ?></td>
                            <td><?php echo $data[$i]['HREC_CAUSE'] ?></td>
                            <td><?php echo $data[$i]['HREC_ACTION'] ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <p>ตารางรายงานแผ่นเสียแต่ละสาเหตุ (NG CASE)</p>
            <table class="table table-bordered border-dark nowrap w-100" id="reportNGCASE">
                <thead>
                    <tr>
                        <th>NG Case</th>
                        <?php
                        for ($i = 0; $i < sizeof($cus); $i++) {
                        ?>
                            <th><?php echo $cus[$i]['BGCD'] ?></th>

                        <?php
                        }
                        ?>
                        <th>จำนวนทั้งหมด</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    for ($i = 0; $i < sizeof($select); $i++) {
                        $total = 0;
                    ?>
                        <tr>
                            <th><?php echo $select[$i]['CASE_NAMETHA'] ?></th>
                            <?php
                            for ($j = 0; $j < sizeof($cus); $j++) {
                            ?>
                                <?php
                                $check = "SELECT COUNT(HREC_ID) AS TOTAL FROM [PCBREC_H_TBL] WHERE HREC_NGCASE = '" . $select[$i]['CASE_NAME'] . "' and HREC_CUS = '" . $cus[$j]['BGCD'] . "'";
                                $conn->Query($check);
                                $check2 = $conn->FetchData();
                                if ($check2[0]['TOTAL'] > 0) {
                                    $total += $check2[0]['TOTAL'];
                                ?>
                                    <td><?php echo $check2[0]['TOTAL'] ?></td>
                                <?php
                                } else {
                                ?>
                                    <td>-</td>
                                <?php
                                }
                                ?>
                            <?php
                            }
                            ?>
                            <td><?php echo $total;  ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <p>จำนวนแผ่นเสียในการผลิตแต่ละ Line</p>
            <table class="table table-bordered border-dark nowrap" id="reportLine">
                <thead>
                    <tr>
                        <th>Line</th>
                        <th>Customer</th>
                        <th>Work Order</th>
                        <th>Barcode Work Order</th>
                        <th>Q'TY</th>
                        <th>Barcode Q'TY</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    for ($i = 0; $i < sizeof($data); $i++) {
                    ?>
                        <tr>
                            <td><?php echo $data[$i]['HREC_LINE'] ?></td>
                            <td><?php echo $data[$i]['HREC_CUS'] ?></td>
                            <td><?php echo $data[$i]['HREC_WON'] ?></td>
                            <td><?php echo $generator->getBarcode($data[$i]['HREC_WON'], $generator::TYPE_CODE_128, 1, 40) ?></td>
                            <td><?php echo $data[$i]['HREC_QTY'] ?></td>
                            <td><?php echo $generator->getBarcode($data[$i]['HREC_QTY'], $generator::TYPE_CODE_128, 2, 40) ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"> -->
    <!-- </script> -->
    <!-- <script src="https://code.jquery.com/jquery-3.7.0.js"></script> -->
    <!-- <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script> -->
    <!-- <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script> -->
    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.umd.min.js"></script> -->
    <!-- <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script> -->
    <!-- <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script> -->
    <!-- <script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script> -->
    <script src="../../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../../node_modules/jquery-ui/dist/jquery-ui.min.js"></script>
    <script src="../../node_modules/jquery-ui.autocomplete.scroll/jquery.ui.autocomplete.scroll.min.js"></script>
    <script src="../../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../../node_modules/select2/dist/js/select2.full.min.js"></script>
    <script src="../../node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <script src="../../node_modules/@fortawesome/fontawesome-free/js/all.min.js"></script>
    <script src="../../custome/datatables/jquery.dataTables.min.js"></script>
    <script src="../../custome/datatables/dataTables.bootstrap5.min.js"></script>
    <script src="../../custome/datatables/dataTables.responsive.min.js"></script>
    <script src="../../custome/datatables/dataTables.fixedColumns.min.js"></script>
    <script src="../../custome/datatables/dataTables.buttons.min.js"></script>
    <script src="../../custome/datatables/jszip.min.js"></script>
    <script src="../../custome/datatables/buttons.html5.min.js"></script>
    <script src="../../custome/datatables/vfs_fonts.js"></script>
    <script src="../../custome/datatables/pdfmake.min.jss"></script>
    <!-- <script src="../../node_modules/moment/dist/moment.js"></script> -->
    <script src="../custome/moment/moment.js"></script>
    <script src="../../node_modules/chart.js/dist/chart.umd.js"></script>
    <script>
        let predate = '<?= $predate; ?>';
        let lastdate = '<?= $lastdate; ?>';
    </script>
    <script src="report.js?v=10"></script>
</body>

</html>