<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;


//การสร้าง Route

Route::get('/ ', function(){
    return view('welcome');

})->name('home');

//การสร้าง Route
Route::get('/about',[AboutController::class,'index'])->name('about')->middleware('check');

//การสร้าง Route
Route::get('/member', [MemberController::class,'index']);

//การสร้าง Route
// Route::get('/admin', [AdminController::class,'index'])->name('admin')->middleware('check');
// // 
//การสร้าง Route
Route::get('/admin', function(){
    return view('admin.index');
});