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
 saveResult = (_choicenum , _useranswer , _realanswer , _typequestion , _choiceall) => {
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
    
    /**
     * * condition
     * * หาว่าข้อนี้เคยเพิ่มไปใน array หรือยังถ้ายังก็เข้า if
     * * ถ้าเคยมีอยู่แล้วจะเข้า else
     */
    let checkAlreadychoice = arrsaveChoice.indexOf(parseInt(_choicenum))
    if(checkAlreadychoice == -1){

        //* A คือ OK/NG
        if(_typequestion == 'A'){
            $('#label-'+_choicenum).html(' <b>(ทำแล้ว)</b>')

            let useranswer = _useranswer
            let realanswer = _realanswer

            /**
             * * if = OK
             * * else = NG 
             */
            if(realanswer == useranswer){
                form_data.append("dochid", php_dochid)
                form_data.append("docdid", php_docdid)
                form_data.append("empcode", php_empcode)
                form_data.append("shift", php_shift)
                form_data.append("line", php_line)
                form_data.append("mc", php_mc)
                form_data.append("revision", php_docrevision)
                form_data.append("answer", useranswer)
                form_data.append("lnno", _choicenum)
                form_data.append("result", 'Correct')
                form_data.append("remark", null)
                //* checkpicture เพิ่มมาบอกสถานะว่ามีภาพไหม 0 = no , 1 = yes
                form_data.append("checkpicture", 0)
                // console.log(Array.from(form_data.entries()))
                submitLNNO(1,_choicenum,null,'OK')

                //* ถ้าข้อปัจจุบันยังไม่เท่ากับข้อทั้งหมดก็เข้า if
                if(_choicenum != _choiceall) {
                    nextOrprevious(_choicenum,_choiceall,'next')
                } else {
                    submitEnding()
                }
            } else {
                form_data.append("dochid", php_dochid)
                form_data.append("docdid", php_docdid)
                form_data.append("empcode", php_empcode)
                form_data.append("shift", php_shift)
                form_data.append("line", php_line)
                form_data.append("mc", php_mc)
                form_data.append("revision", php_docrevision)
                form_data.append("answer", useranswer)
                form_data.append("lnno", _choicenum)
                form_data.append("result", 'Incorrect')
                //form_data.append("remark", null)
                //* checkpicture เพิ่มมาบอกสถานะว่ามีภาพไหม 0 = no , 1 = yes
                //* บางทีมัน NG นะแต่ user อาจจะไม่อยากเพิ่มรูปมา
                //* ให้ตั้งต้นเป็น 0 ก่อน
                form_data.append("checkpicture", 0)
                // console.log(Array.from(form_data.entries()))
                CallNG_modal(_choicenum,_choiceall,'NG')
            }
        }
        //* B คือ Between
        else if(_typequestion == 'B'){
            $('#label-'+_choicenum).html(' <b>(ทำแล้ว)</b>')

            /**
             * * ตรวจสอบก่อนว่า input ของข้อนั้น ๆ ที่กดปุ่มมาเป็นค่าว่างไหม
             * * if = ไม่เป็นค่าว่าง
             * * else = เป็นค่าว่าง
             */
            if($('#inp-between-'+_choicenum).val() != ''){
                //* สร้างตัวแปรมาเก็บค่าจาก user
                let useranswer = Number($('#inp-between-'+_choicenum).val())
                //* สร้างตัวแปรมาแยกค่าของ between ที่ขั้นด้วย , 
                let split_realanswer = _realanswer.split(',')
                /**
                 * TODO : เงื่อนไขตรวจสอบว่าที่ระบุมา มากกว่าหรือเท่ากับ [0] ไหม
                 * TODO : เงื่อนไขตรวจสอบว่าที่ระบุมา น้อยกว่าหรือเท่ากับ [1] ไหม
                 * * ถ้าใช่ก็ให้เข้า if (OK)
                 * * ถ้าไม่ก็เข้า else (NG)
                 */

                // console.log(useranswer)
                // console.log(Number(split_realanswer[1]))
                // console.log(Number(split_realanswer[0]))
                if((useranswer >= Number(split_realanswer[0])) && (useranswer <= Number(split_realanswer[1]))){
                    form_data.append("dochid", php_dochid)
                    form_data.append("docdid", php_docdid)
                    form_data.append("empcode", php_empcode)
                    form_data.append("shift", php_shift)
                    form_data.append("line", php_line)
                    form_data.append("mc", php_mc)
                    form_data.append("revision", php_docrevision)
                    form_data.append("answer", useranswer)
                    form_data.append("lnno", _choicenum)
                    form_data.append("result", 'Correct')
                    form_data.append("remark", null)
                    //* checkpicture เพิ่มมาบอกสถานะว่ามีภาพไหม 0 = no , 1 = yes
                    form_data.append("checkpicture", 0)
                    // console.log(Array.from(form_data.entries()))
                    submitLNNO(1,_choicenum,null,useranswer)
    
                    //* ถ้าข้อปัจจุบันยังไม่เท่ากับข้อทั้งหมดก็เข้า if
                    if(_choicenum != _choiceall) {
                        nextOrprevious(_choicenum,_choiceall,'next')
                    } else {
                        submitEnding()
                    }                    
                } else {
                    form_data.append("dochid", php_dochid)
                    form_data.append("docdid", php_docdid)
                    form_data.append("empcode", php_empcode)
                    form_data.append("shift", php_shift)
                    form_data.append("line", php_line)
                    form_data.append("mc", php_mc)
                    form_data.append("revision", php_docrevision)
                    form_data.append("answer", useranswer)
                    form_data.append("lnno", _choicenum)
                    form_data.append("result", 'Incorrect')
                    //form_data.append("remark", null)
                    //* checkpicture เพิ่มมาบอกสถานะว่ามีภาพไหม 0 = no , 1 = yes
                    //* บางทีมัน NG นะแต่ user อาจจะไม่อยากเพิ่มรูปมา
                    //* ให้ตั้งต้นเป็น 0 ก่อน
                    form_data.append("checkpicture", 0)
                    CallNG_modal(_choicenum,_choiceall,useranswer)

                }
            } else {
                answerIncorrect('กรุณาระบุคำตอบของท่าน' , '')
            }
        }
        //* C คือ = (equal)
        else if(_typequestion == 'C'){
            $('#label-'+_choicenum).html(' <b>(ทำแล้ว)</b>')
            if($('#inp-equal-'+_choicenum).val() != ''){
                let useranswer = $('#inp-equal-'+_choicenum).val()
                if(useranswer == _realanswer){
                    form_data.append("dochid", php_dochid)
                    form_data.append("docdid", php_docdid)
                    form_data.append("empcode", php_empcode)
                    form_data.append("shift", php_shift)
                    form_data.append("line", php_line)
                    form_data.append("mc", php_mc)
                    form_data.append("revision", php_docrevision)
                    form_data.append("answer", useranswer)
                    form_data.append("lnno", _choicenum)
                    form_data.append("result", 'Correct')
                    form_data.append("remark", null)
                    //* checkpicture เพิ่มมาบอกสถานะว่ามีภาพไหม 0 = no , 1 = yes
                    form_data.append("checkpicture", 0)
                    // console.log(Array.from(form_data.entries()))
                    submitLNNO(1,_choicenum,null,useranswer)
                    if(_choicenum != _choiceall) {
                        nextOrprevious(_choicenum,_choiceall,'next')
                    } else {
                        submitEnding()
                    }        
                } else {
                    form_data.append("dochid", php_dochid)
                    form_data.append("docdid", php_docdid)
                    form_data.append("empcode", php_empcode)
                    form_data.append("shift", php_shift)
                    form_data.append("line", php_line)
                    form_data.append("mc", php_mc)
                    form_data.append("revisi    on", php_docrevision)
                    form_data.append("answer", useranswer)
                    form_data.append("lnno", _choicenum)
                    form_data.append("result", 'Incorrect')
                    //* checkpicture เพิ่มมาบอกสถานะว่ามีภาพไหม 0 = no , 1 = yes
                    //* บางทีมัน NG นะแต่ user อาจจะไม่อยากเพิ่มรูปมา
                    //* ให้ตั้งต้นเป็น 0 ก่อน
                    form_data.append("checkpicture", 0)
                    CallNG_modal(_choicenum,_choiceall,useranswer)
                }
            } else {
                answerIncorrect('กรุณาระบุคำตอบของท่าน' , '')
            }
        }
    } 
    //TODO : เข้า else กรณีที่กดบันทึกซ้ำมา
    else {
        Swal.fire({
            title: 'ต้องการบันทึกซ้ำ ?',
            text: "คุณต้องการบันทึกซ้ำคำตอบข้อนี้ใช่หรือไม่ ?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่ ต้องการบันทึกซ้ำ',
            cancelButtonText:'ไม่'
        }).then((result) => {
            console.log(result)
            if (result.isConfirmed) {
                // console.log(_typequestion)
                //* A คือ OK/NG
                if(_typequestion == 'A'){
                    $('#label-'+_choicenum).html(' <b>(บันทึกผลซ้ำ)</b>')

                    let useranswer = _useranswer
                    let realanswer = _realanswer

                    /**
                     * * if = OK
                     * * else = NG 
                     */
                    if(realanswer == useranswer){
                        form_data.append("dochid", php_dochid)
                        form_data.append("docdid", php_docdid)
                        form_data.append("empcode", php_empcode)
                        form_data.append("shift", php_shift)
                        form_data.append("line", php_line)
                        form_data.append("mc", php_mc)
                        form_data.append("revision", php_docrevision)
                        form_data.append("answer", useranswer)
                        form_data.append("lnno", _choicenum)
                        form_data.append("result", 'Correct')
                        form_data.append("remark", null)
                        //* checkpicture เพิ่มมาบอกสถานะว่ามีภาพไหม 0 = no , 1 = yes
                        form_data.append("checkpicture", 0)
                        // console.log(Array.from(form_data.entries()))
                        submitLNNO_resend(1,_choicenum,null,'OK')
        
                        //* ถ้าข้อปัจจุบันยังไม่เท่ากับข้อทั้งหมดก็เข้า if
                        if(_choicenum != _choiceall) {
                            nextOrprevious(_choicenum,_choiceall,'next')
                        } else {
                            submitEnding()
                        }
                    } else {
                        form_data.append("dochid", php_dochid)
                        form_data.append("docdid", php_docdid)
                        form_data.append("empcode", php_empcode)
                        form_data.append("shift", php_shift)
                        form_data.append("line", php_line)
                        form_data.append("mc", php_mc)
                        form_data.append("revision", php_docrevision)
                        form_data.append("answer", useranswer)
                        form_data.append("lnno", _choicenum)
                        form_data.append("result", 'Incorrect')
                        //form_data.append("remark", null)
                        //* checkpicture เพิ่มมาบอกสถานะว่ามีภาพไหม 0 = no , 1 = yes
                        //* บางทีมัน NG นะแต่ user อาจจะไม่อยากเพิ่มรูปมา
                        //* ให้ตั้งต้นเป็น 0 ก่อน
                        form_data.append("checkpicture", 0)
                        //console.log(Array.from(form_data.entries()))
                        CallNG_modal_resend(_choicenum,_choiceall,'NG')
                    }
                }
                //* B คือ Between
                else if(_typequestion == 'B'){
                    $('#label-'+_choicenum).html(' <b>(บันทึกผลซ้ำ)</b>')

                    /**
                     * * ตรวจสอบก่อนว่า input ของข้อนั้น ๆ ที่กดปุ่มมาเป็นค่าว่างไหม
                     * * if = ไม่เป็นค่าว่าง
                     * * else = เป็นค่าว่าง
                     */
                    if($('#inp-between-'+_choicenum).val() != ''){
                        //* สร้างตัวแปรมาเก็บค่าจาก user
                        let useranswer = Number($('#inp-between-'+_choicenum).val())
                        //* สร้างตัวแปรมาแยกค่าของ between ที่ขั้นด้วย , 
                        let split_realanswer = _realanswer.split(',')
                        /**
                         * TODO : เงื่อนไขตรวจสอบว่าที่ระบุมา มากกว่าหรือเท่ากับ [0] ไหม
                         * TODO : เงื่อนไขตรวจสอบว่าที่ระบุมา น้อยกว่าหรือเท่ากับ [1] ไหม
                         * * ถ้าใช่ก็ให้เข้า if (OK)
                         * * ถ้าไม่ก็เข้า else (NG)
                         */
                        if((useranswer >= Number(split_realanswer[0])) && (useranswer <= Number(split_realanswer[1]))){
                            form_data.append("dochid", php_dochid)
                            form_data.append("docdid", php_docdid)
                            form_data.append("empcode", php_empcode)
                            form_data.append("shift", php_shift)
                            form_data.append("line", php_line)
                            form_data.append("mc", php_mc)
                            form_data.append("revision", php_docrevision)
                            form_data.append("answer", useranswer)
                            form_data.append("lnno", _choicenum)
                            form_data.append("result", 'Correct')
                            form_data.append("remark", null)
                            //* checkpicture เพิ่มมาบอกสถานะว่ามีภาพไหม 0 = no , 1 = yes
                            form_data.append("checkpicture", 0)
                            // console.log(Array.from(form_data.entries()))
                            submitLNNO_resend(1,_choicenum,null,useranswer)
            
                            //* ถ้าข้อปัจจุบันยังไม่เท่ากับข้อทั้งหมดก็เข้า if
                            if(_choicenum != _choiceall) {
                                nextOrprevious(_choicenum,_choiceall,'next')
                            } else {
                                submitEnding()
                            }                    
                        } else {
                            form_data.append("dochid", php_dochid)
                            form_data.append("docdid", php_docdid)
                            form_data.append("empcode", php_empcode)
                            form_data.append("shift", php_shift)
                            form_data.append("line", php_line)
                            form_data.append("mc", php_mc)
                            form_data.append("revision", php_docrevision)
                            form_data.append("answer", useranswer)
                            form_data.append("lnno", _choicenum)
                            form_data.append("result", 'Incorrect')
                            //form_data.append("remark", null)
                            //* checkpicture เพิ่มมาบอกสถานะว่ามีภาพไหม 0 = no , 1 = yes
                            //* บางทีมัน NG นะแต่ user อาจจะไม่อยากเพิ่มรูปมา
                            //* ให้ตั้งต้นเป็น 0 ก่อน
                            form_data.append("checkpicture", 0)
                            CallNG_modal_resend(_choicenum,_choiceall,useranswer)
                        }
                    } else {
                        answerIncorrect('กรุณาระบุคำตอบของท่าน' , '')
                    }
                }
                //* C คือ = (equal)
                else if(_typequestion == 'C'){
                    $('#label-'+_choicenum).html(' <b>(บันทึกผลซ้ำ)</b>')
                    if($('#inp-equal-'+_choicenum).val() != ''){
                        let useranswer = $('#inp-equal-'+_choicenum).val()
                        if(useranswer == _realanswer){
                            form_data.append("dochid", php_dochid)
                            form_data.append("docdid", php_docdid)
                            form_data.append("empcode", php_empcode)
                            form_data.append("shift", php_shift)
                            form_data.append("line", php_line)
                            form_data.append("mc", php_mc)
                            form_data.append("revision", php_docrevision)
                            form_data.append("answer", useranswer)
                            form_data.append("lnno", _choicenum)
                            form_data.append("result", 'Correct')
                            form_data.append("remark", null)
                            //* checkpicture เพิ่มมาบอกสถานะว่ามีภาพไหม 0 = no , 1 = yes
                            form_data.append("checkpicture", 0)
                            // console.log(Array.from(form_data.entries()))
                            submitLNNO_resend(1,_choicenum,null,useranswer)
                            if(_choicenum != _choiceall) {
                                nextOrprevious(_choicenum,_choiceall,'next')
                            } else {
                                submitEnding()
                            }        
                        } else {
                            form_data.append("dochid", php_dochid)
                            form_data.append("docdid", php_docdid)
                            form_data.append("empcode", php_empcode)
                            form_data.append("shift", php_shift)
                            form_data.append("line", php_line)
                            form_data.append("mc", php_mc)
                            form_data.append("revision", php_docrevision)
                            form_data.append("answer", useranswer)
                            form_data.append("lnno", _choicenum)
                            form_data.append("result", 'Incorrect')
                            //* checkpicture เพิ่มมาบอกสถานะว่ามีภาพไหม 0 = no , 1 = yes
                            //* บางทีมัน NG นะแต่ user อาจจะไม่อยากเพิ่มรูปมา
                            //* ให้ตั้งต้นเป็น 0 ก่อน
                            form_data.append("checkpicture", 0)
                            CallNG_modal_resend(_choicenum,_choiceall,useranswer)
                        }
                    } else {
                        //* กรณีที่ user ไม่ได้ระบุคำตอบมา
                        answerIncorrect('กรุณาระบุคำตอบของท่าน' , '')
                    }
                }
            } else {
                Swal.fire(
                    'OK! ยกเลิก',
                    '',
                    'success'
                )
            }
        })  
    }
}

