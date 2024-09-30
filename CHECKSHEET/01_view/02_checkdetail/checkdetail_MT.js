/**
 * TODO : อ่านรายละเอียดของหน้านี้
 * * - 1.ฟังก์ชั่นที่เข้ามาทำงานอันดับ 1 : getdocDetail()
 * * - อธิบายเพิ่มเติมของ getdocDetail()
 * *    =>  จะเป็น fn() ที่ไปหาข้อตรวจสอบมาแสดงผล
 * *    =>  แต่จะไปเช็คด้วยว่าข้อมูลที่ user ท่านนี้เรียกมามีอันที่เคยทำแล้วไม่จบไหม
 * *    =>  ถ้ามีก็จะขึ้น dialog ถามว่ามีค้างนะ จะ resume ไหม
 * *    =>  ถ้ากด OK ทำต่อจากเดิมก็จะพาไปที่ข้อถัดไปจากของก่อนหน้า
 * *    =>  ถ้ากด "ไม่ ต้องการตรวจใหม่" ก็จะลบข้อมูลทั้งหมดก่อนหน้าและเรื่มใหม่
 */
$(() => {
    getdocDetail(php_docdid)
})

//let arrsaveResult = [] //* สร้างตัวแปรอเรย์มาเพื่อเอาไว้เก็บคำตอบจากผู้ใช้
//let arrsaveChoice = [] //* เก็บเลขข้อ
//let arrNGlastModified = [] //* เก็บ tempid ของ files เอาไว้อ้างอิงตอนลบออกจาก form data
//let saveQtyChoice = 0 //* สร้างมาเก็บ length() ทั้งหมดของเอกสารที่ตรวจ
//let form_data = new FormData()
let arrTextChoice = [] //* เก็บรายละเอียดของคำถาม

/**
 * TODO Fn เริ่มต้น
 */
