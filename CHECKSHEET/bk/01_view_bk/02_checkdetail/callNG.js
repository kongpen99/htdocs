/**
 * TODO : Fn สำหรับเรียกใช้งาน modal NG
 * * จะถูกเรียกใช้งานตอนที่ user ระบุค่าที่เป็น NG มา
 */
 CallNG_modal = (_choicenum , _choiceall , _useranswer) => {
    let modal = ""
    modal += "<div class=\"modal fade \" id=\"exampleModal\" tabindex=\"-1\" aria-labelledby=\"exampleModalLabel\" aria-hidden=\"true\">"
    modal += "  <div class=\"modal-dialog modal-lg\">"
    modal += "      <div class=\"modal-content\">"
    modal += "          <div class=\"modal-header bg-danger\">"
    modal += "              <h1 class=\"modal-title fs-5\" id=\"exampleModalLabel\">ระบุสาเหตุว่าทำไมถึงไม่ผ่าน</h1>"
    modal += "              <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Close\"></button>"
    modal += "          </div>"
    modal += "          <div class=\"modal-body\">"
    modal += "              <div class=\"form-floating\">"
    modal += "                  <textarea class=\"form-control\" placeholder=\"Leave a comment here\" id=\"ng-reason-"+_choicenum+"\"></textarea>"
    modal += "                  <label for=\"floatingTextarea\">ระบุคำอธิบายเพิ่มเติม</label>"
    modal += "              </div>"
    modal += "              <div class=\"row mt-3\">"
    modal += "                  <div class=\"col-12\">"
    modal += "                      <form method=\"post\" action=\"\" enctype=\"multipart/form-data\" id=\"uploadForm\">"
    modal += "                          <label for=\"formFile\" class=\"form-label\">แนบภาพประกอบ (สูงสุด 5 ไฟล์)</label>"
    modal += "                          <input class=\"form-control\" type=\"file\" name=\"file\" id=\"ng-file\" />"
    // modal += "                          <input type=\"submit\" class=\"btn btn-md btn-success\" name=\"submit\" value=\"Upload\">"
    modal += "                          <div class=\"row mt-2\">"
    modal += "                              <div class=\"col-6\">"
    modal += "                                  <label>ส่วนแสดงผลรูปภาพ</label>"
    modal += "                                  <div id=\"showimg\"></div>"
    modal += "                                  <div id=\"btn-showimg\"></div>"
    modal += "                              </div>"
 
    modal += "                              <div class=\"col-6\">"
    modal += "                                  <label>รายการรูปภาพที่เลือก</label>"
    modal += "                                  <ul id=\"select-ng-file\"></ul>"
    modal += "                              </div>"
 
    modal += "                          </div>"
    modal += "                      </form>"
    modal += "                  </div>"
    modal += "              </div>"
    modal += "          </div>"
    modal += "          <div class=\"modal-footer\">"
    modal += "              <button type=\"button\" class=\"btn btn-secondary\" data-bs-dismiss=\"modal\">Close</button>"
    modal += "              <button type=\"button\" class=\"btn btn-primary\" onclick=\"submitLNNO(0,'"+_choicenum+"','"+_choiceall+"','"+_useranswer+"')\">Save changes</button>"
    modal += "          </div>"
    modal += "      </div>"
    modal += "  </div>"
    modal += "</div>"
    $('.custome-modal').html(modal)
    $('#exampleModal').modal('toggle')
}

