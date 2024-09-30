let getzone = ''
getmenu = async(_zone) => {
  await $('#row-login').fadeOut("fast")
  await $('#row-menu').fadeIn("fast")
  getzone = _zone
}

$('#pic-check').on('click',() => {
  getdoc(getzone)
})

$('#pic-report').on('click',async() => {
  await $('#row-menu').fadeOut("fast")
  await $('#row-report').fadeIn("fast")

})


/**
 * TODO : หาเอกสารที่ active TB : [DOCH_TBL]
 */
getdoc = (_zone) => {
    $.ajax({
      url:'02_model/01_check/getdocument.php',
      method:'POST',
      async:true,
      dataType:'JSON',
      data:{
        zone:_zone
      },
      beforeSend(){
        
      },
      async success(response){
        // console.log(response)
        // await $('#row-login').hide()
        await $('#row-menu').fadeOut("fast", async () => {
          await $('#row-doc').fadeIn("fast", () => {
            if(response.std == true) {
              let html = ""
              response.result.map((index) => {
                html += "<tr>"
                html += "<td>"+index['DOCH_HID']+"</td>"
                html += "<td style=\"text-align:center;\">"+index['DOCH_REV']+"</td>"
                html += "<td style=\"text-align:left;\">"+index['DOCH_NAME']+"</td>"
                html += "<td>"+index['DOCH_AOTH_DOCNO']+"</td>"
                html += "<td>"
                html += "<button type=\"button\" class=\"btn btn-md btn-success w-100\" value=\"'" + index['DOCH_DID'] + "'\" onclick=\"getdocDetail('"+index['DOCH_DID']+"','"+_zone+"','"+index['DOCH_NAME']+"','"+index['DOCH_HID']+"','"+index['DOCH_REV']+"','"+index['DOCH_TYPEID']+"')\" name=\"btndoc\" id=\"btndoc\">select</button>"
                html += "</td>"
                html += "</tr>"
              })
              $('#tbody-document').html(html)
              $('#tb-document').DataTable()
            } else {
              alert('Error : ไม่มี ?')
            }
          })
        })
      },
      error(){
        alert('Error : โหลดหน้านี้ใหม่')
      }
    })
}

/**
 * TODO : หารายละเอียดของเอกสารนั้น ๆ TB : [DOCD_TBL]
 */
getdocDetail = (DOCD_DID,zone,docname,DOCH_HID,DOCH_REV,DOCH_TYPEID) => {
    // console.log(DOCH_TYPEID)
    rev_result_arr.push(docname)
    docrevision = DOCH_REV
    $.ajax({
      url:'02_model/01_check/getdocumentdetail.php',
      method:'POST',
      async:true,
      dataType:'JSON',
      data:{
        DOCD_DID:DOCD_DID
      },
      beforeSend(){
        
      },
      async success(response){
        // console.log(response)
        await $('#row-doc').fadeOut("fast", async () => {
            await $('#row-fillcheck').fadeIn("fast", () => {
                getotherDetail(zone,DOCH_TYPEID)
                $('#revDOCD_DID').val(DOCD_DID)
                $('#revDOCH_HID').val(DOCH_HID)
                
            })
        })
      }        
    })
}

let mc_arr = []

/**
 * TODO : ไปแสดงผลที่ card : ระบุข้อมูลการตรวจสอบเพิ่มเติม
 * * 1.ไลน์ผลิต
 * * 2.เครื่องจักร
 * * 3.รับ docs type มาด้วยว่าเป็นเอกสาร Daily or PM
 */
getotherDetail = (_zone,_DOCH_TYPEID) => {
    //console.log(_zone)
    $.ajax({
        url:'02_model/01_check/getothercheck.php',
        method:'POST',
        async:true,
        dataType:'JSON',
        data:{
          zone:_zone,
          dochtype:_DOCH_TYPEID
        },
        beforeSend(){
          
        },
        success(response){
            console.log(response)
            // console.log(_DOCH_TYPEID)

            if(response.std == true) {
                let line = ''
                response.line.map((lineindex) => {
                    // line += "<option value=\""+lineindex['MLINE_ID']+"\">"+lineindex['MLINE_NAME']+" : "+lineindex['MLINE_DESC']+"</option>"
                    line += "<option value=\""+lineindex['MLINE_ID']+"\">"+lineindex['MLINE_NAME']+"</option>"
                })
                $('#sel-line').html(line)

                /**
                 * * if = เป็นเอกสาร PM
                 * * else = เป็นเอกสาร Daily check
                 */
                if(_DOCH_TYPEID == '1' || _DOCH_TYPEID == '3'){
                  $('#row-mc-type').show()

                  let mc = ''
                  mc += "<input type=\"text\" class=\"form-control\" id=\"sel-mc\" placeholder=\"ใส่หมายเลขเครื่องจักร\" disabled=\"disable\">"
                  $('#col-sel-mc').html(mc)

                  let type_mc = ''
                  type_mc += "<option value=\"0\">เลือกประเภทเครื่องจักร</option>"
                  response.type_mc.map((index) => {
                    type_mc += "<option value=\""+index['MMC_DESC']+"\">"+index['MMC_DESC']+"</option>"
                  })
                  $('#sel-mc-type').html(type_mc)

                } else {
                  mc_arr = []
                  let mc = ''
                  mc += "<select class=\"form-select\" id=\"sel-mc\" aria-label=\"\">"
                  response.mc.map((mcindex) => {
                    mc += "<option value=\""+mcindex['MMC_ID']+"\">"+mcindex['MMC_NAME']+" : "+mcindex['MMC_DESC']+"</option>"
                    mc_arr.push(mcindex['MMC_ID'])
                  })
                  mc += "</select>"                        
                  mc += "<div class=\"valid-feedback\">ยอดเยี่ยม!</div>"
                  mc += "<div class=\"invalid-feedback\">กรุณาเลือกเครื่องจักร</div>"
                  $('#col-sel-mc').html(mc)
                }
            } else {

            }
        }
    })
}

