<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\license;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/{id}', function ($id) {
    $lic = license::with('cctv')->where('id',$id)->first();
    $data = [
        'id' => $lic->id,
        'name' => $lic->name,
        'host' => env("APPBASE_URL"),
        'SN' => $lic->cctv->sn,
        'cctv' => $lic->cctv->name,
        'channel' => $lic->channel,
        'license' => $lic->lic,
    ];
    return $data;
});
Route::get('/packing/{id}/{donhang}', function ($id,$donhang) {
    $data = \App\Models\pack::create([
        'donhang'=>$donhang,
        'status'=>1,
        'license_id'=>$id
    ]);
    return $data;
});
Route::get('/packed/{id}', function (Request $request, $id) {
    $data = \App\Models\pack::where('id',$id)
    ->update([
        'status'=>0
    ]);
    return $data;
});
Route::get('/gpack/{id}/{datetime}', function ($id,$datetime) {
//Route::get('/gpack/{id}', function ($id) {
    $data = \App\Models\pack::where('license_id',$id)->whereDate('created_at',\Carbon\Carbon::parse($datetime))->get();
    //$data = \App\Models\pack::where('license_id',$id)->whereDate('created_at',\Carbon\Carbon::now())->get();
    return $data;
});
Route::get('/cpack/{id}/{datetime}', function ($id,$datetime) {
    $xong = \App\Models\pack::where('license_id',$id)->whereDate('created_at',\Carbon\Carbon::parse($datetime))->where('status',0)->count();
    $huy = \App\Models\pack::where('license_id',$id)->whereDate('created_at',\Carbon\Carbon::parse($datetime))->where('status',1)->count();
    $data=[
        'xong'=>$xong,
        'huy'=>$huy
    ];
    return $data;
});