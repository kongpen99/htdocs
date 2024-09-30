<?php
date_default_timezone_set("Asia/Bangkok");
$year = date("Y");
session_start();
if(!empty($_GET['username'])){
    $_SESSION["username"] = $_GET['username'];
    $_SESSION["id"] = $_GET['empno'];
    $_SESSION["emp_sec"] = $_GET['department'];
    $_SESSION["USE_PERMISSION"] = $_GET['USE_PERMISSION'];
    $_SESSION["sec"] = $_GET['sec'];
    $per = $_GET['USE_PERMISSION'];
    header("Location:Menu_PCBNG/menu.php");
}
if(empty($_SESSION['id'])){
    header('Location: http://web-server/menu.php');
    exit(0);
} 
?>
