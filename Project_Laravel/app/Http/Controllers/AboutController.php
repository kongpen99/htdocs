<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller

{
  function index(){
    $address = "123 เชียงใหม่,ประเทศไทย";
    $tel = "099-123456789";
    $email = "kongpeng99@gmail.com";


      //การส่งตัวแปรแบบ Arry
    //return view('about',['address' => $address, 'tel' => $tel, 'email' => $email]);

    //การส่งตัวแปรแบบ Compact
    // return view('about',compact('address','tel','email'));


  //การส่งตัวแปรแบบ with
    return view('about')
    ->with('address','@address')
    ->with('tel','@tel')
    ->with('email','@email')
    ->with('error','404 Not Found หาข้อมูลไม่เจอ')
    ->with('status',"บันทึกข้อมูลเรียบร้อยแล้วครับ");

    
  }
}
