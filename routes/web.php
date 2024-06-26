<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Auth::routes();
Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
  ]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/scan', [App\Http\Controllers\HomeController::class, 'scan'])->name('scan');
Route::post('/scan', [App\Http\Controllers\HomeController::class, 'neweditscan'])->name('scan2');
Route::get('/camera', [App\Http\Controllers\HomeController::class, 'camera'])->name('camera');
Route::post('/camera', [App\Http\Controllers\HomeController::class, 'neweditcamera'])->name('camera2');
Route::post('/changepass', function (Request $request) {
  $validated = $request->validate([
      'txtOldPass' => 'required|max:32',
      'password' => 'required|confirmed|min:6|max:32',
  ]);
  if(!Hash::check($request->txtOldPass, Auth::user()->password)){
    return Redirect::back()->with("error", "Old Password Doesn't match!");
  }
  #Update the new Password
  \App\Models\User::whereId(auth()->user()->id)->update([
    'password' => Hash::make($request->password)
  ]);
  return Redirect::back()->with("status", "Thay đổi mật khẩu thành công");
})->name('changepass');
Route::get('/qr/{id}', function ($id) {
  $ten = \App\Models\license::where('id',$id)->first();
  $ten = $ten!=null?$ten->name:"";
  return view('qrlogin',['id'=>$id,'ten'=>$ten]);
})->name('inqr');