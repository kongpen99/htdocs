@extends('master')

@section('meta')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name ="keyword" content = "HTML,CSS,JS,Laravel">
    <meta name = "author" content = "Tossapon Kongpeng">
    <title>Welcome to index page</title>

@endsection

@section('content')
<h1>Hello,{{ $name}}</h1>
<p>this is my body content.</p>

@for ($i = 0; $i <10; $i++)
 the dcurr2enet value is {{ $i }} <br/>

 @endfor

@endsection