/**
 * TODO : กรณีที่มีการกดบันทึกซ้ำมา
 * TODO : Fn สำหรับเรียกใช้งาน modal NG
 * * จะถูกเรียกใช้งานตอนที่ user ระบุค่าที่เป็น NG มา
 */
 CallNG_modal_resend = (_choicenum , _choiceall , _useranswer) => {
    let modal = ""
    modal += "<div class=\"modal fade \" id=\"exampleModal\" tabindex=\"-1\" aria-labelledby=\"exampleModalLabel\" aria-hidden=\"true\">"
    modal += "  <div class=\"modal-dialog modal-lg\">"
    modal += "      <div class=\"modal-content\">"
    modal += "          <div class=\"modal-header bg-danger\">"
    modal += "              <h1 class=\"modal-title fs-5\" id=\"exampleModalLabel\">ระบุสาเหตุว่าทำไมถึงไม่ผ่าน</h1>"
    modal += "              <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Close\"></button>"
    modal += "          </div>"
    modal += "          <div class=\"modal-body\">"
    modal += "              <div class=\"form-floating\">"
    modal += "                  <textarea class=\"form-control\" placeholder=\"Leave a comment here\" id=\"ng-reason-"+_choicenum+"\"></textarea>"
    modal += "                  <label for=\"floatingTextarea\">ระบุคำอธิบายเพิ่มเติม</label>"
    modal += "              </div>"
    modal += "              <div class=\"row mt-3\">"
    modal += "                  <div class=\"col-12\">"
    modal += "                      <form method=\"post\" action=\"\" enctype=\"multipart/form-data\" id=\"uploadForm\">"
    modal += "                          <label for=\"formFile\" class=\"form-label\">แนบภาพประกอบ (สูงสุด 5 ไฟล์)</label>"
    modal += "                          <input class=\"form-control\" type=\"file\" name=\"file\" id=\"ng-file\" />"
    // modal += "                          <input type=\"submit\" class=\"btn btn-md btn-success\" name=\"submit\" value=\"Upload\">"
    modal += "                          <div class=\"row mt-2\">"
    modal += "                              <div class=\"col-6\">"
    modal += "                                  <label>ส่วนแสดงผลรูปภาพ</label>"
    modal += "                                  <div id=\"showimg\"></div>"
    modal += "                                  <div id=\"btn-showimg\"></div>"
    modal += "                              </div>"
 
    modal += "                              <div class=\"col-6\">"
    modal += "                                  <label>รายการรูปภาพที่เลือก</label>"
    modal += "                                  <ul id=\"select-ng-file\"></ul>"
    modal += "                              </div>"
 
    modal += "                          </div>"
    modal += "                      </form>"
    modal += "                  </div>"
    modal += "              </div>"
    modal += "          </div>"
    modal += "          <div class=\"modal-footer\">"
    modal += "              <button type=\"button\" class=\"btn btn-secondary\" data-bs-dismiss=\"modal\">Close</button>"
    modal += "              <button type=\"button\" class=\"btn btn-primary\" onclick=\"submitLNNO_resend(0,'"+_choicenum+"','"+_choiceall+"','"+_useranswer+"')\">Save changes</button>"
    modal += "          </div>"
    modal += "      </div>"
    modal += "  </div>"
    modal += "</div>"
    $('.custome-modal').html(modal)
    $('#exampleModal').modal('toggle')
}

//* ทำงานเมื่อกด browse image
$(document).on('change','#ng-file',function(){
    filePreview(this);
});

//* fn แสดงผลภาพที่กดแนบมาก่อน add to array
filePreview = (input) => {
    //console.log(input.files)
    if (input.files && input.files[0]) {
        let reader = new FileReader();
        reader.onload = function(e) {
            let html = ''
            // html += '<img src="'+e.target.result+'" width="450" height="300"/>'
            html += '<button type=\"button\" id=\"btn-ng-file\" value=\"OK\" class=\"btn btn-md btn-success w-100\">เพิ่ม</button>'

            $('#showimg + img').remove()
            // $('#showimg').after('<img src="'+e.target.result+'" width="450" height="300"/>');
            $('#showimg').after('<img src="'+e.target.result+'" class=\"card-img-top mt-3\">')
            $('#btn-showimg').html(html).show()
        };
        reader.readAsDataURL(input.files[0]);
    }
}

