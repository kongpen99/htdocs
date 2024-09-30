<?php
$serverName = "AOTHLP0135\SQLEXPRESS"; //serverName\instanceName //เชื่อมต่อฐานข้อมูล DataBase
$connection = array( "Database"=>"PHP-ASSET", "UID"=>"", "PWD"=>""); //เชื่อมต่อ DataBase ที่ชื่อ PHP-ASSET
$conn = sqlsrv_connect( $serverName, $connection);  // ทำการประกาศตัวแปร $conn เพื่อทำการเชื่อมต่อ Database

// ใช้ Funtion if ในการตรวจสอบการเชื่อมต่อ ฐานข้อมูล...................
if($conn == false)
die(die( print_r(sqlsrv_errors(), true)));
// else echo 'connection Success'; //TODO ข้อความแจ้งเตือนว่าทำการเชื่อมต่อฐานข้อมูลได้สำเร็จ 
//..............................................................
?>