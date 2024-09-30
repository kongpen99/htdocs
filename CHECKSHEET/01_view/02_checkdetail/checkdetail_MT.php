<?php
$revresult = $_GET['result'];
// print($revresult);
$explodeValue = explode(",",$revresult);
// print_r($explodeValue);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="../../../artworks/web_menu_CHECK-SHEET.svg">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>check detail</title>
    <link rel="stylesheet" href="../../../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../node_modules/datatables.net-bs5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="../../../node_modules/sweetalert2/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="../../customized/custome.css">
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
    <form id="form-checksheet" method="post">
        <input type="hidden" value="<?php print($explodeValue[0]);?>" name="php_empcode" id="php_empcode">
        <input type="hidden" value="<?php print($explodeValue[1]);?>" name="php_shift" id="php_shift">
        <input type="hidden" value="<?php print($explodeValue[2]);?>" name="php_line" id="php_line">
        <input type="hidden" value="<?php print($explodeValue[3]);?>" name="php_mc" id="php_mc">
        <input type="hidden" value="<?php print($explodeValue[4]);?>" name="php_docdid" id="php_docdid">
        <input type="hidden" value="<?php print($explodeValue[5]);?>" name="php_dochid" id="php_dochid">
        <input type="hidden" value="<?php print($explodeValue[6]);?>" name="php_dept" id="php_dept">
        <input type="hidden" value="<?php print($explodeValue[7]);?>" name="php_empname" id="php_empname">
        <input type="hidden" value="<?php print($explodeValue[8]);?>" name="php_docrevision" id="php_docrevision">

    <div class="container"></div>

    <div class="d-flex justify-content-center">
        <div class="card mt-3" id="card-summary-choice" style="width:90%">
            <div class="card-header">Summary</div>
            <div class="card-body" id="card-summary-choice-body"></div>
        </div>
    </div>

    </form>

    <!-- //* Modal NG -->
    <div class="custome-modal"></div>

    <div class="modal  modal-xl fade" id="exampleModal" tabindex="-1"
		role="dialog" aria-labelledby="exampleModalLabel"
		aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<!-- Modal heading -->
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">
						x
					</h5>
					<button type="button" class="close"
						data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">
							×
						</span>
					</button>
				</div>
				<!-- Modal body with image -->
				<div class="modal-body" id="modal-body-img">
					<img src="image/nature.jpg" />
				</div>
			</div>
		</div>
	</div>

    <script src="../../../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../../../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../../node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../../../node_modules/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
    <script src="../../../node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <script src="checkdetail_MT.js"></script>
    <!-- //* del_tempdata.js จะเก็บคำสั่งของการลบข้อมูลใน Temp Table -->
    <!-- <script src="del_tempdata.js"></script> -->
    <!-- //* submitdata.js เก็บ fn saveResult() , submitLNNO() คือคำสั่งการบันทึกแต่ละข้อลงไป Temp Table -->
    <script src="submitdata_MT.js"></script>
    <!-- //* callNG.js เก็บ fn CallNG_modal() คือเรียก Modal เวลาที่ user input NG Value -->
    <!-- <script src="callNG.js"></script> -->
    <!-- //* fn ส่งข้อมูลซ้ำอีกครั้ง -->
    <!-- <script src="submitdata_resend.js"></script> -->
    <!-- //* เก็บ fn ส่งข้อมูลเข้าตารางจริง -->
    <!-- <script src="submitdata_actual.js"></script> -->
    <!-- //* sweetAlert custome by PK -->
    <script src="../sweetAlert2Custome.js"></script>
    <!-- //* fn แสดงผลสรุปรวมข้อมูลที่ตรวจสอบไปก่อนส่ง -->    
    <!-- <script src="view_summary_result.js"></script> -->
    <script src="../../../node_modules/moment/min/moment.min.js"></script>

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