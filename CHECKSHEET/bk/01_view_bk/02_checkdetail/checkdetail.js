/**
 * TODO : อ่านรายละเอียดของหน้านี้
 * * - 1.ฟังก์ชั่นที่เข้ามาทำงานอันดับ 1 : getdocDetail()
 * * - อธิบายเพิ่มเติมของ getdocDetail()
 * *    =>  จะเป็น fn() ที่ไปหาข้อตรวจสอบมาแสดงผล
 * *    =>  แต่จะไปเช็คด้วยว่าข้อมูลที่ user ท่านนี้เรียกมามีอันที่เคยทำแล้วไม่จบไหม
 * *    =>  ถ้ามีก็จะขึ้น dialog ถามว่ามีค้างนะ จะ resume ไหม
 * *    =>  ถ้ากด OK ทำต่อจากเดิมก็จะพาไปที่ข้อถัดไปจากของก่อนหน้า
 * *    =>  ถ้ากด "ไม่ ต้องการตรวจใหม่" ก็จะลบข้อมูลทั้งหมดก่อนหน้าและเรื่มใหม่
 * * - 2.เมื่อกดปุ่มตอบผลลัพธ์ saveResult()
 * *    => จะเข้าไปเพื่อเตรียมคำตอบและแยกว่าเป็นการ input แบบไหน
 * *    => OK/NG , Between value , = 
 * *    => จากนั้นก็จะไปเรียกใช้ fn : submitLNNO() 
 * * - 3. : submitLNNO()
 * *    => คือ fn บันทึกผลของแต่ละข้อเข้าไปใน TB:Temp ก่อน 
 * * - 4.nextOrprevious() 
 * *    => คือ fn สำหรับเริ่มข้อถัดไป , ถอยไปข้อก่อนหน้า
 */
$(() => {
    getdocDetail(php_docdid)
})

//let arrsaveResult = [] //* สร้างตัวแปรอเรย์มาเพื่อเอาไว้เก็บคำตอบจากผู้ใช้
let arrsaveChoice = [] //* เก็บเลขข้อ
let arrNGlastModified = [] //* เก็บ tempid ของ files เอาไว้อ้างอิงตอนลบออกจาก form data
let saveQtyChoice = 0 //* สร้างมาเก็บ length() ทั้งหมดของเอกสารที่ตรวจ
let form_data = new FormData()

/**
 * TODO Fn เริ่มต้น
 */
