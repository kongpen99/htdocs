<?php
session_start();
ini_set('display_errors', 0);
include '../../../Include/class/connect_sql.php';
include "../../00_function/update_code_cd.php";
date_default_timezone_set("Asia/Bangkok");
$year_current = date("Y");
$year_month = date("Ym");
$conn = new CSQL;
$server = "172.22.64.11";
$db = "PCB_NG_DATA";
$conn->connect($server, $db);

$get_hrec_id = $_GET['send_hrecid'];

$select_hrec = "SELECT * FROM PCBREC_H_TBL WHERE HREC_ID = '" . $get_hrec_id . "'  ";
$conn->Query($select_hrec);
$select = $conn->FetchData();

$sql = "SELECT * FROM VBG";
$conn->Query($sql);
$stmt = $conn->FetchData();

$ng = "SELECT * FROM NGCASE_MASTER";
$conn->Query($ng);
$data1 = $conn->FetchData();

$processng = "SELECT * FROM PROCESS_MASTER";
$conn->Query($processng);
$data2 = $conn->FetchData();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PCB_NG NewRecordData</title>
    <link rel="shortcut icon" href="../../images/edit.png" type="image/x-icon">
    <link rel="stylesheet" href="../../node_modules/animate.css/animate.min.css">
    <link rel="stylesheet" href="../../node_modules/@fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../node_modules/jquery-ui/themes/base/all.css">
    <link rel="stylesheet" href="../../node_modules/sweetalert2/dist/sweetalert2.min.css">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" /> -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
    <!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css"> -->
    <!-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Chakra+Petch:wght@700&display=swap');

        body {
            background-color: #CFFFDC;
            font-family: 'Chakra Petch', sans-serif;
        }

        .header {
            background-color: #2dd881;
            color: #fff;
            font-size: 17pt;
            height: 13vh;
            display: flex;
            justify-content: center;
            align-items: center;

        }

        .header p {
            margin-top: 15px;
            margin-left: 300px;

        }


        .header .statusRJ p {
            margin-left: 200px;
            font-size: 20px !important;
            padding: 0 50px 0 0 !important;
        }

        .coolinput {
            display: flex;
            flex-direction: column;
            width: 100%;
            position: static;
            /* max-width: 240px; */
        }

        .coolinput label.text {
            font-size: 14pt;
            color: #00A550;
            font-weight: 700;
            position: relative;
            top: 0.5rem;
            margin: 0 0 0 7px;
            padding: 0 3px;
            width: fit-content;
        }

        .coolinput input[type=text].input {
            padding: 5px 10px;
            font-size: 0.75rem;
            border: 2px #00A550 solid;
            border-radius: 5px;
            /* width: 100%; */
            margin-top: 5px;
            font-size: 14pt;
        }

        .input {
            color: #00A550;
        }

        .coolinput input[type=text].input:focus {
            outline: none;
            color: #00A550;
        }

        .coolinput input[type=number].input {
            padding: 5px 10px;
            font-size: 0.75rem;
            border: 2px #00A550 solid;
            border-radius: 5px;
            /* width: 100%; */
            margin-top: 5px;
            font-size: 14pt;


        }

        .coolinput input[type=number].input:focus {
            outline: none;
            color: #00A550;
        }

        .select {
            margin: 4px 0;
        }

        .text-label {
            font-size: 14pt;
            color: #00A550;
        }

        .form-select {
            border: 2px #00A550 solid;
            color: #00A550;
            height: 43px;

        }

        #areatxt {
            margin: 7px 0;
            color: #00A550;
            font-size: 12pt;
        }

        #exampleTextarea {
            border: 2px #00A550 solid;
        }

        .button {
            margin-top: 30px;
            margin-bottom: 10px;
            padding: 1em 5em;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 2.5px;
            font-size: 14pt;
            font-weight: 600;
            color: #000;
            background-color: #fff;
            border: none;
            border-radius: 45px;
            box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease 0s;
            cursor: pointer;
            outline: none;
        }

        .button:hover {
            background-color: #2dd881;
            box-shadow: 0px 15px 20px rgba(46, 229, 157, 0.4);
            color: #fff;
            transform: translateY(-7px);
        }

        .button:active {
            transform: translateY(-1px);
        }



        optgroup.line1 {
            color: #38b000;
        }

        optgroup.line2 {
            color: #b7094c;
        }

        optgroup.line3 {
            color: #437f97;
        }

        optgroup.line4 {
            color: #3b6064;
        }

        optgroup.line5 {
            color: #f79256;
        }
    </style>
