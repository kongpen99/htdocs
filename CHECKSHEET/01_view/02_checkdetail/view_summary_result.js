/**
 * TODO : vsr = view summary result
 * * update : 2023-05-08
 * * เป็น fn ที่จะเรียกข้อมูลในตาราง temp มาแสดงผลเป็นหน้าสรุปรวมก่อนที่จะทำการ submit button ส่งเข้าตารางจริง
 */
vsr = (countchoices) => {
    $.ajax({
        url:'../../02_model/02_checkdetail/get_view_summary_result.php',
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
            $('#card-question-'+countchoices).hide()
            $('#card-summary').show()

            if(response.get_temp == null) {
                // answerIncorrect('กรุณากลับไประบุคำตอบของท่าน' , '')
                nextOrprevious(countchoices,countchoices,'summary')
            } else {

            let html = ''
            let arrLNNO = []
            let arrANSWER = []
            response.get_temp.map((index_gt) => {
                arrLNNO.push(index_gt['DOC_LNNO'])
                arrANSWER.push(index_gt['DOC_ANSWER'])
            })
            // console.log(arrLNNO)
            // console.log(arrANSWER)
            html += "<div class=\"card bg-light mt-5\" id=\"card-summary\">";
            html += "   <div class=\"card-header card-header-lightblue text-white h3\">"
            html += "       <h5>สรุปผล</h5>"
            html += "   </div>"
            html += "   <div class=\"card-body\">"
            html += "       <div class=\"row\">"
            html += "           <div class=\"col\">"
            html += "               <table class=\"table table-bordered table-hover border-dark\">"
            html += "                   <thead>"
            html += "                       <tr>"
            html += "                           <th colspan=\"4\">"+response.choice_detail[0].DOCH_NAME+"</th>"
            html += "                       </tr>"
            html += "                       <tr>"
            html += "                           <th>หมายเลขเอกสาร</th>"
            html += "                           <th>"+php_dochid+"</th>"
            html += "                           <th>เวอร์ชั่นเอกสาร</th>"
            html += "                           <th>"+php_docrevision+"</th>"
            html += "                       </tr>"
            html += "                       <tr>"
            html += "                           <th>วันที่ตรวจเช็ค</th>"
            html += "                           <th>"+moment(response.get_temp[0].DOC_DATETIME.date).format('YYYY/MM/DD HH:mm:ss')+"</th>"
            html += "                           <th>เลขเครื่องจักร</th>"
            html += "                           <th>"+php_mc+"</th>"
            html += "                       </tr>"
            html += "                       <tr>"
            html += "                           <th>ไลน์</th>"
            html += "                           <th>"+php_line+"</th>"
            html += "                           <th>ผู้ตรวจเช็ค</th>"
            html += "                           <th>"+php_empname+"</th>"
            html += "                       </tr>"
            html += "                   </thead>"
            html += "                   <tbody>"
            html += "                       <tr>"
            html += "                           <th class=\"text-center\">ลำดับของข้อ</th>"
            html += "                           <th class=\"text-center\"colspan=\"2\">หัวข้อ</th>"
            html += "                           <th class=\"text-center\">คำตอบจากผู้ใช้งาน</th>"
            html += "                       </tr>"
            response.choice_detail.map((index_cd , index_cd_current) => {
                html += "<tr>"
                html += "<td class=\"text-center\">"+index_cd['DOCD_LNNO']+"</td>"
                html += "<td colspan=\"2\">"+index_cd['DOCD_QDESC']+"</td>"

                /**
                 * TODO : เงื่อนตรวจสอบว่าเจอคำตอบจากใน array ที่เก็บข้อมูลจาก temp ไหม
                 * * if = เจอ
                 * * else = ไม่เจอ
                 */
                let findLNNO = arrLNNO.indexOf(index_cd['DOCD_LNNO'])
                if(findLNNO != -1) {
                    html += "<td>"+arrANSWER[findLNNO]+"</td>"
                } else {
                    html += "<td class=\"bg-danger\">ไม่ได้ระบุคำตอบ</td>"
                }
                html += "</tr>"
            })
            html += "                   </tbody>"

            html += "               </table>"
            html += "           </div>"
            html += "       </div>"
            html += "   </div>"

            html += "   <div class=\"card-footer\">"
            html += "       <div class=\"d-flex flex-row-reverse\">"
            html += "           <button type=\"button\" id=\"btn-submit\" onclick=\"submitEnding()\" class=\"btn btn-md btn-success m-1\">ส่งผลการตรวจสอบ</button>"
            html += "           <button type=\"button\" id=\"btn-previous\" onclick=\"nextOrprevious('"+countchoices+"','"+countchoices+"','summary')\" class=\"btn btn-md btn-secondary m-1\">ก่อนหน้า</button>"

            html += "       </div>"
            html += "   </div>"

            html += "</div>"
            $('#card-summary').html(html)
            }
        },
        async error(){
            alert('error')
        }
    }) 
}