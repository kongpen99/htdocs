/**
 * TODO : FN สำหรับลบรายการที่อยู่ในตาราง DOC_TEMP
 * * กรณีที่ user กดมาว่าต้องการตรวจใหม่เลย
 */
Delete_temp_data = (php_docdid,php_empcode,php_line,php_mc,php_shift) => {
    $.ajax({
        url:'../../02_model/02_checkdetail/del_tempdata.php',
        method:'POST',
        async:true,
        //dataType:'JSON',
        data:{
          DOCD_DID:php_docdid,
          EMPID:php_empcode,
          LINE:php_line,
          MC:php_mc,
          SHIFT:php_shift,
        },
        beforeSend(){
        
        },
        async success(response){
            console.log(response)
            Swal.fire(
                'ลบข้อมูลเรียบร้อยแล้ว',
                'กรุณารอสักครู่ระบบกำลังเริ่มต้นใหม่',
                'success'
            )
            setTimeout(() => {
                location.reload()
            }, 1000);
        }
    })

}