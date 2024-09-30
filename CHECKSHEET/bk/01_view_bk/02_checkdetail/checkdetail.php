<?php
$revresult = $_GET['result'];
// print($revresult);
$explodeValue = explode(",",$revresult);
// print_r($explodeValue);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>check detail</title>
    <link rel="stylesheet" href="../../../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../node_modules/datatables.net-bs5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="../../../node_modules/sweetalert2/dist/sweetalert2.min.css">
    <style>
        .card-header-lightblue {
            /* background-color:rgb(55,172,253); */
            /* background-color:rgb(71 153 231); */
            background-color: rgb(45 120 191);
        }

        .th-lnno-bg {
            /* background-color:rgb(0,191,178); */
            background-color:black;
        }
    </style>
</head>
<body class="bg-dark">
    <div class="container"></div>
    <!-- //* Modal NG -->
    <div class="custome-modal"></div>
    <script src="../../../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../../../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../../node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../../../node_modules/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
    <script src="../../../node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <script src="checkdetail.js"></script>
    <!-- //* del_tempdata.js จะเก็บคำสั่งของการลบข้อมูลใน Temp Table -->
    <script src="del_tempdata.js"></script>
    <!-- //* submitdata.js เก็บ fn saveResult() , submitLNNO() คือคำสั่งการบันทึกแต่ละข้อลงไป Temp Table -->
    <script src="submitdata.js"></script>
    <!-- //* callNG.js เก็บ fn CallNG_modal() คือเรียก Modal เวลาที่ user input NG Value -->
    <script src="callNG.js"></script>
    <!-- //* fn ส่งข้อมูลซ้ำอีกครั้ง -->
    <script src="submitdata_resend.js"></script>
    <!-- //* เก็บ fn ส่งข้อมูลเข้าตารางจริง -->
    <script src="submitdata_actual.js"></script>
    <!-- //* sweetAlert custome by PK -->
    <script src="../sweetAlert2Custome.js"></script>
    <script>
        let php_empcode = '<?=$explodeValue[0];?>';
        let php_shift = '<?=$explodeValue[1];?>';
        let php_line = '<?=$explodeValue[2];?>';
        let php_mc = '<?=$explodeValue[3];?>';
        let php_docdid = '<?=$explodeValue[4];?>';
        let php_dochid = '<?=$explodeValue[5];?>';
        let php_dept = '<?=$explodeValue[6];?>';
        let php_empname = '<?=$explodeValue[7];?>';
        let php_docrevision = '<?=$explodeValue[8];?>';
        // console.log(php_empcode)
        // console.log(php_shift)
        // console.log(php_line)
        // console.log(php_mc)
        // console.log(php_docdid)
        // console.log(php_dochid)
    </script>
</body>
</html>