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

$sql = "SELECT * FROM VBG";
$conn->Query($sql);
$stmt = $conn->FetchData();

$ng = "SELECT * FROM NGCASE_MASTER";
$conn->Query($ng);
$data1 = $conn->FetchData();

$processng = "SELECT * FROM PROCESS_MASTER";
$conn->Query($processng);
$data2 = $conn->FetchData();

$check2 = "SELECT * FROM [PCBREC_H_TBL] WHERE HREC_APPRH_TRACKING = 0";
$conn->Query($check2);
$stmt2 = $conn->FetchData();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>บันทึกข้อมูล
    </title>
    <link rel="shortcut icon" href="../../images/background-check.png" type="image/x-icon">
    <link rel="stylesheet" href="Record/textREC.css?v=3">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"> -->
    <link rel="stylesheet" href="../../node_modules/animate.css/animate.min.css">
</head>

<body>
    <div class="container">
        <div class="header">
            <form action="">
                <?php
                $shtr = "SELECT * FROM PCBREC_H_TBL WHERE HREC_ID = '" . $stmt2[0]['HREC_ID'] . "'";
                $conn->Query($shtr);
                $trackap = $conn->FetchData();


                if ($trackap[0]['HREC_SEC'] == $_SESSION['emp_sec']) {
                    if ($trackap[0]['HREC_APPRH_TRACKING'] == 0) {
                ?>
                        <button type="button" class="btn btn-warning mx-5 animate__animated animate__pulse animate__infinite" id="click" data-bs-toggle="modal" data-bs-target="#show" onclick="getData2('<?php echo $trackap[0]['HREC_ID']; ?>')">แก้ไขข้อมูล</button>

                <?php
                    }
                }
                ?>
                <input type="hidden" name="hrec_id" id="hrec_id">
            </form>

            <p class="mx-5 ms-5">แบบฟอร์มบันทึกข้อมูลความเสียหายแผ่น PCB_NG</p>
        </div>
        <div class="container">
            <form action="" method="POST" id="form_record" class="needs-validation mt-3 " novalidate>
                <div class="row">
                    <div class="col-3">
                        <div class="coolinput">
                            <label for="input" class="text ">EMPLOYEE-Code :</label>
                            <input type="text" name="code_emp" id="code_emp" class="input form-control w-100 " required value="<?php
                                                                                                                                echo $_SESSION['id'] ?>" readonly>
                        </div>
                    </div>

                    <div class="col-3 ">
                        <div class="select">
                            <label for="select" class="text-label">Line :</label>
                            <select class="form-select w-100" id="line" name="line" required>
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
                    </div>
                    <div class="col-3">
                        <label for="select" class="text-label mt-1 " style="font-family: 'Chakra Petch', sans-serif;">Customer :</label>
                        <select class="form-select w-100" id="customer" name="customer" onchange="autowon(this)" required>
                            <option value="" selected disabled>เลือกลูกค้า</option>
                            <?php
                            for ($i = 0; $i < sizeof($stmt); $i++) {

                            ?>
                                <option value="<?php echo $stmt[$i]['BGCD'] ?>"><?php echo $stmt[$i]['BGCD'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-3">
                        <div class="coolinput">
                            <label for="input" class="text ">Work Order :</label>
                            <input type="text" name="wo" id="wo" class="input form-control " placeholder="work order" required>
                        </div>
                    </div>

                </div>
                <div class="row">


                    <div class="col-3 mt-2">
                        <div class="coolinput">
                            <label for="input" class="text ">Model Code :</label>
                            <input type="text" name="md_code" id="md_code" class="input form-control" placeholder="Auto" readonly required>
                        </div>
                    </div>
                    <div class="col-3 mt-2">
                        <div class="coolinput">
                            <label for="input" class="text ">Model Name :</label>
                            <input type="text" name="md_name" id="md_name" class="input form-control" placeholder="Auto" readonly required>
                        </div>
                    </div>
                    <div class="col-3 mt-1">
                        <div class="select ">
                            <label for="select" class="text-label">PCB_NG Case :</label>
                            <select class="form-select mt-1 w-100" id="cases" name="cases" required>
                                <option value="" selected disabled>เหตุที่เสีย</option>
                                <?php
                                for ($i = 0; $i < sizeof($data1); $i++) {
                                ?>


                                    <option value="<?php echo $data1[$i]['CASE_NAME'] ?>">
                                        <?php echo $data1[$i]['CASE_NAME'] . " " . $data1[$i]['CASE_NAMETHA'] ?></option>
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
                                <option value="" selected disabled>กระบวนการผลิต</option>
                                <?php
                                for ($i = 0; $i < sizeof($data2); $i++) {
                                ?>


                                    <option value="<?php echo $data2[$i]['PRO_NAME'] ?>">
                                        <?php echo $data2[$i]['PRO_NAME'] ?></option>



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
                            <textarea class="form-control" id="problem" rows="5" name="problem" placeholder="บอกปัญหา" required></textarea>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group" id="areatxt">
                            <label for="exampleTextarea">Cause : </label>
                            <textarea class="form-control" id="cause" rows="5" name="cause" placeholder="บอกสาเหตุ" required></textarea>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group" id="areatxt">
                            <label for="exampleTextarea">Corrective & Preventive Action : </label>
                            <textarea class="form-control" id="action" rows="5" name="action" placeholder="บอกวิธีการป้องกัน" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <div class="coolinput mt-2">
                            <label for="input" class="text ">NG Position :</label>

                            <input type="text" name="position" id="position" class="input form-control mt-2" placeholder="ระบุ position" required>

                        </div>

                    </div>
                    <div class="col-4">
                        <div class="coolinput mt-2">
                            <label for="input" class="text ">Q'ty :</label>

                            <input type="number" name="qty" id="qty" class="input form-control mt-2" min="1" required>

                        </div>

                    </div>
                    <div class="col-4">
                        <div class="coolinput mt-2">
                            <label for="input" class="text ">Reference Document :</label>

                            <input type="text" name="ref" id="ref" class="input form-control mt-2" placeholder="ระบุ ref doc.">

                        </div>

                    </div>

                </div>

                <div class="row">
                    <div class="col-lg-4">
                        <div class="coolinput mt-2 ">
                            <label for="input" class="text mb-2">Serial Number :</label>
                            <div id="container" style="max-height: 150px; overflow-y: auto;">
                                <div class="input-group">
                                    <input type="text" name="serial[]" id="serial" class="input form-control " placeholder="ระบุ serial number">
                                </div>
                            </div>
                            <div class="input" id="inputadd">

                            </div>


                        </div>
                    </div>

                </div>
                <div class="row">

                    <div class="col-lg-4 d-flex justify-content-center mt-4">
                        <button type="button" onclick="addInput()" class="btn btn-secondary">เพิ่มช่องใส่ข้อมูล</button>
                    </div>

                </div>

                <div class="btn d-flex justify-content-center">
                    <button class="button" name="submit" type="submit" id="submit">
                        Save
                    </button>
                </div>
            </form>

        </div>

    </div>
    <div class="modal fade bd-example-modal-xl" data-bs-focus="false" id="show" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl ">
            <div class="modal-content">
                <div class="modal-header ">
                    <h1 class="modal-title fs-4" id="exampleModalLabel" style="color: #FF6C22;">ตรวจสอบข้อมูล</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="">
                    <div class="modal-body overflow-auto ">

                        <table class="table" id="data1">
                            <tr>
                                <th scope="col" style="background-color: #d1495b; font-size: 18px; color: #fff; text-align: start; width: 10%;">Date</th>
                                <td id="hrec_date" class="border "></td>
                            </tr>
                            <tr>
                                <th scope="col" style="background-color: #d1495b; font-size: 18px; color: #fff; text-align: start; width: 10%;">Line</th>
                                <td id="hrec_line" class="border "></td>
                            </tr>
                            <tr>
                                <th scope="col" style="background-color: #d1495b; font-size: 18px; color: #fff; text-align: start; width: 10%;">Work Order</th>
                                <td id="hrec_won" class="border "></td>
                            </tr>
                            <tr>
                                <th scope="col" style="background-color: #d1495b; font-size: 18px; color: #fff; text-align: start;">Model Code</th>
                                <td id="hrec_mdlcd" class="border"></td>
                            </tr>
                            <tr>

                                <th scope="col" style="background-color: #d1495b; font-size: 18px; color: #fff; text-align: start;">Serial Number</th>
                                <td id="hrec_serial" class="border"></td>
                            </tr>
                            <tr>

                                <th scope="col" style="background-color: #d1495b; font-size: 18px; color: #fff; text-align: start;">NG Case</th>
                                <td id="hrec_ngcase" class="border"></td>
                            </tr>
                            <tr>

                                <th scope="col" style="background-color: #d1495b; font-size: 18px; color: #fff; text-align: start;">NG Process</th>
                                <td id="hrec_ngprocess" class="border"></td>
                            </tr>
                            <tr>

                                <th scope="col" style="background-color: #d1495b; font-size: 18px; color: #fff; text-align: start;">Problem</th>
                                <td id="problems" class="border"></td>
                            </tr>
                            <tr>
                                <th scope="col" style="background-color: #d1495b; font-size: 18px; color: #fff; text-align: start;">Cause</th>
                                <td id="causes" class="border"></td>
                            </tr>
                            <tr>

                                <th scope="col" style="background-color: #d1495b; font-size: 18px; color: #fff; text-align: start;">Action</th>
                                <td id="actions" class="border"></td>

                            </tr>

                        </table>
                        <div class="row">
                            <div class="d-flex justify-content-between">
                                <div class="col">
                                    <div class="">
                                        <button type="submit" class="btn btn-warning " id="updaterj" name="updaterj"><i class="fa-solid fa-pen-clip mx-2"></i>Update ข้อมูลใหม่</button>

                                    </div>
                                    <input type="hidden" name="rejectstd" id="rejectstd">


                                </div>
                                <!-- <div class="col">
                                            <div class="d-flex flex-row-reverse ">
                                                <button type="button" class="btn btn-secondary " data-bs-dismiss="modal"><i class="fa-solid fa-xmark mx-2"></i>Close</button>
                                                <button type="submit" class="btn btn-danger mx-2" id="reject" name="reject"><i class="fa-solid fa-eject mx-2 "></i>ส่งกลับ</button>
                                                <button type="submit" class="btn btn-warning mx-2" id="edit" name="edit"><i class="fa-solid fa-pen-to-square mx-2"></i>แก้ไข</button>
                                                <button type="submit" class="btn btn-success " id="submitapp" name="submitapp"><i class="fa-solid fa-circle-check mx-2 "></i>อนุมัติ</button>

                                            </div>
                                            <input type="hidden" name="hrec_id" id="hrec_id">
                                            <input type="hidden" name="track" id="track">
                                        </div> -->
                            </div>

                        </div>

                    </div>


                </form>
            </div>
        </div>
    </div>

    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script> -->
    <!-- <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-ui.autocomplete.scroll@0.1.9/jquery.ui.autocomplete.scroll.min.js"></script> -->
    <script src="../Menu_PCBNG/Record/record.js?v=6"></script>
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

        autowon = (e) => {
            console.log(e.value)
            // let cus = $('#customer').val();  
            let cus = e.value;
            $('#wo').focus();
            $.ajax({
                url: '../Menu_PCBNG/Record/getWorkorder.php',
                method: 'POST',
                dataType: 'JSON',
                data: {
                    cus: cus
                },
                success(response) {
                    console.log(cus)
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

        function addInput() {
            var container = document.getElementById('container');
            var inputGroup = document.createElement('div');
            inputGroup.className = 'input-group';
            inputGroup.innerHTML =
                '<input type="text" name="serial[]" class="input form-control" placeholder="ระบุ serial number">';
            container.appendChild(inputGroup);

            var removeButton = document.createElement('button');
            removeButton.textContent = 'ลบ';
            removeButton.className = 'btn btn-danger';
            removeButton.onclick = function() {
                container.removeChild(inputGroup);
            };

            inputGroup.appendChild(removeButton);
            container.appendChild(inputGroup);
        }
        getData2 = (get_hrec_id) => {
            //alert(get_hrec_id);
            $.ajax({
                url: "Record/getData.php",
                method: "POST",
                dataType: "JSON",
                data: {
                    hrec_id: get_hrec_id,
                },
                success(response) {
                    console.log(response);
                    console.log(response[0].HREC_CUS);
                    console.log(response[0]["HREC_CUS"]);
                    $("#problems").html(response[0]["HREC_PROBLEM"]);
                    $("#causes").html(response[0]["HREC_CAUSE"]);
                    $("#actions").html(response[0]["HREC_ACTION"]);
                    $("#hrec_won").html(response[0]["HREC_WON"]);
                    $("#hrec_mdlcd").html(response[0]["HREC_MDLCD"]);
                    $("#hrec_serial").html(response[0]["HREC_SERIAL"]);
                    $("#hrec_ngcase").html(response[0]["HREC_NGCASE"]);
                    $("#hrec_ngprocess").html(response[0]["HREC_NGPROCESS"]);
                    // $('#hrec_date').html(response[0]['HREC_EMP_DREC'].date)
                    $("#hrec_line").html(response[0]["HREC_LINE"]);
                    $("#hrec_date").html(
                        moment(response[0]["HREC_EMP_DREC"].date).format("DD-MM-YYYY")
                    );
                    // $('#hrec_date').html(moment().tz("Asia/Bangkok").format('DD/MM/YYYY'))
                    $("#hrec_id").val(response[0]["HREC_ID"]);
                    $("#track").val(response[0]["HREC_APPRH_TRACKING"]);




                },
            });
        };
        $("#updaterj").on("click", function(event) {
            let revid = $("#hrec_id").val();
            event.preventDefault();
            window.open("RejectPCB/reject.php?send_hrecid=" + revid + "", "_blank");
        });
        $(document).on('keydown','#form_record', function(e){
            console.log(e.target.id);
            if(e.keyCode == 13){
                //alert('ok');
                if(e.target.id == "serial"){
                    e.preventDefault();                
                    let val = $("#serial").val();
                    let val2 = val + ",";
                    // console.log(val2);
                    //alert('success');
                    $("#serial").val(val2);


                }
                
            }

        });
    </script>

</body>

</html>