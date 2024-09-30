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
$startdate = !empty($startdate) ? "'" . $startdate . "'" : "null";
$finishdate = !empty($finishdate) ? "'" . $finishdate . "'" : "null";
$custom = !empty($custom) ? "'" . $custom . "'" : "null";
$lines = !empty($lines) ? "'" . $lines . "'" : "null";
$section = !empty($section) ? "'" . $section . "'" : "null";
$case = !empty($case) ? "'" . $case . "'" : "null";
$process = !empty($process) ? "'" . $process . "'" : "null";

$join  = "SELECT * FROM PCBREC_H_TBL AS rec INNER JOIN VWORLIST2 AS v ON rec.HREC_WON = v.WON 
WHERE  (HREC_SEC = $section OR $section IS NULL)
AND (HREC_LINE = $lines OR $lines IS NULL) 
AND (HREC_CUS = $custom OR $custom IS NULL)
AND (HREC_NGCASE = $case OR $case IS NULL)
AND (HREC_NGPROCESS = $process OR $process IS NULL)
AND (HREC_EMP_DREC BETWEEN $startdate AND $finishdate OR $startdate IS NULL OR $finishdate IS NULL)";
$conn->Query($join);
$stmt = $conn->FetchData();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ข้อมูล PCB NG ทั้งหมด
    </title>
    <link rel="shortcut icon" href="../../images/cloud-data.png" type="image/x-icon">
    <link rel="stylesheet" href="../ListData/data.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.dataTables.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    <script src="../../JQuery/jquery-3.7.1.js"></script>
</head>

<body>
    <div class="container">
        <div class="header ">
            <div class="beautiful d-flex justify-content-center ">
                <p style="font-family: 'Mitr', sans-serif;">ประวัติการบันทึกความเสียหายแผ่น PCB ทั้งหมด</p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-xl-3 col-md-6 mb-4 ms-3 mt-3">
                <div class="card  shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2 ">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                    จำนวนบันทึกงานเสีย
                                </div>

                                <div class="h5 mb-0 font-weight-bold text-gray-800 text-danger">
                                    <?php echo sizeof($stmt) ?>
                                </div>
                            </div>
                            <div class="col-auto">
                                <img src="../../images/decline.png" alt="" width="50px">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container mt-3">
            <table class="table" id="PCB_Table">
                <thead>
                    <tr>
                        <th scope="col" class="text-center">Work Order</th>
                        <th scope="col" class="text-center">Ref. Document</th>
                        <th scope="col" class="text-center">Section</th>
                        <th scope="col">Customer</th>
                        <th scope="col">Line</th>
                        <th scope="col">Model Code</th>
                        <th scope="col">Model Name</th>
                        <th scope="col">Serial Number</th>
                        <th scope="col">Lot Size</th>
                        <th scope="col">Q'ty</th>
                        <th scope="col">NG Case</th>
                        <th scope="col">NG Pocess</th>
                        <th scope="col" class="text-center">Problem</th>
                        <th scope="col" class="text-center">Cause</th>
                        <th scope="col" class="text-center">Corrective & Preventive</th>
                        <th scope="col">Status</th>
                        <th scope="col">วันที่รับข้อมูลครั้งแรก</th>
                        <th scope="col">วันที่และเวลาเปลี่ยนแปลงข้อมูล</th>
                        <th scope="col">ผู้อนุมัติลำดับที่ 1</th>
                        <th scope="col">ผู้อนุมัติลำดับที่ 2</th>
                        <th scope="col">ผู้อนุมัติลำดับที่ 3</th>
                        <th scope="col">ผู้อนุมัติลำดับที่ 4</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    for ($i = 0; $i < sizeof($stmt); $i++) {
                        $userapp = "SELECT * FROM PCBREC_H_TBL AS r INNER JOIN  PCBREC_APPROVE_TBL AS a ON r.HREC_ID = a.HREC_ID WHERE a.HREC_ID = '" . $stmt[$i]['HREC_ID'] . "'";
                        $conn->Query($userapp);
                        $userapr = $conn->FetchData();
                    ?>
                        <tr>
                            <td><?php echo $stmt[$i]['HREC_WON']; ?></td>
                            <td><?php echo $stmt[$i]['HREC_REF_DOC']; ?></td>
                            <td><?php echo $stmt[$i]['HREC_SEC']; ?></td>
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
                            <?php
                            if ($stmt[$i]['HREC_STD'] == 0) {
                            ?>
                                <td>อยู่ระหว่างการดำเนินการ</td>
                            <?php
                            } else {
                            ?>
                                <td>ดำเนินการเสร็จสิ้น</td>
                            <?php
                            }
                            ?>
                            <!-- <td><?php echo $stmt[$i]['HREC_STD']; ?></td> -->
                            <td><?php echo date_format($stmt[$i]['HREC_EMP_DTREC'], "d-m-Y"); ?></td>

                            <?php
                            if (!empty($stmt[$i]['HREC_LSTDT'])) {
                                echo "<td>" . date_format($stmt[$i]['HREC_LSTDT'], "d-m-Y,  H:i:s") . "</td>";
                            } else {
                                echo "<td></td>";
                            }
                            ?>
                            <td><?php echo $userapr[0]['HAPPR_EMP_APPROVE']; ?></td>
                            <td><?php echo $userapr[1]['HAPPR_EMP_APPROVE']; ?></td>
                            <td><?php echo $userapr[2]['HAPPR_EMP_APPROVE']; ?></td>
                            <td><?php echo $userapr[3]['HAPPR_EMP_APPROVE']; ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
        $(document).ready(function() {
            var table = $('#PCB_Table').dataTable({
                paging: true,
                scrollX: true,
                scrollY: "65vh",
                scrollCollapse: true,
                columnDefs: [{
                    width: 100,
                    targets: [9]
                }, {
                    width: 200,
                    targets: [2, 3, 7, 8, 14, 17, 18, 19, 20, 21] //0, 1, 2, 3,14
                }, {
                    width: 250,
                    targets: [0]
                }, {
                    width: 300,
                    targets: [1, 5, 6, 10, 11] //4, 5, 6, 7, 8
                }, {
                    width: 300,
                    targets: [15, 16] //4, 5, 6, 7, 8
                }, {
                    width: 400,
                    targets: [4, 12, 13] //11, 12, 13
                }, {
                    className: 'dt-left',
                    targets: [0, 1, 12, 13, 14] //11,12,13
                }, {
                    className: 'dt-center',
                    targets: [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 15, 16, 17, 18, 19, 20, 21] //0,1,2,3,4,5,6,7,8,9,10,14
                }],
                dom: 'Blfrtip',
                buttons: ['copy', 'excel'],
                fixedColumns: {
                    left: 1
                },
            });
        })
    </script>
</body>

</html>