getdocDetail = (php_docdid) => {
    $.ajax({
        url:'../../02_model/01_check/getdocumentdetail_forcheck.php',
        method:'POST',
        async:true,
        dataType:'JSON',
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
            // console.log(response.result.length)
            let countchoices = response.result.length //* เก็บจำนวนข้อทั้งหมด
            let html = ''
            saveQtyChoice = countchoices
            response.result.map((index ,current) => {
                //* เอาไว้ใส่เลขข้อ
                current++; 
                html += "<div class=\"card bg-light mt-5\" id=\"card-question-"+current+"\">"
                html += "   <div class=\"card-header card-header-lightblue text-white h3\">"
                html +=         "ข้อที่ " + current + ' / ' + countchoices + ' ' + index['DOCD_QDESC'] + "<label id=\"label-"+index['DOCD_LNNO']+"\"></label>"
                html += "   </div>"
                html += "   <div class=\"card-body\">"
                html += "       <div class=\"row\">"
                html += "           <div class=\"col-4\">"
                if(index['DOCD_PICPATH'] != ''){
                // html += "               <img src=\"../../DailyCheckSheet/"+index['DOCD_PICPATH']+"\" class=\"card-img-top img-thumbnail\" alt=\"\">"
                html += "               <img src=\"../../"+index['DOCD_PICPATH']+"\" class=\"card-img-top img-thumbnail\" alt=\"\">"
                } else {
                html += "               <img src=\"../../No-Image-Placeholder.jpg\" class=\"card-img-top img-thumbnail\" alt=\"\">"
                }
                html += "           </div>"
                html += "           <div class=\"col-8\">"
                html +="                <table class=\"table table-bordered border-dark\">"
                html +="                    <tr>"
                html +="                        <th style=\"font-size:18px; width:35%; background-color:rgb(110 175 238);\"><label><b>1. รายละเอียดการตรวจสอบ</b></label></th>" 
                html +="                        <td style=\"font-size:18px;\"><label>"+index['DOCD_QDESC']+"</label></td>"
                html +="                    </tr>"
                html +="                    <tr>"
                html +="                        <th style=\"font-size:18px; width:30%; background-color:rgb(73 149 223);\"><label><b>2. รายละเอียดการตรวจสอบ</b></label></th>" 
                html +="                        <td style=\"font-size:18px;\"><label>"+index['DOCD_QDESC2']+"</label></td>"
                html +="                    </tr>"
                html +="                    <tr>"
                html +="                        <th style=\"font-size:18px; width:30%; background-color:rgb(60 141 220);\"><label><b>3. มาตราฐาน/ผลลัพธ์ที่คาดหวัง</b></label></th>" 
                html +="                        <td style=\"font-size:18px;\"><label>"+index['DOCD_QDESC3']+"</label></td>"
                html +="                    </tr>"
                html +="                </table>"

                // html += "               <label><b>รายละเอียดการตรวจสอบ</b></label>"
                // html += "               <br>"
                // html += "               <label>- "+index['DOCD_QDESC']+"</label>"
                // html += "               <br>"
                // html += "               <label><b>รายละเอียดการตรวจสอบ</b></label>"
                // html += "               <br>"
                // html += "               <label>- "+index['DOCD_QDESC2']+"</label>"
                // html += "               <br>"
                // html += "               <label><b>มาตราฐาน/ผลลัพธ์ที่คาดหวัง</b></label>"
                // html += "               <br>"
                // html += "               <label>- "+index['DOCD_QDESC3']+"</label>"
                // html += "               <hr>"
                // html += "               <label><b>ระบุคำตอบ</b></label>"
                html += "               <br>"

                /**
                 * TODO : Fn saveResult()
                 * * มีการส่งตัวแปรไปดังนี้
                 * * 1.LNNO = ลำดับของคำถาม
                 * * 2.ค่าที่ผู้ใช้กด/ป้อน
                 * * 3.คำตอบที่ถูกต้องของข้อนี้
                 * * 4.ประเภทของคำถาม
                 * *    4.1 A คือ OK/NG
                 * *    4.2 B คือ Between
                 * *    4.3 C คือ =
                 * * 5.จำนวนคำถามทั้งหมด
                 */
                //* ถ้าประเภทคำถามเป็น OK/NG
                if(index['DOCD_QTOOL'] == 'OK/NG') {
                    html += "<button type=\"button\" onclick=\"saveResult('"+index['DOCD_LNNO']+"','OK','"+index['DOCD_OKNG_VALUE']+"','A','"+countchoices+"','"+current+"')\" class=\"btn btn-lg btn-success w-100 p-3 m-1\">OK</button>"
                    html += "<button type=\"button\" onclick=\"saveResult('"+index['DOCD_LNNO']+"','NG','"+index['DOCD_OKNG_VALUE']+"','A','"+countchoices+"','"+current+"')\" class=\"btn btn-lg btn-danger w-100 p-3 m-1\">NG</button>"
                }
                //* ถ้าประเภทคำถามเป็นระหว่าง
                else if(index['DOCD_QTOOL'] == 'Between') {
                    let betweenVal = index['DOCD_LESS_VALUE']+','+index['DOCD_THAN_VALUE']
                    html += "<input type=\"number\" id=\"inp-between-"+index['DOCD_LNNO']+"\" class=\"form-control p-3\" placeholder=\"ระบุตัวเลขเท่านั้น\">"
                    html += "<div class=\"row\">"
                    html += "   <div class=\"col-12 d-flex justify-content-end\">"
                    html += "       <button type=\"button\" onclick=\"saveResult('"+index['DOCD_LNNO']+"','OK','"+betweenVal+"','B','"+countchoices+"','"+current+"')\" class=\"btn btn-lg btn-success w-25 p-3 m-2\">ส่งคำตอบ</button>"  
                    html += "   </div>" 
                    html += "</div>" 
                }
                //* ถ้าประเภทคำถามเป็น = 
                else if(index['DOCD_QTOOL'] == '=') {
                    let equal = index['DOCD_ANSWER']
                    html += "<input type=\"text\" id=\"inp-equal-"+index['DOCD_LNNO']+"\" class=\"form-control p-3\" placeholder=\"\">"
                    html += "<div class=\"row\">"
                    html += "   <div class=\"col-12 d-flex justify-content-end\">"
                    html += "       <button type=\"button\" onclick=\"saveResult('"+index['DOCD_LNNO']+"','OK','"+equal+"','C','"+countchoices+"','"+current+"')\" class=\"btn btn-lg btn-success w-25 p-3 m-2\">ส่งคำตอบ</button>"  
                    html += "   </div>"
                    html += "</div>"
                }

                /**
                 * TODO : 16-03-2023
                 * * Code สำหรับไว้แสดงคำตอบหลังจากที่กดตอบไปแล้ว
                 */
                html += "       <div class=\"row\">"
                html += "           <div class=\"col\">"
                html += "               <label id=\"result-"+index['DOCD_LNNO']+"\"></label>"
                html += "           </div>" //* End : col
                html += "       </div>"     //* End : row

                html += "           </div>" //* End : col-8
                html += "       </div>"     //* End : row
                
                html += "   </div>" //* End : card-body

                html += "   <div class=\"card-footer\">"
                html += "       <div class=\"d-flex flex-row-reverse\">"

                /**
                 * TODO : เงื่อนไขการกำหนดปุ่ม
                 * * if : ถ้าถึงข้อสุดท้ายจะแสดงผลปุ่ม submit แทนปุ่ม ถัดไป
                 */
                if(current == countchoices){
                html += "           <button type=\"button\" id=\"btn-submit\" onclick=\"submitEnding()\" class=\"btn btn-md btn-success m-1\">ส่งผลการตรวจสอบ</button>"
                } 
                else{
                html += "           <button type=\"button\" id=\"btn-next-"+current+"\" onclick=\"nextOrprevious('"+current+"','"+countchoices+"','next')\" class=\"btn btn-md btn-success m-1\">ถัดไป</button>"
                }
                html += "           <button type=\"button\" id=\"btn-previous-"+current+"\" onclick=\"nextOrprevious('"+current+"','"+countchoices+"','previous')\" class=\"btn btn-md btn-secondary m-1\">ก่อนหน้า</button>"
                html += "       </div>"
                html += "   </div>"

                html += "</div>"
            })
            $('.container').html(html)
            $('.card').hide()
            $('#card-question-1').show()
            //* disabled button previous ของข้อที่ 1
            $('#btn-previous-1').attr('disabled',true)
            //* disabled button next ของข้อสุดท้าย
            $('#btn-next-'+countchoices).attr('disabled',true)

            /**
             * TODO : 04-03-2023 เป็นเงื่อนไขตรวจสอบบอก user
             * * ว่าระบบไปตรวจสอบเจอข้อมูลของ doc , line , mc , shift , empcode 
             * * นะว่าเคยเช็คไว้แต่คงจะเกิด error หรือเผลอไปปิดหน้าเว็ปลง 
             * * มันเลยจะขึ้นถามว่าต้องการที่จะ resume check ไหม
             * * ถ้ากด YES = จะ next ไปที่ข้อต่อจากเดิม
             * * ถ้ากด NO = จะสั่ง SQL Delete in Temp TB , start first choice
             * 
             */
            if(response.stdtemp != false){
                Swal.fire({
                    title: 'ทำต่อจากของเดิม ?',
                    text: "มีข้อมูลที่เคยตรวจสอบก่อนหน้าต้องการจะทำต่อจากเดิมไหม",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'ไม่ ต้องการตรวจใหม่',
                    cancelButtonText:'ใช่ ทำต่อจากเดิม'
                }).then((result) => {
          
                    /**
                     * * if = delete เพื่อบันทึกใหม่หมด
                     * * else = resume to checking
                     */
                    if (result.isConfirmed) {
                        Delete_temp_data(php_docdid,php_empcode,php_line,php_mc,php_shift)
                    } else {

                        /**
                         * * เงื่อนไขเรียกข้อถัดไปจากข้อล่าสุดมาแสดงผล
                         * * let callLastChoice = response.resulttemp.slice(-1) คือ เอาตำแหน่ง array last
                         * * let parseInt_callLastChoice = parseInt(callLastChoice[0].DOC_LNNO) คือ แปลงเป็น integer
                         * * parseInt_callLastChoice++ คือ นำมา +1
                         */
                        let callLastChoice = response.resulttemp.slice(-1)
                        let parseInt_callLastChoice = parseInt(callLastChoice[0].DOC_LNNO)
                        let parseInt_callLastChoice_next = parseInt_callLastChoice + 1
                        // parseInt_callLastChoice++
                        console.log(parseInt_callLastChoice)
                        console.log(parseInt_callLastChoice_next)
                        $('.card').hide()
                        // $('#card-question-'+parseInt_callLastChoice).hide()

                        $('#card-question-'+parseInt_callLastChoice_next).show()

                        Swal.fire({
                            icon: 'success',
                            title: 'OK! เรียกคืนของเดิมให้แล้ว',
                            timer: 1000
                        })
                    }
                })                

                response.resulttemp.map((index , current) => {
                    // console.log(current)
                    // console.log(response.resulttemp.length)
                    $('#label-'+index['DOC_LNNO']).html(' <b>(ทำไปแล้ว)</b>')
                    // $('#result-'+index['DOC_LNNO']).html('<h5>* คำตอบก่อนหน้า : '+index['DOC_ANSWER']+'</h5>')
                    fillResult_answer(index['DOC_LNNO'],index['DOC_ANSWER'])

                    let convLNNO = parseInt(index['DOC_LNNO'])
                    arrsaveChoice.push(convLNNO)
                    /**
                     * TODO : add date 14-03-2023
                     * * ก่อนที่จะสั่งไปให้ยังข้อถัดไป
                     * * ตรวจสอบก่อนว่าไอ้ข้อล่าสุดที่ resume มาเป็นข้อสุดท้ายแล้วหรือยัง ?
                     * * ถ้าใช้ก็จะไม่เข้าไปทำงานใน if
                     */
                    // if(index['DOC_LNNO'] != countchoices){
                    //     await nextOrprevious(index['DOC_LNNO'],countchoices,'next')
                    // }
                })
            }
        }        
    })
}

