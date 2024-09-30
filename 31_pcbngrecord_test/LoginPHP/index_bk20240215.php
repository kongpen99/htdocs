<?php
session_start();
include '../Connect/connect.php';
$conn = new CSQL;
$server = "localhost";
$db = "PCB_NG_DATA";
$conn->connect($server, $db);


if(isset($_GET['submit'])){
    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $username = validate($_GET['username']);
    $password = validate($_GET['password']);

    if(empty($username) || empty($password)){
        echo "<script>alert('กรุณากรอกข้อมูลให้ครบถ้วน')</script>";
    }else{
        $sql = "SELECT * FROM PCB_LOGIN WHERE username = '$username' AND password = '$password'";
        $conn->Query($sql);
        $result = $conn->FetchData();
        if(!empty($result)){
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $password;
            $_SESSION['id'] = $result[0]['id'];
            $_SESSION['emp_name'] = $result[0]['emp_name'];
            $_SESSION['emp_sec'] = $result[0]['emp_sec'];
            header("Location:../Menu_PCBNG/menu.php");
            
            echo "<script>alert('Login Success')</script>";
        }else{
            echo "<script>alert('Login Failed')</script>";
        }
    }

    

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="shortcut icon" href="../images/login.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../JQuery/jquery-3.7.1.js"></script>
    <style>
      /* @import url('https://fonts.cdnfonts.com/css/shark-made-in-japan'); */
      @import url('https://fonts.googleapis.com/css2?family=Lemon&display=swap');
      @import url('https://fonts.googleapis.com/css2?family=Mitr:wght@500&display=swap');
        body {
            background-color: #4cc9f0;
        }

        input[type=text],
        input[type=password] {
            width: 100%;
            padding: 10px 15px;

        }

        input[type=text]:focus,
        input[type=password]:focus {
            outline: none;
        }

        .btn {
            width: 100%;
            background-color: #22577a; 
            color: white;
            padding: 5px 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 30px;
            font-size: 25px;
            font-family: 'Lemon', serif;
                                                
        }
        .btn:hover {
            color: #eac4d5;
        }

        .container {
            width: 40%;
            height: 60vh;
            background-color: #F5F5F5;
            margin: 8% auto;
            border-radius: 10px;
            background-color: #00b4d8;
        }

        .headerText {
            font-family: 'Mitr', serif;                                                                                                                                          
            font-size: 25px;
            font-weight: 600;
            margin-top: 20px !important;
            color:  #22577a;
        }

        .form {
            margin: 10px auto;
        }

        .form-label {
            font-size: 16pt;
            font-weight: 600;
            color: #22577a;
        }
        /* .img-sakura{
            width: 40%;
            z-index: 1;
            position: absolute;
            top: 0;
            left: 60%;
        }
        .img-sakura2{
            width: 40%;
            z-index: 1;
            position: absolute;
            top: 0;
            right: 60%;
            transform: scaleX(-1);
        } */
    </style>
</head>

<body>
    <!-- <img src="../images/sakura-flower.webp" class="img-sakura" alt="">
    <img src="../images/sakura-flower.webp" class="img-sakura2" alt=""> -->
    
    <div class="container ">
        <p class="headerText d-flex justify-content-center">ระบบบันทึกและอนุมัติข้อมูล PCB NG</p>
        <div class="d-flex justify-content-center ">
            <form action="" class="form">

                <input type="text" class="form-control mt-3 " placeholder="Username" id="username" name="username">
                <input type="password" class="form-control mt-4" placeholder="Password" id="password" name="password">
                <button type="submit" class="btn" name="submit" id="submit">Login</button>
            </form>
        </div>

    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</body>

</html>