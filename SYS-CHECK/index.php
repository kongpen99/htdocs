<?php

session_start();

require_once "config/con-db.php";

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $deletestmt = $conn->query("DELETE FROM user WHERE id = $delete_id");
    $deletestmt->execute();

    if ($deletestmt) {
        echo "<script>alert('Data has been deleted successfully');</script>";
        $_SESSION['success'] = "Data has been deleted succesfully";
        header("refresh:1; url=index.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Histoty Backup Check </title>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">


    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
    <script src="js/bootstrap.min.js"></script>
    <script src="jquery/jquery-3.7.1.min.js"></script>

    <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script> -->


    <style>
        h4 {
            text-align: center;
        }

        p {
            text-align: center;

        }
    </style>

    <!-- <style>
    body {background-color: lightblue;}
   </> -->


</head>

<body class="">
    <nav class="navbar navbar-light mb-3" style="background-color:#a7e1f7;">
        <div class="container-fluid">
            <a class="navbar-brand" href="#" style="font-size:1.5em;">
                <img src="artworks/01_logo-01.png" class="d-inline-block align-top" alt="">
                AOTH WEB-Programs (Internal AOTH)
                <p id="watermark" style="font-size:14px">&copy; 2022 Alpine Technology Manufacturing (Thailand) Co.,Ltd. All rights reserved.</p>
            </a>
        </div>
    </nav>

    <div class="container-fluid  pt-4 pb-4 ">
        <div class="row">
            <div class="col-sm-3">
                <div class="card border border-dark border-3 h-500">
                    <div class="card-header bg-warning">Antivirus Check update</div>
                    <h4 class="card-title">Symantec Antivirus Update</h4>
                    <center><img src="picture/symentec.jpg" alt="" style="width: 100px;height: 100px"></center>
                    <p class="card-text" style="color:blue;">For History supporting check antivirus. </p>
                    <!-- <a href="#" class="btn btn-primary">Report check</a> -->
                    <div class="col-12">
                        <center><a href="Link-Page/Antivirus.php" target="_blank"><button type="submit" class="mb-2 btn btn-primary">Report check</button></center></a>
                    </div>

                </div>
            </div>

            <div class="col-sm-3">
                <div class="card border border-dark border-3 h-300">
                    <div class="card-header bg-danger text-white">Recovery Test Tape Backup</div>
                    <h4 class="card-title">Veritas backup </h4>
                    <center><img src="picture/Veritas.jpg" alt="" style="width: 100px;height: 100px;"></center>
                    <p class="card-text" style="color:blue;">For History supporting check test recovery backup.</p>
                    <!-- <a href="#" class="btn btn-primary">Report check</a> -->
                    <div class="col-12">
                        <center><a href="Link-page/Backup.php" target="_blank"><button type="submit" class="mb-2 btn btn-primary">Report check</button></center></a>
                    </div>

                </div>
            </div>

            <div class="col-sm-3">
                <div class="card border border-dark border-3 h-300">
                    <div class="card-header bg-success text-white">Server Room </div>
                    <h4 class="card-title"> Server Room</h4>
                    <center><img src="picture/list.jpg" alt="" style="width: 100px;height: 100px;"></center>
                    <p class="card-text" style="color: blue;">For History check use entry server room.</p>
                    <!-- <a href="#" class="btn btn-primary" type="button">Report check</a> -->
                    <div class="col-12">
                        <center><a href="Link-Page/ServerRoom.php" target="_blank"><button type="submit" class="mb-2 btn btn-primary">Report check</button></center></a>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="card border border-dark border-3 h-300">
                    <div class="card-header bg-primary text-white">Software Control </div>
                    <h4 class="card-title">Software License </h4>
                    <center><img src="picture/Software.jpg" alt="" style="width: 100px;height: 100px;"></center>
                    <p class="card-text" style="color: blue;">Software License Control </p>
                    <!-- <a href="#" class="btn btn-primary" type="button">Report check</a> -->
                    <div class="col-12">
                        <center><a href="Link-page/Software.php" target="_blank"><button type="submit" class="mb-2 btn btn-primary">Report check</button></center></a>
                    </div>
                </div>
            </div>
            <hr>
            <br>



</body>

</html>