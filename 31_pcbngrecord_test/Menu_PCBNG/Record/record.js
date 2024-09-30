recordData = () => {
  alert("test");
  // $.ajax({
  //     url:'',
  //     method:'POST',
  //     dataType:'JSON',
  //     data:{

  //     },
  //     success(){

  //     },error(){

  //     }
  // })
};

$("form#form_record").on("submit", (e) => {
  e.preventDefault();
  // alert('test')

  //   console.log(formData);
  const form = document.querySelector("form#form_record");
  const inputs = form.querySelectorAll("input[required]");
  //   console.log(form);
  //   console.log(inputs);

  let hasEmptyInput = false;
  for (const input of inputs) {
    if (input.value === "") {
      hasEmptyInput = true;
      break;
    }
  }

  if (hasEmptyInput) {
    // แสดงข้อความแจ้งเตือน
    alert("กรุณาตรวจสอบข้อมูลให้ครบถ้วน");
  } else {
    // ส่งข้อมูลไป insert
    $.ajax({
      url: "../Menu_PCBNG/Record/insert_record.php",
      method: "POST",
      dataType: "JSON",
      data: $("#form_record").serialize(),
      success(result) {
        console.log(result);
        if (result == true) {
          alert("บันทึกสำเร็จ");
          window.location.href = "menu.php";
        }
      },
      error(error) {
        console.log(error);
      },
    });
  }
});
