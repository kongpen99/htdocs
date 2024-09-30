<?php
session_start();
include '../../../Include/class/connect_sql.php';
include "../../00_function/update_code_cd.php";
$conn = new CSQL;
$server = "172.22.64.11";
$db = "PCB_NG_DATA";
$conn->connect($server, $db);
date_default_timezone_set("Asia/Bangkok");
$sqlid = "SELECT MUSR_ID AS id , MUSR_NAME FROM [WEBSERVER].[dbo].[MUSR_TBL] WHERE MUSR_STATUS = 1";
// $sqlid = "SELECT * FROM PCB_LOGIN";
$conn->Query($sqlid);
$row = $conn->FetchData();

$output = "SELECT * FROM [APPROVE_H_TBL] WHERE APPRH_STD = '1'";
$conn->Query($output);
$otp = $conn->FetchData();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>กำหนดสิทธิ์อนุมัติ
    </title>
    <link rel="shortcut icon" href="../../images/process.png" type="image/x-icon">
    <link rel="stylesheet" href="ApproveFlow/app.css?v=1">
</head>
<body>
    <!-- <div class="content-container"> -->
        <div class="header">
            <p>Approve Master Flow (กำหนดสิทธิ์อนุมัติ) </p>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-4 mt-3">
                    <form action="" class="needs-validation mt-3" novalidate>
                        <label for="" class="flowtxt">สายอนุมัติ(Approve Flow)</label>
                        <input type="text" name="flowmaster" id="flowmaster" class="form-control mt-2 " required>
                        <div class="row">
                            <div class="col-md-12 mt-3 ">
                                <label for="" class="flowtxt2">แผนก(Section)</label>
                                <select class="form-select mt-2  p-2" aria-label="Default select example" id="section"
                                    name="section" required>
                                    <option value="" selected disabled>เลือกแผนก</option>
                                    <option value="MT">MT</option>
                                    <option value="QC">QC</option>
                                    <option value="AM">AM</option>
                                    <option value="OUTSOURCE">OUTSOURCE</option>
                                    <!-- <option value="OUTSOURCE-CPD">OUTSOURCE-CPD</option> -->
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3 ">
                            <div class="col-md-12">
                                <label for="" class="flowtxth">ลำดับที่ 1</label>
                                <select class="form-select" id="first" name="first[]" data-placeholder="Choose ID"
                                    multiple required>
                                    <?php
                                    for ($i = 0; $i < sizeof($row); $i++) {
                                    ?>
                                    <option value="<?php echo $row[$i]['id'] ?>"><?php echo $row[$i]['id']." ".$row[$i]['MUSR_NAME'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <label for="" class="flowtxth">ลำดับที่ 2 (MT)</label>
                                <select class="form-select " id="second" name="second[]" data-placeholder="Choose ID"
                                    multiple required>
                                    <?php
                                    for ($i = 0; $i < sizeof($row); $i++) {
                                    ?>
                                    <option value="<?php echo $row[$i]['id'] ?>"><?php echo $row[$i]['id']." ".$row[$i]['MUSR_NAME'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <label for="" class="flowtxth">ลำดับที่ 3 (LC)</label>
                                <select class="form-select " id="third" name="third[]" data-placeholder="Choose ID"
                                    multiple required>
                                    <?php
                                    for ($i = 0; $i < sizeof($row); $i++) {
                                    ?>
                                    <option value="<?php echo $row[$i]['id'] ?>"><?php echo $row[$i]['id']." ".$row[$i]['MUSR_NAME'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <label for="" class="flowtxth">ลำดับที่ 4 (MC)</label>
                                <select class="form-select" id="fourth" name="fourth[]" data-placeholder="Choose ID"
                                    multiple required>
                                    <?php
                                    for ($i = 0; $i < sizeof($row); $i++) {
                                    ?>
                                    <option value="<?php echo $row[$i]['id'] ?>"><?php echo $row[$i]['id']." ".$row[$i]['MUSR_NAME'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row ms-5">
                            <button type="submit" class="btn btn-primary w-75 mt-3 mb-3" name="app"
                                id="app">Submit</button>
                        </div>
                    </form>
                </div>

                <div class="col-8 mt-3">
                    <table class="table table-bordered border-dark nowrap" id="approve">
                        <thead class="thead h4">
                            <tr>
                                <th>สายอนุมัติ</th>
                                <!-- <th>แผนก</th> -->
                                <th>ลำดับที่ 1 </th>
                                <th>ลำดับที่ 2 </th>
                                <th>ลำดับที่ 3 </th>
                                <th>ลำดับที่ 4 </th>
                            </tr>
                        </thead>
                        <tbody class="tbody">
                            <?php
                            for ($i = 0; $i < sizeof($otp); $i++) {
                            ?>
                            <tr>
                                <td><?php echo $otp[$i]['APPRH_NAME']; ?></td>
                                <!-- <td><?php echo $otp[$i]['ARRRH_DEPT']; ?></td> -->
                                <?php
                                    $detail = "SELECT * FROM APPROVE_D_TBL WHERE APPRH_ID = '" . $otp[$i]['APPRH_ID'] . "' ORDER BY APPRD_SEQ ASC";
                                    $conn->Query($detail);
                                    $shw = $conn->FetchData();
                                    // print($detail);
                                    // print("<br>");
                                    ?>
                                <td class="text-uppercase" style="text-align:left;">
                                    <?php 
                                    // echo $shw[0]['APPRD_EMPID']; 
                                    if(strpos($shw[0]['APPRD_EMPID'], ',') !== false) {
                                        $empExplode = explode(',',$shw[0]['APPRD_EMPID']);
                                        for($j=0; $j<sizeof($empExplode); $j++) {
                                            $username = "SELECT MUSR_NAME
                                            FROM [WEBSERVER].[dbo].[MUSR_TBL]
                                            WHERE MUSR_ID = '" . $empExplode[$j]. "'";
                                            $conn->Query($username);
                                            $username2 = $conn->FetchData();
                                            print($username2[0]['MUSR_NAME']."<br>");
                                        }
                                    } else {
                                        $username = "SELECT MUSR_NAME
                                        FROM [WEBSERVER].[dbo].[MUSR_TBL]
                                        WHERE MUSR_ID = '" . $shw[0]['APPRD_EMPID']. "'";
                                        $conn->Query($username);
                                        $username2 = $conn->FetchData();
                                        print($username2[0]['MUSR_NAME']."<br>");
                                    }
                                    ?>
                                </td>
                                <td class="text-uppercase" style="text-align:left;">
                                    <?php 
                                    // echo $shw[1]['APPRD_EMPID']; 
                                    if(strpos($shw[1]['APPRD_EMPID'], ',') !== false) {
                                        $empExplode = explode(',',$shw[1]['APPRD_EMPID']);
                                        for($j=0; $j<sizeof($empExplode); $j++) {
                                            $username = "SELECT MUSR_NAME
                                            FROM [WEBSERVER].[dbo].[MUSR_TBL]
                                            WHERE MUSR_ID = '" . $empExplode[$j]. "'";
                                            $conn->Query($username);
                                            $username2 = $conn->FetchData();
                                            print($username2[0]['MUSR_NAME']."<br>");
                                        }
                                    } else {
                                        $username = "SELECT MUSR_NAME
                                        FROM [WEBSERVER].[dbo].[MUSR_TBL]
                                        WHERE MUSR_ID = '" . $shw[1]['APPRD_EMPID']. "'";
                                        $conn->Query($username);
                                        $username2 = $conn->FetchData();
                                        print($username2[0]['MUSR_NAME']."<br>");
                                    }
                                    ?>
                                </td>
                                <td class="text-uppercase" style="text-align:left;">
                                    <?php 
                                    // echo $shw[2]['APPRD_EMPID']; 
                                    if(strpos($shw[2]['APPRD_EMPID'], ',') !== false) {
                                        $empExplode = explode(',',$shw[2]['APPRD_EMPID']);
                                        for($j=0; $j<sizeof($empExplode); $j++) {
                                            $username = "SELECT MUSR_NAME
                                            FROM [WEBSERVER].[dbo].[MUSR_TBL]
                                            WHERE MUSR_ID = '" . $empExplode[$j]. "'";
                                            $conn->Query($username);
                                            $username2 = $conn->FetchData();
                                            print($username2[0]['MUSR_NAME']."<br>");
                                        }
                                    } else {
                                        $username = "SELECT MUSR_NAME
                                        FROM [WEBSERVER].[dbo].[MUSR_TBL]
                                        WHERE MUSR_ID = '" . $shw[2]['APPRD_EMPID']. "'";
                                        $conn->Query($username);
                                        $username2 = $conn->FetchData();
                                        print($username2[0]['MUSR_NAME']."<br>");
                                    }
                                    ?>
                                </td>
                                <td class="text-uppercase" style="text-align:left;">
                                    <?php 
                                    // echo $shw[3]['APPRD_EMPID']; 
                                    if(strpos($shw[3]['APPRD_EMPID'], ',') !== false) {
                                        $empExplode = explode(',',$shw[3]['APPRD_EMPID']);
                                        for($j=0; $j<sizeof($empExplode); $j++) {
                                            $username = "SELECT MUSR_NAME
                                            FROM [WEBSERVER].[dbo].[MUSR_TBL]
                                            WHERE MUSR_ID = '" . $empExplode[$j]. "'";
                                            $conn->Query($username);
                                            $username2 = $conn->FetchData();
                                            print($username2[0]['MUSR_NAME']."<br>");
                                        }
                                    } else {
                                        $username = "SELECT MUSR_NAME
                                        FROM [WEBSERVER].[dbo].[MUSR_TBL]
                                        WHERE MUSR_ID = '" . $shw[3]['APPRD_EMPID']. "'";
                                        $conn->Query($username);
                                        $username2 = $conn->FetchData();
                                        print($username2[0]['MUSR_NAME']."<br>");
                                    }
                                    ?>
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <!-- </div> -->
    <script src="ApproveFlow/app.js?v=5"></script>
    <script>
         (() => {
            'use strict'
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            const forms = document.querySelectorAll('.needs-validation')
            // Loop over them and prevent submission
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
</body>
</html>