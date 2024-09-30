 <?php require("helpers/db.php")?>

<?php 
$searchTitle ="";

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>...ASSET</title>

</head>
<body>
    <div>
    <form>
<p>
<input type="search" name="search">
<button type="submit"> ค้นหา </button>
</p>
</form>

    </div>
<div> 

<?php

$search =$_GET["search"];
$sql = "SELECT * FROM color WHERE title LIKE '%$search%' ORDER BY id DESC"; 
$result = sqlsrv_query($conn,$sql);
if( $result === false) {
    die( print_r( sqlsrv_errors(), true) );

}
while( $row = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC) ) {
      echo $row['title'].", ".$row['color']."<br />";
}
// sqlsrv_free_stmt( $result);
?>

</div>
</body>
</html>
<?php sqlsrv_close($conn);?>

<?php

// $serverName = "AOTHLP0135\SQLEXPRESS"; //serverName\instanceName //เชื่อมต่อฐานข้อมูล DataBase
// $connection = array( "Database"=>"PHP-ASSET", "UID"=>"", "PWD"=>""); //เชื่อมต่อ DataBase ที่ชื่อ PHP-ASSET
// $conn = sqlsrv_connect( $serverName, $connection);  //ทำการประกาศตัวแปร $conn เพื่อทำการเชื่อมต่อ Database
// //Code ข้างบนเป็นการ Conneton กับ ฐานข้อมูลโดยตรง

// require("helpers/db.php"); //เรียก funtion มาจาก Folder/helpers/db.php
// if( $conn === false ) {
//     die( print_r( sqlsrv_errors(), true));
// }

// $sql = "SELECT title, color FROM color"; //ทำการเลือกข้อมูลออกมาแสดง โดยเลือกข้อมูลที่อยู่ในแต่ละ ฟิวล์ ที่อยู่ในตาราง Database
// $stmt = sqlsrv_query( $conn, $sql );
// if( $stmt === false) {
//     die( print_r( sqlsrv_errors(), true) );
// }

// while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
//       echo $row['title'].", ".$row['color']."<br />";
// }

// sqlsrv_free_stmt( $stmt);




//   require("helpers/db.php"); //เรีกใช้ Funtion Connection DataBase ในการเชื่อมต่อฐานข้อมูล
//  คำสั่งทำการ เพิ่มข้อมูลลงไปในฐานข้อมูล........................................

// $sql = "INSERT INTO color (id,title,color) VALUES (4,'Yellow','5555')";
// $result = sqlsrv_query($conn,$sql);
// if($result)
// echo 'Data Inseartion Success';
// else 
// echo 'insertion Error';

//....................................................................

?> -->