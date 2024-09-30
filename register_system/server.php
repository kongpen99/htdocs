<?php
    //Connections to server and connect to database
    $servername= "localhost";
    $username= "root";
    $password= "";
    $dbname= "register_db";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    // Check connection
    if (!$conn){
        die("Could not failed".mysqli_connect_error());
    // }else{
    //     echo "Connected successfully";
    }
?>