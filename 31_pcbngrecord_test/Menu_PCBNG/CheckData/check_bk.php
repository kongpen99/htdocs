<?php
session_start();
// error_reporting(0);
include '../../../Include/class/connect_sql.php';
$conn = new CSQL;
$server = "172.22.64.11";
$db = "PCB_NG_DATA";
$conn->connect($server, $db);

$emp_id = $_SESSION['id'];
$check = "SELECT * FROM [PCBREC_H_TBL] WHERE [HREC_STD] = 0";
$conn->Query($check);
$stmt = $conn->FetchData();
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ตรวจสอบและอนุมัติ
    </title>
    <link rel="shortcut icon" href="../../images/check.png" type="image/x-icon">
    <link rel="stylesheet" href="CheckData/check.css?v=2">
</head>
<body>

    <div class="container-fluid">
        <div class="header">
            <div class="beautiful d-flex justify-content-center ">
                <p style="font-family: 'Mitr', sans-serif;">ตรวจสอบความเสียหายแผ่น PCB</p>
            </div>
        </div>
        <div class="px-5">
            <table class="table" id="PCB">
                <thead>
                    <tr>
                        <th scope="col">Option</th>
                        <th scope="col">Date</th>
                        <th scope="col">Status RJ</th>

                        <th scope="col">Customer (ลูกค้า)</th>
                        <th scope="col">Line (ไลน์ผลิต)</th>
                        <th scope="col">Work Order</th>
                        <th scope="col">Model Code</th>
                        <th scope="col">Serial Number</th>
                        <th scope="col">PCB_NG Case</th>
                        <th scope="col">NG Pocess</th>
                        <th scope="col">Problem</th>
                        <th scope="col">Cause (สาเหตุ)</th>
                        <th scope="col">C&P Action (การป้องกัน)</th>

                    </tr>
                </thead>
                <tbody>

                    <?php
                    $size = array();

                    if (!empty($stmt)) {
                        /**
                         * TODO: แสดงข้อมูลจาก PCBREC_APPROVE_TBL
                         */
                        for ($i = 0; $i < sizeof($stmt); $i++) {
                            $app  = "SELECT * FROM PCBREC_APPROVE_TBL WHERE HREC_ID = '" . $stmt[$i]['HREC_ID'] . "' AND HAPPR_SEQ = '" . $stmt[$i]['HREC_APPRH_TRACKING'] . "'";
                            $conn->Query($app);
                            // print($app);
                            // print("<br>");
                            $app2 = $conn->FetchData();
                            /**
                             * TODO: ถ้า user ที่ 1 ยังไม่อนุมัติ ข้อมูลยังแสดงอยู่ที่ user1
                             */
                            
                            if(!empty($app2)){
                                if ($app2[0]['HAPPR_STD'] == 0) {
                                    $uid = explode(",", $app2[0]['HAPPR_EMP']);
                                    /**
                                     * TODO: ลำดับการอนุมัติ กรณีมี user มากกว่า 2 user ที่อนุมัติ
                                     */
                                    if (in_array($emp_id, $uid)) {
                    ?>  
                                        <tr>
                                            <td>
                                                <button type="button" class="btn btn-warning w-50 " id="click" data-bs-toggle="modal" data-bs-target="#click-check" onclick="getData('<?php echo $stmt[$i]['HREC_ID']; ?>', '<?php echo $app2[0]['HAPPR_SEQ']; ?>', '<?php echo $stmt[$i]['HREC_REJECT_STD']; ?>')">
                                                    Check
                                                </button>
                                            </td>
                                            <td><?php echo date_format($stmt[$i]['HREC_EMP_DREC'], 'd-m-Y'); ?></td>
                                            <?php
                                            if ($stmt[$i]['HREC_REJECT_STD'] == 0) {
                                            ?>
                                                <td>-</td>
                                            <?php
                                            } else {
                                            ?>
                                                <td>Reject Data</td>
                                            <?php
                                            }
                                            ?>
                                            <td><?php echo $stmt[$i]['HREC_CUS'] ?></td>
                                            <td><?php echo $stmt[$i]['HREC_LINE'] ?></td>
                                            <td><?php echo $stmt[$i]['HREC_WON'] ?></td>
                                            <td><?php echo $stmt[$i]['HREC_MDLCD'] ?></td>
                                            <td><?php echo $stmt[$i]['HREC_SERIAL'] ?></td>
                                            <td><?php echo $stmt[$i]['HREC_NGCASE'] ?></td>
                                            <td><?php echo $stmt[$i]['HREC_NGPROCESS'] ?></td>
                                            <td><?php echo $stmt[$i]['HREC_PROBLEM'] ?></td>
                                            <td><?php echo $stmt[$i]['HREC_CAUSE'] ?></td>
                                            <td><?php echo $stmt[$i]['HREC_ACTION'] ?></td>

                                        </tr>

                                    <?php
                                    } else {
                                    ?>
                                    <?php
                                    }
                                    /**
                                     * TODO: กรณีที่กด reject สถานะการอนุมัติ = 2 และข้อมูลจะไปแสดง user ที่มีสถานะเท่ากับ 2
                                     */
                                }
                           
                                if ($app2[0]['HAPPR_STD'] == 2) {
                                    $uid2 = explode(",", $app2[0]['HAPPR_EMP']);
                                    if (in_array($emp_id, $uid2)) {
                                    ?>
                                        <tr>
                                            <td>
                                                <button type="button" class="btn btn-warning w-50 " id="click" data-bs-toggle="modal" data-bs-target="#click-check" onclick="getData('<?php echo $stmt[$i]['HREC_ID']; ?>', '<?php echo $app2[0]['HAPPR_SEQ']; ?>' , '<?php echo $stmt[$i]['HREC_REJECT_STD']; ?>')">
                                                    Check
                                                </button>
                                            </td>
                                            <td><?php echo date_format($stmt[$i]['HREC_EMP_DREC'], 'd-m-Y'); ?></td>
                                            <?php
                                            if ($stmt[$i]['HREC_REJECT_STD'] == 0) {
                                            ?>
                                                <td>-</td>
                                            <?php
                                            } else {
                                            ?>
                                                <td>Reject Data</td>
                                            <?php
                                            }
                                            ?>
                                            <td><?php echo $stmt[$i]['HREC_CUS'] ?></td>
                                            <td><?php echo $stmt[$i]['HREC_LINE'] ?></td>
                                            <td><?php echo $stmt[$i]['HREC_WON'] ?></td>
                                            <td><?php echo $stmt[$i]['HREC_MDLCD'] ?></td>
                                            <td><?php echo $stmt[$i]['HREC_SERIAL'] ?></td>
                                            <td><?php echo $stmt[$i]['HREC_NGCASE'] ?></td>
                                            <td><?php echo $stmt[$i]['HREC_NGPROCESS'] ?></td>
                                            <td><?php echo $stmt[$i]['HREC_PROBLEM'] ?></td>
                                            <td><?php echo $stmt[$i]['HREC_CAUSE'] ?></td>
                                            <td><?php echo $stmt[$i]['HREC_ACTION'] ?></td>

                                        </tr>
                        <?php
                                    }
                                }
                            }
                        }
                        ?>
                    <?php
                    } else {
                    ?>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
            <div class="modal fade bd-example-modal-xl" data-bs-focus="false" id="click-check" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                        <th scope="col" style="background-color: #d1495b; font-size: 20px; color: #fff; text-align: start; width: 10%;">Date</th>
                                        <td id="hrec_date" class="border "></td>
                                    </tr>
                                    <tr>
                                        <th scope="col" style="background-color: #d1495b; font-size: 20px; color: #fff; text-align: start; width: 10%;">Line</th>
                                        <td id="hrec_line" class="border "></td>
                                    </tr>
                                    <tr>
                                        <th scope="col" style="background-color: #d1495b; font-size: 20px; color: #fff; text-align: start; width: 10%;">Work Order</th>
                                        <td id="hrec_won" class="border "></td>
                                        <td id="hrec_won2" class="border "><svg id="barcode"></svg></td>
                                    </tr>
                                    <tr>
                                        <th scope="col" style="background-color: #d1495b; font-size: 20px; color: #fff; text-align: start; width: 10%;">Q'ty</th>
                                        <td id="hrec_qty" class="border "></td>
                                        <td id="hrec_qty2" class="border "><svg id="barcode2"></svg></td>
                                    </tr>
                                    <tr>
                                        <th scope="col" style="background-color: #d1495b; font-size: 20px; color: #fff; text-align: start;">Model Code</th>
                                        <td id="hrec_mdlcd" class="border"></td>
                                    </tr>
                                    <tr>

                                        <th scope="col" style="background-color: #d1495b; font-size: 20px; color: #fff; text-align: start;">Serial Number</th>
                                        <td id="hrec_serial" class="border"></td>
                                    </tr>
                                    <tr>

                                        <th scope="col" style="background-color: #d1495b; font-size: 20px; color: #fff; text-align: start;">NG Case</th>
                                        <td id="hrec_ngcase" class="border"></td>
                                    </tr>
                                    <tr>

                                        <th scope="col" style="background-color: #d1495b; font-size: 20px; color: #fff; text-align: start;">NG Process</th>
                                        <td id="hrec_ngprocess" class="border"></td>
                                    </tr>
                                    <tr>

                                        <th scope="col" style="background-color: #d1495b; font-size: 20px; color: #fff; text-align: start;">Problem</th>
                                        <td id="problem" class="border"></td>
                                    </tr>
                                    <tr>
                                        <th scope="col" style="background-color: #d1495b; font-size: 20px; color: #fff; text-align: start;">Cause</th>
                                        <td id="cause" class="border"></td>
                                    </tr>
                                    <tr>

                                        <th scope="col" style="background-color: #d1495b; font-size: 20px; color: #fff; text-align: start;">Action</th>
                                        <td id="action" class="border"></td>

                                    </tr>
                                    <tr>

                                        <th scope="col" style="background-color: #d1495b; font-size: 20px; color: #fff; text-align: start;">เหตุผลที่ reject</th>
                                        <td id="text_rj" class="border"></td>

                                    </tr>

                                </table>
                                <div class="row">
                                    <div class="d-flex justify-content-between">
                                        <div class="col">
                                            <div class="">
                                                <button type="submit" class="btn btn-warning " id="updaterj" name="updaterj"><i class="fa-solid fa-pen-clip mx-2"></i>Update ข้อมูลใหม่</button>

                                            </div>
                                            <input type="hidden" name="rejectstd" id="rejectstd">
                                            <div class="">
                                                <button type="submit" class="btn btn-secondary mt-2 " id="deletedata" name="deletedata"><i class="fa-solid fa-trash mx-2"></i>Delete Data</button>

                                            </div>


                                        </div>
                                        <div class="col">
                                            <div class="d-flex flex-row-reverse ">
                                                <button type="button" class="btn btn-secondary " data-bs-dismiss="modal"><i class="fa-solid fa-xmark mx-2"></i>Close</button>
                                                <button type="submit" class="btn btn-danger mx-2" id="reject" name="reject"><i class="fa-solid fa-eject mx-2 "></i>ส่งกลับ</button>
                                                <button type="submit" class="btn btn-warning mx-2" id="edit" name="edit"><i class="fa-solid fa-pen-to-square mx-2"></i>แก้ไข</button>
                                                <button type="submit" class="btn btn-success " id="submitapp" name="submitapp"><i class="fa-solid fa-circle-check mx-2 "></i>อนุมัติ</button>

                                            </div>
                                            <input type="hidden" name="hrec_id" id="hrec_id">
                                            <input type="hidden" name="track" id="track">
                                        </div>
                                    </div>

                                </div>

                            </div>




                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- <script src="https://cdn.jsdelivr.net/jsbarcode/3.6.0/JsBarcode.all.min.js"></script> -->
    <script src="../../node_modules/jsbarcode/dist/JsBarcode.all.min.js"></script>
    <script>
        if ($.fn.DataTable.isDataTable("#PCB")) {
            $("#PCB").DataTable().destroy(); //* สั่ง destroy
        }
        $("#PCB").dataTable({
            paging: true,
            scrollX: true,
            scrollY: "60vh",
            scrollCollapse: true,
            columnDefs: [{
                    width: 200,
                    targets: [0, 1, 2, 3, 4],
                },
                {
                    width: 300,
                    targets: [5, 6, 7],
                },
                {
                    width: 300,
                    targets: [8, 9],
                },
                {
                    width: 400,
                    targets: [10, 11, 12],
                },
                {
                    className: "dt-left",
                    targets: [10, 11, 12],
                },
                {
                    className: "dt-center",
                    targets: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
                },
            ],
            fixedColumns: true,
        });
        $("#edit").on("click", function(event) {
            let revid = $("#hrec_id").val();
            event.preventDefault();
            Swal.fire({
                title: "คุณต้องการแก้ไขใช่หรือไม่",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, I want edit.",
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    window.open("UpdateData/update.php?send_hrecid=" + revid + "", "_blank");
                }
            });
        });


        /**@abstract
         * TODO: กดปุ่มส่งกลับ ให้แสดง sweatalert กรอกเหตุผล 
         */
        $("#reject").on("click", function(event) {
            let revid = $("#hrec_id").val();
            event.preventDefault();

            Swal.fire({
                title: "คุณต้องการ Reject ?",
                text: "บอกเหตุผล",
                input: "text",
                inputPlaceholder: "กรุณากรอกเหตุผลด้วย",
                showCancelButton: true,
                confirmButtonText: "Yes",
                confirmButtonColor: "#8ac926",
                cancelButtonText: "Cancel",
                cancelButtonColor: "#d33",
                showLoaderOnConfirm: true,
                preConfirm: (text) => {
                    if (!text) {
                        Swal.showValidationMessage(`Please enter a reason.`);
                        return false;
                    }
                    return text;
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    storeData(result.value);
                }
            });

            function storeData(enteredText) {
                $.ajax({
                    url: "../Menu_PCBNG/CheckData/rejectRemark.php",
                    method: "GET",
                    dataType: "json",
                    data: {
                        hrec_id: $("#hrec_id").val(),
                        remark: enteredText,
                        rejectstd: $("#rejectstd").val(),
                    },
                    beforeSend: function() {
                        Swal.fire({
                            title: "กำลัง Reject ข้อมูล",
                            icon: "info",
                            showConfirmButton: false,
                        });
                    },
                    success: function(data) {
                        console.log(data);
                        if (data.std == true) {
                            Swal.fire({
                                title: "Reject ข้อมูลสำเร็จ",
                                icon: "success",
                                timer: 1500
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: "เกิดข้อผิดพลาด",
                                text: "ไม่สามารถ Reject ข้อมูลได้",
                                icon: "error",
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            title: "เกิดข้อผิดพลาด",
                            text: "เกิดข้อผิดพลาดในการส่งคำขอ: " + error,
                            icon: "error",
                        });
                    },
                });
            }
        });

        //อย่าลืมกรอกเหตุผลในการ Reject
        /**
         * TODO: ทำกดปุ่ม Update ข้อมูลใหม่
         */
        $("#updaterj").on("click", function(event) {
            let revid = $("#hrec_id").val();
            event.preventDefault();
            window.open("RejectPCB/reject.php?send_hrecid=" + revid + "", "_blank");
        });

        /**
         * TODO: ลบข้อมูลที่หน้า Deletedata.php
         */
        $("#deletedata").on("click", function(event) {
            let revid = $("#hrec_id").val();
            event.preventDefault();
            Swal.fire({
                title: "คุณต้องการลบข้อมูลหรือไม่",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Yes, I want delete.",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                    url: "../Menu_PCBNG/CheckData/Deletedata.php",
                    method: "GET",
                    dataType: "json",
                    data: {
                        hrec_id: $("#hrec_id").val(),
                        
                    },
                    beforeSend: function() {
                        Swal.fire({
                            title: "กำลังลบข้อมูล",
                            icon: "info",
                            showConfirmButton: false,
                        });
                    },
                    success: function(data) {
                        console.log(data);
                        if (data.std == true) {
                            Swal.fire({
                                title: "ลบข้อมูลสำเร็จ",
                                icon: "success",
                                timer: 1000
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: "เกิดข้อผิดพลาด",
                                text: "ไม่สามารถลบข้อมูลได้",
                                icon: "error",
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            title: "เกิดข้อผิดพลาด",
                            text: "เกิดข้อผิดพลาดในการส่งคำขอ: " + error,
                            icon: "error",
                        });
                    },
                });
                    // window.location.href = "./Deletedata.php";
                    // window.location.reload();
                }
            });
        })

        /**
         * ?การจัดวาง table ใน modal
         * *ส่วนของ Modal
         */
        getData = (get_hrec_id, get_hrec_seq, get_hrec_std) => {
            // alert(get_hrec_id);
            $.ajax({
                url: "CheckData/getData.php",
                method: "POST",
                dataType: "JSON",
                data: {
                    hrec_id: get_hrec_id,
                },
                success(response) {
                    console.log(response);
                    console.log(response[0].HREC_CUS);
                    console.log(response[0]["HREC_CUS"]);
                    $("#problem").html(response[0]["HREC_PROBLEM"]);
                    $("#cause").html(response[0]["HREC_CAUSE"]);
                    $("#action").html(response[0]["HREC_ACTION"]);
                    $("#hrec_won").html(response[0]["HREC_WON"]);
                    JsBarcode('#barcode',response[0]["HREC_WON"],{
                        width: 1,
                        height: 30
                    });
                    $("#hrec_qty").html(response[0]["HREC_QTY"]);
                    JsBarcode('#barcode2', response[0]["HREC_QTY"], {
                        width: 2,
                        height: 30
                    });
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
                    $("rejectstd").val(response[0]["HREC_REJECT_STD"]);
                    
                    if (get_hrec_seq >= 2) {
                        $("#edit").hide();
                    }

                    if (get_hrec_std == 1) {
                        $("#updaterj").show();
                        $("#text_rj").html(response[0]["HREC_REJECT_REMARK"]);
                    } else {
                        $("#updaterj").hide();
                    }
                },
            });
        };
    </script>
</body>
</html>