/**
 * TODO : Fn สำหรับแสดงหน้าถัดไป หรือ ย้อนกลับมาก่อนหน้า
 * * โดยรับตัวแปรมา 3 ค่าดังนี้
 * * 1.หน้าปัจจุบัน
 * * 2.หน้าทั้งหมด
 * * 3.คีย์เวิด (next , previous)
 */
nextOrprevious = (_current,_numchoiceAll,_keyword) => {
    if(_keyword == 'next') {
        let nextchoice = parseInt(_current) + 1
        $('#card-question-'+_current).hide()
        $('#card-question-'+nextchoice).show()

        // $('#card-question-'+_current).fadeOut("fast", () => {
        //     // $('#card-question-'+nextchoice).fadeIn("slow")
        //     $('#card-question-'+nextchoice).show()
        // })

        Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 1000,
            timerProgressBar: true,
        }).fire({
            icon: 'success',
            title: 'ไปยังข้อถัดไป : ' +nextchoice
        })
    }
    else if(_keyword == 'previous'){
        let previous = parseInt (_current) - 1
        $('#card-question-'+_current).hide()
        $('#card-question-'+previous).show()

        // $('#card-question-'+_current).fadeOut("fast", () => {
        //     $('#card-question-'+previous).fadeIn("slow")
        // })

        Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 1000,
            timerProgressBar: true,
        }).fire({
            icon: 'success',
            title: 'กลับไปข้อก่อนหน้า : ' +previous
        })
    }
}