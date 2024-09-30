<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>เกี่ยวกับเรา</title>
</head>

<body>
    
        <h1>เกี่ยวกับผู้พัฒนาเว็บไซต์ Basic</h1>
        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Temporibus sed expedita ratione numquam quasi at voluptas, sapiente assumenda dicta unde praesentium! Provident perferendis mollitia quas aut reiciendis, modi ad soluta?</p>
        
        <p>ที่อยู่ :{{$address}}</p>
        <p>เบอร์ติดต่อ : {{$tel}}</p>
        <p>อีเมลล์ : {{$email}}</p>
        <p>{{$error}}</p>
        <p>{{$status}}</p>



        <a href="{{url('/')}}">Home</a>
        <a href="{{url('/admin')}}">Admin</a>
        <a href="{{url('/member')}}">Member</a>
        <a href="{{url('/about')}}">About</a>


</body>
</html>