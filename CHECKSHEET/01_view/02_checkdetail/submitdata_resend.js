/**
 * TODO : Fn ที่ทำการเรียก ajax เพื่อบันทึกแต่ละข้อ
 * * ทำงานต่อจาก saveResult()
 * * เข้ามาทำงานทั้ง case OK , case NG
 */
submitLNNO_resend = (_num , _choicenum , _choiceall , _useranswer) => {
    /**
     * * if = ตรวจสอบว่าถ้าได้เลข 0 แสดงว่ามาจากการกด save change NG-modal
     */
    if(_num == 0){
        $('#exampleModal').modal('toggle')
        let remark = $('#ng-reason-'+_choicenum).val()
        //$('#result-'+_choicenum).html('<h5>* คำตอบจากผู้ใช้งาน : NG </h5>')
        form_data.append("remark", remark)
    }
    fillResult_answer(_choicenum,_useranswer)

    // console.log(_choicenum)
    // console.log(_useranswer)
    // console.log('submitLNNO_resend')
    $.ajax({
        url : '../../02_model/02_checkdetail/insert_lnno_resend.php',
        type : 'POST',
        data : form_data,
        contentType : false, 
        processData: false,
        dataType : 'json',
        success(response){
            // console.log('complete')
            // console.log(response)
            // console.log(Array.from(form_data.entries()))
            Swal.fire(
                'OK! บันทึกซ้ำเรียบร้อย',
                '',
                'success'
            )
            
            form_data.delete("dochid")
            form_data.delete("docdid")
            form_data.delete("empcode")
            form_data.delete("shift")
            form_data.delete("line")
            form_data.delete("mc")
            form_data.delete("revision")
            form_data.delete("answer")
            form_data.delete("lnno")
            form_data.delete("result")
            form_data.delete("remark")
            //* checkpicture เพิ่มมาบอกสถานะว่ามีภาพไหม 0 = no , 1 = yes (NG)
            form_data.delete("checkpicture")
            form_data.delete('files[]');

            //* ถ้าข้อปัจจุบันยังไม่เท่ากับข้อทั้งหมดก็เข้า if
            if(_num == 0){
                // console.log('0yes')
                if(_choicenum != _choiceall) {
                    nextOrprevious(_choicenum,_choiceall,'next')
                } else {
                    // let choiceall = parseInt(_choiceall)
                    // submitChecking(choiceall)
                    // submitEnding()
                    // alert("ข้อสุดท้ายละ")
                    // console.log('ข้อสุดท้ายละ')
                    vsr(_choiceall)
                }
            } 
        },
        errorr(response){
            alert("การเพิ่มข้อมูลในระบบเกิดปัญหากรุณาลองใหม่อีกครั้ง / ถ้าไม่ได้กรุณาติดต่อ Administator")
        }
    });
}