//* ปุ่มสำหรับ add image เข้าไปใน array formData
$(document).on('click','#btn-ng-file',function(){
    if($('#ng-file').val()){
        form_data.delete("checkpicture")
        form_data.append("checkpicture", 1)

        let files = $('#ng-file').prop('files')[0]
        // * เก็บเฉพาะ obj ที่เป็น tag name
        let name = files['name']
        let lastModified = files['lastModified']
        /**  
         * * FN : split แบ่งเป็นช่องด้วย .
         * * FN : pop ดึงเอาตัวสุดท้ายใน array เอามาแสดง
         * * FN : toLowerCase ทำเป็นตัวพิมพ์เล็กทั้งหมด
         * */ 
         let extension = name.split('.').pop().toLowerCase()
        /**
         * * if เปรียบเทียบว่า extension = นามสกุลที่เราตัดออกมานั้น
         * * มีอะไรที่เข้ากับตัวแปร array ในเครื่องหมาย [] หรือไม่
         * * ถ้าผลลัพธ์ออกมา = -1 แสดงว่าไม่มีนามสกุลในนี้เลย จะเข้า if
         * TODO : ถ้าเข้า else ถึงจะโอเคร
         */
        if($.inArray(extension, ['png','jpg','jpeg']) == -1){
           alert("กรุณาเลือกภาพที่มีนามสกุล .png .jpg .jpeg เท่านั้นค่ะ ")
           return
        } 
        else{

            form_data.append("files[]", files)
            arrNGlastModified.push(lastModified)

            //* ส่วน reset รูปภาพและปุ่มเพิ่ม
            $('#showimg + img').remove()
            $('#btn-showimg').hide()
            $('#ng-file').val('')

            //* ส่วนแสดงผลรายการที่เลือกไว้
            let li = ''
            li += "<li id=\""+lastModified+"\" class=\"m-1\">"
            //* สร้างปุ่มสำหรับต้องการลบไฟล์นี้ก่อนที่จะ upload
            li += "<button type=\"button\" class=\"btn btn-sm btn-danger\" value=\"del\" onclick=\"DelNG_file("+lastModified+")\">ลบ</button>"
            li += " "+name 
            li += "</li>"
            $('ul#select-ng-file').append(li)
        }
    }
    // console.log(Array.from(form_data.entries()))
    //console.log(arrNGlastModified)
})

/**
 * TODO : FN เมื่อกดลบภาพที่แนบไว้
 */
DelNG_file = (_lastModified) => {

    //* 1.สร้างตัวแปรมาเก็บข้อมูลจากตัวแปร form_data ณตำแหน่ง obj files[]
    let temp_ngfile = form_data.getAll("files[]")
    //* 2.สั่งลบ obj files[]
    form_data.delete('files[]');
    //* 3.นำค่าที่ส่งมาจาก onclick button fn มาหาว่าตัวที่จะลบอยู่ array ตำแหน่งไหน
    let find_arr_cur = arrNGlastModified.indexOf(_lastModified)
    //* 4.ได้ตำแหน่งและเอามา  splice ออก 1 ตัวจากตัวแปรที่สร้างมาในข้อ 1
    temp_ngfile.splice(find_arr_cur, 1);
    //* 5.เสร็จแล้วก็วนตัวแปรที่ตัดออกแล้วกลับเข้าไปใน form_data > obj : files[]
    temp_ngfile.map((index) => {
        form_data.append("files[]",index)
    })
    //* 6.remove li this clicked
    $('li#'+_lastModified).remove()

    // console.log(Array.from(form_data.entries()))
    // console.log(form_data.has("files[]"))
    //* 7.ตรวจสอบว่า files ยังมีอยู่ไหมใน form_data (false = คือไม่มีแล้ว)
    if(form_data.has("files[]") == false){
        //* 8.เข้ามาเพื่อเปลี่ยนตัวแปร checkpicture = 0 เพราะไม่มีรูป
        form_data.delete("checkpicture")
        form_data.append("checkpicture", 0)

    }
}