<?php require("helpers/db.php")?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มสีใหม่ | </title>

</head>
<body>
    <div>
<?php if($_SERVER["REQUEST_METHOD"]  == "POST"):?>
       
        <?php

        // $code = sqlsrv_query($conn,$_POST["code"]);
        // $title = sqlsrv_query($conn,$_POST["title"]);

        $query = "INSERT INTO color (id,title,color) VALUES ('5','RED','555 ');"; //ทำการเพิ่มข้อมูลลงไปที่ตาราง color ฟวิล์ (id,title,color) ค่าที่ใส่ลงไป ('6','White','44444')
        $parameters = [$_POST["title"], $_POST["color"]];
        $result = sqlsrv_query($conn, $query, $parameters);

        //$sql = "INSERT INTO color (id,title,color) VALUES ('$id','$title','$color');"; //ทำการเพิ่มข้อมูลลงไปที่ตาราง color ฟวิล์ (id,title,color) ค่าที่ใส่ลงไป ('6','White','44444')
       // $result = sqlsrv_query($conn,$sql); //ทำการ query ข้อมูลที่ต้องการจากตาราง



        ?>

        <?php if ($result): ?>
            <h3>บันึกเรียบร้อย</h3>
            <p>
                <a href="./index.php">กลับหน้าแรก</a>
            </p>
            <?php  else:?>
            <h3>บันทึกสีผิดพลาด</h3>
            <p>
                <a href="new-color.php">เพิ่มสีใหม่อีกครั้ง</a>
            </p>

                <?php endif;?>

        <?php else:?>
            <form method="post">
            <p>
            <label>โค้ดสี</label>
            <input type="color" name="color">
            </p>
            <p>
            <label>ชื่อสี</label>
            <input type="text" name="title">
            </p>
            <p>
            <button type="submit">บันทึกสี</button>
            </p>
</form>
<?php endif;?>
</div>
</body>
</html>
<?php sqlsrv_close($conn);?>
<?php






// require("helpers/db.php"); //เรียก funtion มาจาก Folder/helpers/db.php

//  คำสั่งทำการ เพิ่มข้อมูลลงไปในฐานข้อมูล........................................

// $sql = "INSERT INTO color (id,title,color) VALUES ('6','White','44444');"; //ทำการเพิ่มข้อมูลลงไปที่ตาราง color ฟวิล์ (id,title,color) ค่าที่ใส่ลงไป ('6','White','44444')
// $result = sqlsrv_query($conn,$sql); //ทำการ query ข้อมูลที่ต้องการจากตาราง

// if($result)
// echo 'Data Inseartion Success'; //เพิ่มข้อมูลได้ แสดงข้อความ Data Inseartion Success
// else 
// echo 'insertion Error'; //ไม่สามารถเพิ่มข้อมูลได้ แสดงข้อความ insertion Error

// sqlsrv_close($conn); //ทำการปิดการเชื่อมต่อฐานข้อมูล