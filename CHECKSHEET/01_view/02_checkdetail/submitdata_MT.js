/**
 * TODO : Fn saveResult() รับคำตอบจากผู้ใช้งานและนำมาประมวลผล
 * * มีการส่งตัวแปรไปดังนี้
 * * 1.ลำดับของคำถาม
 * * 2.ค่าที่ผู้ใช้กด/ป้อน (เฉพาะแบบปุ่ม OK/NG)
 * * 3.คำตอบที่ถูกต้องของข้อนี้
 * * 4.ประเภทของคำถาม
 * *    4.1 A คือ OK/NG
 * *    4.2 B คือ Between
 * *    4.3 C คือ =
 * * 5.จำนวนคำถามทั้งหมด
 * 
 */
saveResult = (_choicenum , _useranswer , _realanswer , _typequestion , _choicecurrent) => {
    if(_useranswer == 'OK') {
        $('#group-'+_choicenum).removeClass('fg-choice')
        $('#group-'+_choicenum).removeClass('ng-choice')
        $('#group-'+_choicenum).addClass('fg-choice')
        $('#label-'+_choicenum).html("<div class=\"d-flex justify-content-center h5\">" + _choicecurrent + '<b> (OK)</b></div>')   
    } else {
        $('#group-'+_choicenum).removeClass('fg-choice')
        $('#group-'+_choicenum).removeClass('ng-choice')
        $('#group-'+_choicenum).addClass('ng-choice')
        $('#label-'+_choicenum).html("<div class=\"d-flex justify-content-center h5\">" + _choicecurrent + '<b> (NG)</b></div>')
    }
    $('#answer_'+_choicenum).val(_useranswer)
}


$("form#form-checksheet").on("submit" ,(e) => {
    e.preventDefault()
    var formData = $('#form-checksheet').serialize()

    var formData2 = $('#form-checksheet').serializeArray()
    console.log(formData2)

    //* array เก็บคำตอบจากผู้ใช้งาน
    let arr_answer = []
    //* array เก็บเลขข้อ
    let arr_lnno = []

    formData2.map((index) => {
        // console.log(index.name)
        if(index.name == "answer[]") {
            arr_answer.push(index.value)
        } else if(index.name == "lnno[]") {
            arr_lnno.push(index.value)
        }
    })

    console.log(arr_answer)
    console.log(arr_lnno)

    /**
     * TODO : ตรวจสอบว่า arr_answer นั้นมีค่าว่างไหม
     * * if = คือมีค่าว่าง
     * * else = ไม่มีค่าว่าง
     */
    let check_arr_answer = jQuery.inArray( "", arr_answer )
    if(check_arr_answer != -1) {
        console.log(check_arr_answer)
        Swal.fire(
            'กรุณาระบุคำตอบให้ครบทุกข้อ',
            '',
            'error'
        ) 
        arr_answer.map((arr_answer2,current) => {
            $('#group-'+arr_lnno[current]).removeClass('noti-choice')
            /**
             * * ตรวจหาว่าคือตำแหน่งของ array ตัวไหน
             * * ถ้าพบแล้วก็ให้ใส่ Class noti-choice เข้าไป
             */
            if(arr_answer2 == ''){
                // console.log(arr_lnno[current])
                $('#group-'+arr_lnno[current]).addClass('noti-choice')
            }
        })

    } else {
        let html_lnno = '' 
        arr_lnno.map((lnno,lnno_cur) => {
            html_lnno += "<tr>"
            html_lnno += "<td>"+lnno+"</td>"
            html_lnno += "<td colspan=\"2\">"+arrTextChoice[lnno_cur]+"</td>"
            html_lnno += "<td>"+arr_answer[lnno_cur]+"</td>"
            html_lnno += "</tr>"
        })
        $('#tbody-cscb').html(html_lnno)
        $('#card-summary-choice').show()
        $('.container').hide()
    }
 
})


btn_submit = () => {
    let formData = $('#form-checksheet').serialize()
    // console.log(formData)
    $.ajax({
        url : '../../02_model/02_checkdetail/submit_checksheet_MT.php',
        type : 'POST',
        data : formData,
        dataType : 'json',
        success(response){
            console.log(response)
            if(response.return_std == false) {
                // alert('ระบุคำตอบไม่ครบถ้วน')
                Swal.fire(
                    'กรุณาระบุคำตอบให้ครบทุกข้อ',
                    '',
                    'error'
                ) 

                response.check_answer.map((cha , cha_cur) => {
                    if(cha == 0) {
                        console.log('yes')
                        $('#group-'+response.lnno[cha_cur]).addClass('noti-choice')
                    } else {
                        $('#group-'+response.lnno[cha_cur]).removeClass('noti-choice')
                    }
                })
            } else {
                Swal.fire(
                    'บันทึกสำเร็จ ',
                    'รอ 3 วินาทีเพื่อปิดหน้านี้',
                    'success'
                ) 
                
                setTimeout(fnClosePage, 3000);
            }
            
        }
    })
}


fnClosePage = () => {
    window.close()
}

/**
 * TODO : FN สำหรับการนำคำตอบของผู้ใช้งานไปใส่ใน Label ที่เราสร้างไว้เปล่าๆ
 * * จะทำงานตอนนี้ผู้ใช้งานกดปุ่ม OK/NG หรือพิมพ์ใส่คำตอบต่าง ๆ 
 */
fillResult_answer = (_choicenum,_useranswer) => {
    $('#result-'+_choicenum).html('<h5>* คำตอบจากผู้ใช้งาน : '+_useranswer+' </h5>')
}