</head>
<body>
    <div class="content-container">
        <div class="header">

            <p>แบบฟอร์มบันทึกข้อมูลความเสียหายแผ่น PCB_NG ใหม่</p>
            <div class="statusRJ">
                <p>
                    สถานะ : &nbsp;
                    <?php
                    if ($select[0]['HREC_REJECT_STD'] == 1) {
                    ?>
                        <strong>Rejected</strong>

                    <?php
                    } else {
                    ?>
                        <strong>-</strong>
                    <?php
                    }
                    ?>
                </p>

            </div>
        </div>
        <div class="container">
            <p style="font-size: 16pt; color: #d90429;" class="mt-2">เหตุผลที่ส่งกลับ&nbsp;: &nbsp; <?php echo $select[0]['HREC_REJECT_REMARK'] ?></p>
            <form action="" class="needs-validation mt-3 " novalidate>
                <div class="row">
                    <div class="col-3">
                        <div class="coolinput">
                            <label for="input" class="text ">EMPLOYEE-Code :</label>
                            <input type="text" name="code_emp" id="code_emp" class="input form-control w-100 " required value="<?php echo $_SESSION['id'] ?>" readonly>
                        </div>
                    </div>

                    <div class="col-3 ">
                        <div class="select">
                            <label for="select" class="text-label">Line :</label>
                            <select class="form-select w-100" id="line" value="<?php echo $select[0]['HREC_LINE'] ?>" name="line" required>
                                <option value="" selected disabled>เลือกไลน์ผลิต</option>
                                <optgroup label="Line-MT" class="line1">
                                    <option value="MT-1" <?php echo ($select[0]['HREC_LINE'] == 'MT-1') ? 'selected' : ''; ?>>MT-1</option>
                                    <option value="MT-2" <?php echo ($select[0]['HREC_LINE'] == 'MT-2') ? 'selected' : ''; ?>>MT-2</option>
                                    <option value="MT-3" <?php echo ($select[0]['HREC_LINE'] == 'MT-3') ? 'selected' : ''; ?>>MT-3</option>
                                    <option value="MT-4" <?php echo ($select[0]['HREC_LINE'] == 'MT-4') ? 'selected' : ''; ?>>MT-4</option>
                                    <option value="MT-5" <?php echo ($select[0]['HREC_LINE'] == 'MT-5') ? 'selected' : ''; ?>>MT-5</option>
                                    <option value="MT-6" <?php echo ($select[0]['HREC_LINE'] == 'MT-6') ? 'selected' : ''; ?>>MT-6</option>
                                    <option value="MT-7" <?php echo ($select[0]['HREC_LINE'] == 'MT-7') ? 'selected' : ''; ?>>MT-7</option>
                                    <option value="MT-8" <?php echo ($select[0]['HREC_LINE'] == 'MT-8') ? 'selected' : ''; ?>>MT-8</option>
                                    <option value="MT-9" <?php echo ($select[0]['HREC_LINE'] == 'MT-9') ? 'selected' : ''; ?>>MT-9</option>
                                    <option value="MT-10" <?php echo ($select[0]['HREC_LINE'] == 'MT-10') ? 'selected' : ''; ?>>MT-10</option>
                                    <option value="MT-11" <?php echo ($select[0]['HREC_LINE'] == 'MT-11') ? 'selected' : ''; ?>>MT-11</option>
                                    <option value="MT-12" <?php echo ($select[0]['HREC_LINE'] == 'MT-12') ? 'selected' : ''; ?>>MT-12</option>
                                    <option value="MT-13" <?php echo ($select[0]['HREC_LINE'] == 'MT-13') ? 'selected' : ''; ?>>MT-13</option>
                                    <option value="MT-14" <?php echo ($select[0]['HREC_LINE'] == 'MT-14') ? 'selected' : ''; ?>>MT-14</option>
                                    <option value="MT-15" <?php echo ($select[0]['HREC_LINE'] == 'MT-15') ? 'selected' : ''; ?>>MT-15</option>
                                </optgroup>
                                <optgroup label="Line-SMT" class="line2">
                                    <option value="SMT-1" <?php echo ($select[0]['HREC_LINE'] == 'SMT-1') ? 'selected' : ''; ?>>SMT-1</option>
                                    <option value="SMT-2" <?php echo ($select[0]['HREC_LINE'] == 'SMT-2') ? 'selected' : ''; ?>>SMT-2</option>
                                    <option value="SMT-3" <?php echo ($select[0]['HREC_LINE'] == 'SMT-3') ? 'selected' : ''; ?>>SMT-3</option>
                                    <option value="SMT-4" <?php echo ($select[0]['HREC_LINE'] == 'SMT-4') ? 'selected' : ''; ?>>SMT-4</option>
                                    <option value="SMT-5" <?php echo ($select[0]['HREC_LINE'] == 'SMT-5') ? 'selected' : ''; ?>>SMT-5</option>
                                    <option value="SMT-6" <?php echo ($select[0]['HREC_LINE'] == 'SMT-6') ? 'selected' : ''; ?>>SMT-6</option>
                                    <option value="SMT-7" <?php echo ($select[0]['HREC_LINE'] == 'SMT-7') ? 'selected' : ''; ?>>SMT-7</option>
                                    <option value="SMT-8" <?php echo ($select[0]['HREC_LINE'] == 'SMT-8') ? 'selected' : ''; ?>>SMT-8</option>
                                    <option value="SMT-9" <?php echo ($select[0]['HREC_LINE'] == 'SMT-9') ? 'selected' : ''; ?>>SMT-9</option>
                                    <option value="SMT-10" <?php echo ($select[0]['HREC_LINE'] == 'SMT-10') ? 'selected' : ''; ?>>SMT-10</option>
                                    <option value="SMT-11" <?php echo ($select[0]['HREC_LINE'] == 'SMT-11') ? 'selected' : ''; ?>>SMT-11</option>
                                    <option value="SMT-12" <?php echo ($select[0]['HREC_LINE'] == 'SMT-12') ? 'selected' : ''; ?>>SMT-12</option>
                                    <option value="SMT-13" <?php echo ($select[0]['HREC_LINE'] == 'SMT-13') ? 'selected' : ''; ?>>SMT-13</option>
                                    <option value="SMT-14" <?php echo ($select[0]['HREC_LINE'] == 'SMT-14') ? 'selected' : ''; ?>>SMT-14</option>
                                    <option value="SMT-15" <?php echo ($select[0]['HREC_LINE'] == 'SMT-15') ? 'selected' : ''; ?>>SMT-15</option>
                                    <option value="SMT-16" <?php echo ($select[0]['HREC_LINE'] == 'SMT-16') ? 'selected' : ''; ?>>SMT-16</option>
                                    <option value="SMT-17" <?php echo ($select[0]['HREC_LINE'] == 'SMT-17') ? 'selected' : ''; ?>>SMT-17</option>
                                    <option value="SMT-18" <?php echo ($select[0]['HREC_LINE'] == 'SMT-18') ? 'selected' : ''; ?>>SMT-18</option>
                                    <option value="SMT-19" <?php echo ($select[0]['HREC_LINE'] == 'SMT-19') ? 'selected' : ''; ?>>SMT-19</option>
                                    <option value="SMT-20" <?php echo ($select[0]['HREC_LINE'] == 'SMT-20') ? 'selected' : ''; ?>>SMT-20</option>
                                </optgroup>
                                <optgroup label="Line-AV" class="line3">
                                    <option value="AV-1" <?php echo ($select[0]['HREC_LINE'] == 'AV-1') ? 'selected' : ''; ?>>AV-1</option>
                                    <option value="AV-2" <?php echo ($select[0]['HREC_LINE'] == 'AV-2') ? 'selected' : ''; ?>>AV-2</option>
                                    <option value="AV-3" <?php echo ($select[0]['HREC_LINE'] == 'AV-3') ? 'selected' : ''; ?>>AV-3</option>
                                    <option value="AV-4" <?php echo ($select[0]['HREC_LINE'] == 'AV-4') ? 'selected' : ''; ?>>AV-4</option>
                                </optgroup>
                                <optgroup label="Line-RH" class="line4">
                                    <option value="RH-1" <?php echo ($select[0]['HREC_LINE'] == 'RH-1') ? 'selected' : ''; ?>>RH-1</option>
                                    <option value="RH-2" <?php echo ($select[0]['HREC_LINE'] == 'RH-2') ? 'selected' : ''; ?>>RH-2</option>
                                    <option value="RH-3" <?php echo ($select[0]['HREC_LINE'] == 'RH-3') ? 'selected' : ''; ?>>RH-3</option>
                                    <option value="RH-4" <?php echo ($select[0]['HREC_LINE'] == 'RH-4') ? 'selected' : ''; ?>>RH-4</option>
                                    <option value="RH-5" <?php echo ($select[0]['HREC_LINE'] == 'RH-5') ? 'selected' : ''; ?>>RH-5</option>
                                </optgroup>
                                <optgroup label="TPP" class="line5">
                                    <option value="TPP" <?php echo ($select[0]['HREC_LINE'] == 'TPP') ? 'selected' : ''; ?>>TPP</option>
                                </optgroup>
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <label for="select" class="text-label mt-1 ">Customer :</label>
                        <select class="form-select w-100" id="customer" name="customer" onchange="autowon()" required>
                            <option value="0" selected disabled>เลือกลูกค้า</option>
                            <?php
                            for ($i = 0; $i < sizeof($stmt); $i++) {

                            ?>
                                <option value="<?php echo $stmt[$i]['BGCD'] ?>" <?php echo ($select[0]['HREC_CUS'] == $stmt[$i]['BGCD']) ? 'selected' : ''; ?>><?php echo $stmt[$i]['BGCD'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-3">
                        <div class="coolinput">
                            <label for="input" class="text ">Work Order :</label>
                            <input type="text" name="wo" id="wo" class="input" value="<?php echo $select[0]['HREC_WON'] ?>" placeholder="work order" required>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-3 mt-2">
                        <div class="coolinput">
                            <label for="input" class="text ">Model Code :</label>
                            <input type="text" name="md_code" id="md_code" value="<?php echo $select[0]['HREC_MDLCD'] ?>" class="input" placeholder="Auto" readonly required>
                        </div>
                    </div>
                    <div class="col-3 mt-2">
                        <div class="coolinput">
                            <label for="input" class="text ">Model Name :</label>
                            <input type="text" name="md_name" id="md_name" value="<?php echo $select[0]['HREC_MDLNM'] ?>" class="input" placeholder="Auto" readonly required>
                        </div>
                    </div>
                    <div class="col-3 mt-1">
                        <div class="select ">
                            <label for="select" class="text-label">PCB_NG Case :</label>
                            <select class="form-select mt-1 w-100" id="cases" name="cases" required>
                                <option value="0" selected disabled>เหตุที่เสีย</option>
                                <?php
                                for ($i = 0; $i < sizeof($data1); $i++) {
                                ?>
                                    <option value="<?php echo $data1[$i]['CASE_NAME'] ?>" <?php echo ($select[0]['HREC_NGCASE'] ==  $data1[$i]['CASE_NAME']) ? 'selected' : ''; ?>><?php echo $data1[$i]['CASE_NAME'] . " " . $data1[$i]['CASE_NAMETHA'] ?></option>
                                <?php
                                }

                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-3 mt-1">
                        <div class="select ">
                            <label for="select" class="text-label">NG-Process :</label>
                            <select class="form-select mt-1 w-100" id="process" name="process" required>
                                <option value="0" selected disabled>กระบวนการผลิต</option>
                                <?php
                                for ($i = 0; $i < sizeof($data2); $i++) {
                                ?>
                                    <option value="<?php echo $data2[$i]['PRO_NAME'] ?>" <?php echo ($select[0]['HREC_NGPROCESS'] ==  $data2[$i]['PRO_NAME']) ? 'selected' : ''; ?>><?php echo $data2[$i]['PRO_NAME'] ?></option>

                                <?php
                                }

                                ?>
                            </select>
                        </div>
                    </div>

                </div>



                <div class="row">
                    <div class="col-4">
                        <div class="form-group" id="areatxt">
                            <label for="exampleTextarea">Problem : </label>
                            <textarea class="form-control" id="problem" rows="5" value="" name="problem" placeholder="บอกปัญหา" required><?php echo $select[0]['HREC_PROBLEM'] ?></textarea>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group" id="areatxt">
                            <label for="exampleTextarea">Cause : </label>
                            <textarea class="form-control" id="cause" rows="5" value="" name="cause" placeholder="บอกสาเหตุ" required><?php echo $select[0]['HREC_CAUSE'] ?></textarea>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group" id="areatxt">
                            <label for="exampleTextarea">Currentive&Preventive Action : </label>
                            <textarea class="form-control" id="action" rows="5" value="" name="action" placeholder="บอกวิธีการป้องกัน" required><?php echo $select[0]['HREC_ACTION'] ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <div class="coolinput mt-2">
                            <label for="input" class="text ">NG Position :</label>

                            <input type="text" name="position" id="position" value="<?php echo $select[0]['HREC_NG_POSITION'] ?>" class="input" placeholder="ระบุ position" required>

                        </div>

                    </div>
                    <div class="col-3">
                        <div class="coolinput mt-2">
                            <label for="input" class="text ">Q'ty :</label>

                            <input type="number" name="qty" id="qty" value="<?php echo $select[0]['HREC_QTY'] ?>" class="input" min="1" required>

                        </div>

                    </div>
                    <div class="col-4">
                        <div class="coolinput mt-2">
                            <label for="input" class="text ">Reference Document :</label>

                            <input type="text" name="ref" id="ref" class="input form-control" placeholder="ระบุ ref doc." value="<?php echo $select[0]['HREC_REF_DOC'] ?>" required>

                        </div>

                    </div>

                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="coolinput mt-2 ">
                            <label for="input" class="text mb-2">Serial Number :</label>
                            <div id="container" style="max-height: 150px; overflow-y: auto;">
                                <div class="input-group">
                                    <input type="text" name="serial" id="serial" class="input form-control " placeholder="ระบุ serial number" value="<?php echo $select[0]['HREC_SERIAL'] ?>">
                                </div>
                            </div>                          


                        </div>
                    </div>

                </div>
                
 
                <div class="btn d-flex justify-content-center">
                    <button class="button" name="btnNewUpdate" type="submit" id="btnNewUpdate">
                        New Update
                    </button>
                    <input type="hidden" name="get_hrec_id" id="get_hrec_id" value="<?php echo $get_hrec_id; ?>">
                </div>
            </form>

        </div>

    </div>
    <script src="../../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../../node_modules/jquery-ui/dist/jquery-ui.min.js"></script>
    <script src="../../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../../node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <script src="../../node_modules/jquery-ui.autocomplete.scroll/jquery.ui.autocomplete.scroll.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script> -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
    <!-- <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script> -->
    <!-- <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script> -->
    <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/jquery-ui.autocomplete.scroll@0.1.9/jquery.ui.autocomplete.scroll.min.js"></script> -->
    <script>
        $(document).ready(function() {
            $("#btnNewUpdate").on('click', function(e) {
                e.preventDefault()
                $.ajax({
                    url: 'rejectData.php',
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        line: document.getElementById('line').value,
                        customer: document.getElementById('customer').value,
                        wo: document.getElementById('wo').value,
                        md_code: document.getElementById('md_code').value,
                        md_name: document.getElementById('md_name').value,
                        cases: document.getElementById('cases').value,
                        process: document.getElementById('process').value,
                        problem: document.getElementById('problem').value,
                        cause: document.getElementById('cause').value,
                        action: document.getElementById('action').value,
                        position: document.getElementById('position').value,
                        qty: document.getElementById('qty').value,
                        ref: document.getElementById('ref').value,
                        serial: document.getElementById('serial').value,
                        id: document.getElementById('get_hrec_id').value,
                        
                    },
                    beforeSend: () => {
                        Swal.fire({
                            title: "กำลังบันทึกข้อมูลใหม่",
                            icon: "info",
                            showConfirmButton: false,

                        })

                    },
                    success: async function(data) {
                        setTimeout(function() {
                            window.close();
                            window.opener.location.reload()
                        }, 1500)
                    },
                    error: function() {
                        alert('New Record Error')
                    }


                })


            })
        });




        autowon = () => {
            let cus = $('#customer').val();
            $('#wo').focus();
            $.ajax({
                url: '../RejectPCB/getWorkorder.php',
                method: 'POST',
                dataType: 'JSON',
                data: {
                    cus: cus
                },
                success(response) {
                    console.log(response)
                    if (response.std == true) {
                        let arr_won = [];
                        let mdlcd = {};
                        let mdlnm = {};

                        for (let i = 0; i < response.data.length; i++) {
                            //console.log(response[i]['WON']);
                            arr_won.push(response.data[i]['WON']);
                            mdlcd[response.data[i]['WON']] = response.data[i]['MDLCD'];
                            mdlnm[response.data[i]['WON']] = response.data[i]['MDLNM'];

                        }

                        console.log(arr_won);
                        $('#wo').autocomplete({
                            source: arr_won,
                            minLength: 4,
                            maxShowItems: 10,
                            select: function(event, ui) {
                                console.log(ui.item.value);
                                $('#md_code').val(mdlcd[ui.item.value]);
                                $('#md_name').val(mdlnm[ui.item.value]);

                            }
                        });
                    } else {

                        $('#wo').val('');
                        $('#md_code').val('');
                        $('#md_name').val('');
                        Swal.fire({
                            title: "NO DATA",
                            icon: "error",
                            timer: 3000,
                        });
                    }


                }
            })
        }
        
    </script>
</body>

</html>