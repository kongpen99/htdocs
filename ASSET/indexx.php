<?php 
// เชื่อมต่อฐานข้อมูล

$dsn ="mysql:host=localhost;dbname=mydb";
$username="root";
$password="";

//เตรียมข้อมูล
 
$fname ="Tossapon";
$age ="44";
$department="IT Support Services";
$id=1; //หมายเลข id ที่ต้องการจะทำการ Update ข้อมูล

try{

//ชุดทำการ Update ข้อมูล

$obj = new PDO($dsn,$username,$password); //ประการตัวแปรในการเชื่อมต่อฐานข้อมูล
$sql = "UPDATE employees SET fname = ?, age = ?, department = ? WHERE id = ?";  //ทำการ Update ตารางข้อมูล และ ชื่อคอลัมน์ (Column Name) ที่ต้องการ
$stmt = $obj->prepare($sql); //เอาคำสั่ง $sql ไปทำงานร่วมคำสั่ง $obj และเรียกใช้ Methode prepare แล้วโยนคำสั่ง $sql เข้าไปแล้วคืนค่ากลับมาเป็น PDO Statement หรือ $stmt
$stmt->bindParam(1, $fname); //ทำการเอา $stmt ผูกกับ bindParam พาลามิเตอร์ตัว 1 (Column, Name) 
$stmt->bindParam(2, $age); //ทำการเอา $stmt ผูกกับ bindParam พาลามิเตอร์ตัวที่ 2 (Column, Name) 
$stmt->bindParam(3, $department); //ทำการเอา $stmt ผูกกับ bindParam พาลามิเตอร์ตัวที่ 3 (Column, Name)
$stmt->bindParam(4, $id);  //ทำการเอา $stmt ผูกกับ bindParam พาลามิเตอร์ตัวที่ 4 (Column, Name) //หมายเลข id ที่ต้องการจะทำการ Update ข้อมูล
$stmt->execute(); //ทำการสั่ง Run คำสั่ง

echo"Updated แล้ว";

}catch(PDOException $e){
echo $e->getMessage();
}


?>