/**
 * TODO : จะถูกเรียกใช้ตอนเอกสาร PM 
 * * onchange : ประเภทเครื่องจักร
 */
find_mc = () => {
  let sel_mc_type = $('#sel-mc-type').val()
  // alert(sel_mc_type)
  $.ajax({
    url:'02_model/01_check/getmachine_by_type.php',
    method:'POST',
    async:true,
    dataType:'JSON',
    data:{
      mctype:sel_mc_type
    },
    beforeSend(){
      
    },
    success(response){
        // console.log(response)
        $('#sel-mc').prop("disabled", false)
        mc_arr = []
        response.mc.map((mcname) => {
          mc_arr.push(mcname.MMC_ID)
        })

        $('#sel-mc').autocomplete({
          minLength: 1,
          source: mc_arr,
        })
      // console.log(mc_arr)
    }
  })
}

/**
 * TODO : btn summary เมื่อกดแล้วจะแสดงข้อมูลจากที่เลือกมาก่อนไปตรวจสอบ ไลน์ผลิต
 */
$('#btn-row-fillcheck').on('click',() => {
  $('#row-fillcheck').fadeOut("fast", async () => {
    await $('#row-sum').fadeIn("fast", shown_result = async() => {

        /**
         * * เช็คก่อนว่าได้มีการพิมพ์ชื่อเครื่องจักรมาถูกต้องหรือไม่
         * * if = ถูกต้องมีใน array
         * * else = ไม่มีใน array
         */
        let sel_mc = $('#sel-mc').val()
        if(mc_arr.indexOf(sel_mc) != -1) {
            $('#btn-row-sum').show()
        } else {
            Swal.fire({
              icon: 'warning',
              title: 'ชื่อเครื่องจักรไม่ถุกต้องกรุณากลับไปใส่ใหม่',
            })
            $('#btn-row-sum').hide()
        }

        let thList = ['รหัสพนักงาน','ชิ่อเอกสารที่เลือก','กะทำงานที่เลือก','ไลน์ผลิตที่เลือก','เครื่องจักรที่เลือก']
        rev_result_arr.push($('#sel-shift').val())
        rev_result_arr.push($('#sel-line').val())
        rev_result_arr.push($('#sel-mc').val())
        rev_result_arr.push($('#revDOCD_DID').val())
        rev_result_arr.push($('#revDOCH_HID').val())
        //console.log(rev_result_arr)
        rev_result_arr.map((index,current) => {
          //console.log(index + ' : ' + current)
          if(current != 1){
            prepare_result_arr.push(index)
          }
        })
        //console.log(prepare_result_arr)
        let table = "<tbody>"
        thList.map((index,current) => {
          table += "<tr>"
          table += "<th>"+index+"</th>"
          table += "<th>"+rev_result_arr[current]+"</th>"
          table += "</tr>"
        })
        table += "</tbody>"
        $('#table-row-sum').html(table)
    })
  })
})

/**
 * TODO : เมื่อกดปุ่ม start id = btn-row-sum
 * * จะสร้างหน้าต่างใหม่และแสดงผลรายการที่จะต้องตรวจสอบ
 */
$('#btn-row-sum').on('click', () => {
  prepare_result_arr.push(dept)
  prepare_result_arr.push(empname)
  prepare_result_arr.push(docrevision)
  
  if(dept == 'PROD-CA') {
    window.open('01_view/02_checkdetail/checkdetail.php?result='+prepare_result_arr, '_blank');

  } else {
    window.open('01_view/02_checkdetail/checkdetail_MT.php?result='+prepare_result_arr, '_blank');
  }
})
