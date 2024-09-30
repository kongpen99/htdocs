/**
 * TODO : FN บันทึกผลการตรวจสอบเมื่อกดปุ่ม submit จากข้อสุดท้าย
 */
 submitEnding = () => {
    console.log(saveQtyChoice)
    console.log(arrsaveChoice.length)
    console.log(arrsaveChoice)
    /**
     * * 1.จะตรวจสอบก่อนว่า user ตอบคำถามมาทุกข้อหรือไม่
     * * 2.โดยนำ saveQtyChoice มา compare กับ arrsaveChoice.length() ว่ามีจำนวนเท่ากันไหม
     * * 3.ถ้าเท่ากับก็ให้เข้าไปใน if
     * * 4.ถ้าไม่เท่ากันก็ให้เข้า else และแสดงผลข้อความ ให้กับไปเพิ่มคำตอบให้ครบถ้วน
     */
    if(arrsaveChoice.length === saveQtyChoice) {
        Swal.fire({
            title: 'ยืนยันการส่ง ?',
            text: "ต้องการยืนยันคำตอบทั้งหมดใช่ไหม ?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่',
            cancelButtonText:'ไม่'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url:'../../02_model/02_checkdetail/insert_ending.php',
                    method:'POST',
                    async:true,
                    dataType:'JSON',
                    data:{
                        HID:php_dochid,
                        DID:php_docdid,
                        revision:php_docrevision,
                        shift:php_shift,
                        line:php_line,
                        mc:php_mc,
                        empcode:php_empcode,
                        empname:php_empname,
                        empdept:php_dept
                    },
                    beforeSend(){
                    },
                    async success(response){
                        // console.log(response)
                        if(response.status == true) {
                            Swal.fire(
                                'OK! บันทึกผลสำเร็จ',
                                'ระบบจะปิดหน้านี้ภายใน 3 วินาที',
                                'success'
                            )

                            setTimeout(function(){ 
                                window.top.close();
                            }, 3000);
                        } else {
                            Swal.fire(
                                'error! บันทึกผลไม่สำเร็จ',
                                '',
                                'error'
                            )                            
                        }
                    },
                    errorr(){
                        Swal.fire(
                            'error! พบปัญหากรุณาติดต่อผู้ดูแลระบบ',
                            '',
                            'error'
                        )    
                    }
                })   
            } else {
                Swal.fire(
                    'OK! ยกเลิก',
                    '',
                    'success'
                )
            }
        })
    } else {
        let textDetail = 'ข้อที่ตอบมาแล้ว' + arrsaveChoice
        answerIncorrect('มีบางข้อไม่ได้ระบุคำตอบ',textDetail)
    }
}