getdocDetail = (php_docdid) => {
    $.ajax({
        url:'../../02_model/01_check/getdocumentdetail_forcheck_MT.php',
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
            let html 
            let countchoices = response.result.length //* เก็บจำนวนข้อทั้งหมด

            if(response.std == true) {
                html += "<div class=\"card\" id=\"card-show-choice\">"
                html += "<div class=\"card-body\">"
                // html += "<form action=\"#\" id=\"form-checksheet\" method=\"post\">"
                html += "<h4>รายการที่ต้องตรวจสอบ (มีทั้งหมด "+countchoices+" ข้อ) / " + php_line + " / " + php_mc + " / " + php_empname +"</h4>"
                html += "<table class=\"table body-tb table-bordered table-hover border border-2 border-dark w-100\">"
                html += "<thead>"
                html += "<tr class=\"header-td\">"
                html += "<th class=\"h4\" style=\"width:10%; text-align:center;\">ลำดับ</th>"
                html += "<th class=\"h4\" style=\"width:25%; text-align:center;\">ภาพอธิบาย</th>"
                html += "<th class=\"h4\" style=\"width:50%; text-align:center;\">คำถาม / คำอธิบาย</th>"
                html += "<th class=\"h4\" style=\"width:15%; text-align:center;\">คำตอบ</th>"
                html += "</tr>"
                html += "</thead>"
                html += "<tbody>"
                response.result.map((index , current) => {
                    arrTextChoice.push(index['DOCD_QDESC'] + ' <b>/</b> ' +index['DOCD_QDESC2'] + ' <b>/</b> ' +index['DOCD_QDESC3'])
                    let order = current + 1
                    html += "<tr id=\"group-"+index['DOCD_LNNO']+"\">"
                    html += "<td id=\"label-"+index['DOCD_LNNO']+"\" style=\"width:10%;\" class=\"align-middle\"><div class=\"d-flex justify-content-center h3\">"+order+"</div></td>"
                    html += "<td>"

                    if(index['DOCD_PICPATH'] != ''){
                        let split_img = index['DOCD_PICPATH'].split('Picture\\')
                        // console.log(split_img[1])
                        html += "<img src=\"../../" + index['DOCD_PICPATH'] + "\" onclick=\"image_extra('" + split_img[1] + "','" + index['DOCD_QDESC'] + "')\" class=\"img-fluid img-thumbnail border-secondary\">"
                    } else {
                        html += "<img src=\"../../No-Image-Placeholder.jpg\" class=\"img-fluid img-thumbnail\" alt=\"\">"
                    }

                    html += "</td>"
                    html += "<td>"
                    html += "<p> <b>" + index['DOCD_QDESC'] + "</b></p>"
                    html += "<p> <b> - รายละเอียดการตรวจสอบ : </b> " + index['DOCD_QDESC2'] + "</p>"
                    html += "<p> <b> - มาตราฐาน/ผลลัพธ์ที่คาดหวัง : </b>" + index['DOCD_QDESC3'] + "</p>"
                    html += "</td>"
                    html += "<td>"
                    html += "<input type=\"hidden\" name=\"lnno[]\" value=\""+index['DOCD_LNNO']+"\">"
                    html += "<input type=\"hidden\" name=\"type_answer[]\" value=\""+index['DOCD_QTOOL']+"\">"
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
                     * * 5.ลำดับข้อ
                     */

                    //* ถ้าประเภทคำถามเป็น OK/NG
                    if(index['DOCD_QTOOL'] == 'OK/NG') {
                        html += "<button type=\"button\" onclick=\"saveResult('"+index['DOCD_LNNO']+"','OK','"+index['DOCD_OKNG_VALUE']+"','A','"+order+"')\" class=\"btn btn-lg btn-success w-100 mb-2\">OK</button>"
                        html += "<button type=\"button\" onclick=\"saveResult('"+index['DOCD_LNNO']+"','NG','"+index['DOCD_OKNG_VALUE']+"','A','"+order+"')\" class=\"btn btn-lg btn-danger w-100\">NG</button>"
                        html += "<input type=\"hidden\" name=\"answer[]\" id=\"answer_"+index['DOCD_LNNO']+"\">"
                        html += "<input type=\"hidden\" name=\"answer_system[]\" value=\""+index['DOCD_OKNG_VALUE']+"\">"
                    }          
                    //* ถ้าประเภทคำถามเป็นระหว่าง
                    else if(index['DOCD_QTOOL'] == 'Between') {
                        let between = index['DOCD_LESS_VALUE'] + '&' + index['DOCD_THAN_VALUE']
                        // html += "<input type=\"text\" id=\"inp-between-"+index['DOCD_LNNO']+"\" class=\"form-control p-3\" placeholder=\"ระบุคำตอบ\">"
                        // html += "<input type=\"text\" name=\"answer[]\" id=\"answer_"+index['DOCD_LNNO']+"\" class=\"form-control p-3\" placeholder=\"ระบุคำตอบ\" value=\"1\">"
                        html += "<input type=\"text\" name=\"answer[]\" id=\"answer_"+index['DOCD_LNNO']+"\" class=\"form-control p-3\" placeholder=\"ระบุคำตอบ\">"
                        html += "<input type=\"hidden\" name=\"answer_system[]\" value=\""+between+"\">"
                    }
                    //* ถ้าประเภทคำถามเป็น = 
                    else if(index['DOCD_QTOOL'] == '=') {
                        // html += "<input type=\"text\" id=\"inp-equal-"+index['DOCD_LNNO']+"\" class=\"form-control p-3\" placeholder=\"ระบุคำตอบ\">"
                        // html += "<input type=\"text\" name=\"answer[]\" id=\"answer_"+index['DOCD_LNNO']+"\" class=\"form-control p-3\" placeholder=\"ระบุคำตอบ\" value=\"1\">"
                        html += "<input type=\"text\" name=\"answer[]\" id=\"answer_"+index['DOCD_LNNO']+"\" class=\"form-control p-3\" placeholder=\"ระบุคำตอบ\">"
                        html += "<input type=\"hidden\" name=\"answer_system[]\" value=\""+index['DOCD_ANSWER']+"\">"
                    }

                    html += "</td>"
                    html += "</tr>"

                    html += "<tr class=\"reason-textbox\">"
                    html += "<td colspan=\"2\" class=\"align-middle\"><div class=\"d-flex justify-content-center\">ช่องเพิ่มหมายเหตุ / คำอธิบายเหตุผลที่ไม่ผ่าน</div></td>"
                    html += "<td colspan=\"2\"><input type=\"text\" class=\"form-control\" name=\"remark[]\" placeholder=\"ช่องเพิ่มหมายเหตุ / คำอธิบายเหตุผลที่ไม่ผ่าน\"></td>"
                    html += "</tr>"
                })
                html += "</tbody>"
                html += "</table>"
                html += "<div class=\"d-flex justify-content-end\">"
                html += "<button type=\"submit\" class=\"btn btn-lg btn-primary\">กดปุ่มนี้เพื่อสิ้นสุดการตรวจสอบ</button>"
                html += "</div>"
                // html += "</form>"
                html += "</div>"
                html += "</div>"
                $('.container').html(html)

                // card-summary-choice-body
                let cscb = ''
                cscb += "<table class=\"table table-bordered table-hover border border-2 border-dark\">"
                cscb += "<thead>"

                cscb += "<tr>"
                cscb += "<th>ชื่อเอกสาร</th>"
                cscb += "<th>"+response.header[0].DOCH_NAME+"</th>"
                cscb += "</tr>"
                cscb += "<tr>"

                cscb += "<th>หมายเลขเอกสาร</th>"
                cscb += "<th>"+php_dochid+"</th>"
                cscb += "<th>เวอร์ชั่นเอกสาร</th>"
                cscb += "<th>"+php_docrevision+"</th>"
                cscb += "</tr>"

                cscb += "<tr>"
                cscb += "<th>ไลน์</th>"
                cscb += "<th>"+php_line+"</th>"
                cscb += "<th>เครื่องจักร</th>"
                cscb += "<th>"+php_mc+"</th>"
                cscb += "</tr>"

                cscb += "<tr>"
                cscb += "<th>วันที่ตรวจสอบ</th>"
                cscb += "<th>"+moment().format('YYYY/MM/DD HH:mm:ss')+"</th>"
                cscb += "<th>ผู้ตรวจสอบ</th>"
                cscb += "<th>"+php_empname+"</th>"
                cscb += "</tr>"
                
                cscb += "<tr class=\"reason-textbox\">"
                cscb += "<th>ลำดับ</th>"
                cscb += "<th colspan=\"2\">รายละเอียด</th>"
                cscb += "<th>คำตอบจากผู้ตรวจสอบ</th>"
                cscb += "</tr>"

                cscb += "</thead>"
                cscb += "<tbody id=\"tbody-cscb\"></tbody>"
                cscb += "</table>"
                cscb += "<div class=\"d-flex justify-content-between\">"
                cscb += "<button type=\"button\" id=\"btn-submit\" onclick=\"back_chk()\" class=\"btn btn-lg btn-secondary\">กลับ</button>"
                cscb += "<button type=\"button\" id=\"btn-submit\" onclick=\"btn_submit()\" class=\"btn btn-lg btn-primary\">ส่งคำตอบ</button>"
                cscb += "</div>"

                $('#card-summary-choice-body').html(cscb)
                $('#card-summary-choice').hide()
                

            } else {
                $('.container').html('ไม่สามารถแสดงผลได้')
            }

        }
    })
}

/**
 * TODO : 2023-08-07
 * * fn call modal picture 
 * * ดูภาพใหญ่ได้
 */
image_extra = (_pathIMG,_desc) => {
    // alert(_pathIMG)
    $('#exampleModalLabel').html(_desc)
    $('#modal-body-img').html('<img src=\"../../Picture/'+_pathIMG+'\"/ class=\"img-fluid border-secondary border border-dark\">')
    $('#exampleModal').modal('toggle')

}

back_chk = () => {
    $('#card-summary-choice').hide()
    $('.container').show()
}