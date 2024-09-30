<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="icon" href="/artworks/favicon.jpg">
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>check sheet</title>
  <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../node_modules/datatables.net-bs5/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="../node_modules/sweetalert2/dist/sweetalert2.min.css">
  <link rel="stylesheet" href="customized/jquery-ui-1.12.1.custom/jquery-ui.min.css">
  <link rel="stylesheet" href="customized/jquery-ui-1.12.1.custom/jquery-ui.theme.min.css">
  <style>
  </style>
</head>
<body class="bg-dark" id="element">
  <div class="container">
  <?php include '01_view/01_check/check.php'; ?>     
  </div>
  <!-- //TODO : end container -->

  
  <script src="../node_modules/jquery/dist/jquery.min.js"></script>
  <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="../node_modules/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
  <script src="../node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
  <script src="customized/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
  <script src="01_view/01_check/check.js"></script>
  <script>


function GoInFullscreen(element) {
	console.log(element)
	if(element.requestFullscreen)
		element.requestFullscreen();
	else if(element.mozRequestFullScreen)
		element.mozRequestFullScreen();
	else if(element.webkitRequestFullscreen)
		element.webkitRequestFullscreen();
	else if(element.msRequestFullscreen)
		element.msRequestFullscreen();
}


    let rev_result_arr = []
    let prepare_result_arr = [] //* array ที่เอาไว้เก็บค่าที่ต้องการจะส่งไปยังหน้า check detail
    let dept,empname,docrevision

    $(() => {
      // for(var i=0;i<5;i++){
      //   GoInFullscreen($("#element").get(0));

      // }

    })


    $(document).on('keypress',function(e) {
      if(e.which == 13) {
        if(e.target.id == 'empid') {
          empcheck()
        }  
      }
    });

    $(async () => {
        await $('#row-doc').hide()
        await $('#row-fillcheck').hide()
        await $('#row-sum').hide()
        await $('#row-mc-type').hide()

        await $('#btn-row-login').on('click',() => {
          empcheck()
        })
    })

    empcheck = () => {
      $.ajax({
          url:'02_model/01_check/empcheck.php',
          method:'POST',
          async:true,
          dataType:'JSON',
          data:{
            empid:$('#empid').val()
          },
          beforeSend(){
            
          },
          success(response){
            // console.log(response)
            if(response.std == true) {
              getdoc(response.result[0].USERS_ZONE)
              rev_result_arr.push($('#empid').val())
              dept = response.result[0].USERS_DEPT
              empname = response.result[0].USERS_EMPNAME
            } else {
              // alert('Error : ไม่มีรหัสนี้ในระบบ ?')
              Swal.fire(
                'ไม่มีรหัสพนักงานนี้ในระบบ',
                '',
                'error'
              )      
              $('#empid').val('')
            }
          },
          error(){
            //alert('Error : โหลดหน้านี้ใหม่')
            Swal.fire(
                'โหลดหน้านี้ใหม่',
                '',
                'error'
            )      
          }
      })
    }

    /**
     * TODO : กลับไปหน้าใส่รหัสพนักงาน
     */
    $('#btn-row-login-back').on('click',() => {
      $('#row-doc').fadeOut("fast", () => {
        $('#row-login').fadeIn("fast",() => {
          //* destroy old datatables
          $('#tb-document').DataTable().destroy() //* สั่ง destroy
          rev_result_arr.pop()
          //console.log(rev_result_arr)

        })
      })
    })

    /**
     * TODO : 1.อยู่หน้า ระบุข้อมูลการตรวจสอบเพิ่มเติม 2.กลับไปหน้า เลือกเอกสารตรวจสอบ
     */
    $('#btn-row-doc-back').on('click', () => {
      $('#row-mc-type').hide()
      $('#row-fillcheck').fadeOut("fast", () => {
        $('#row-doc').fadeIn("fast", ()=> {
          rev_result_arr.pop()
          //console.log(rev_result_arr)

        })
      })
    })

    /**
     * TODO : 1.อยู่หน้า สรุปรายละเอียดก่อนตรวจเช็ค 2.กลับไปหน้า ระบุข้อมูลการตรวจสอบเพิ่มเติม
     */
    $('#btn-row-sum-back').on('click',() => {
      $('#row-sum').fadeOut("fast", () => {
        $('#row-fillcheck').fadeIn("fast",() => {
          rev_result_arr.pop()
          rev_result_arr.pop()
          rev_result_arr.pop()
          rev_result_arr.pop()
          rev_result_arr.pop()
          //* Reset variable array
          while(prepare_result_arr.length > 0) {
            prepare_result_arr.pop();
          }
        })
      })
    })
  </script>
</body>
</html>