/**
 * TODO : Fn submitLNNO() ที่ทำการเรียก ajax เพื่อบันทึกแต่ละข้อ
 * * ทำงานต่อจาก saveResult()
 * * เข้ามาทำงานทั้ง case OK , case NG
 */
submitLNNO = (_num , _choicenum , _choiceall , _useranswer) => {
    arrsaveChoice.push(parseInt(_choicenum))
    /**
     * * if = ตรวจสอบว่าถ้าได้เลข 0 แสดงว่ามาจากการกด save change NG-modal
     */
    if(_num == 0){
        $('#exampleModal').modal('toggle')
        let remark = $('#ng-reason-'+_choicenum).val()
        form_data.append("remark", remark)
    }
    fillResult_answer(_choicenum,_useranswer)

    $.ajax({
        url : '../../02_model/02_checkdetail/insert_lnno.php',
        type : 'POST',
        data : form_data,
        contentType : false, 
        processData: false,
        dataType : 'json',
        success(response){
            // console.log('complete')
            // console.log(response)
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
                if(_choicenum != _choiceall) {
                    nextOrprevious(_choicenum,_choiceall,'next')
                } else {
                    submitEnding()
                }
            }
        },
        errorr(response){
            alert("การเพิ่มข้อมูลในระบบเกิดปัญหากรุณาลองใหม่อีกครั้ง / ถ้าไม่ได้กรุณาติดต่อ Administator")
        }
    });
}

/**
 * TODO : FN สำหรับการนำคำตอบของผู้ใช้งานไปใส่ใน Label ที่เราสร้างไว้เปล่าๆ
 * * จะทำงานตอนนี้ผู้ใช้งานกดปุ่ม OK/NG หรือพิมพ์ใส่คำตอบต่าง ๆ 
 */
fillResult_answer = (_choicenum,_useranswer) => {
    $('#result-'+_choicenum).html('<h5>* คำตอบจากผู้ใช้งาน : '+_useranswer+' </h5>')
}


