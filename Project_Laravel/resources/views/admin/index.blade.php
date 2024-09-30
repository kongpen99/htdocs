<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

    <?php
        
        $user = "kongpeng99";

        $arr = array("Home", "Member", "About","Contact");

        ?>

    @if($user =="kongpeng99")
            <h1 style="color: blue">ยินดีต้อนรับแอดมิน {{$user}}</h1>
            <p> Lorem ipsum dolor sit, amet consectetur adipisicing elit. Deleniti incidunt enim vero facilis quia modi doloremque, odio impedit explicabo repudiandae necessitatibus ea earum quibusdam ex pariatur aperiam dolor sequi doloribus!</p>
            <h1 style="color: blue">{{$user}}</h1>
    
    @else 

            <h1>ผู้ใช้ท่านนี้ไม่ได้เป็นแอดมิน</h1>

    @endif


</body>
</html>