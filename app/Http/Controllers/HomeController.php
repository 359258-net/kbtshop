<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\QueryException;
use Illuminate\Http\Client\ConnectionException;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $packs = \App\Models\pack::select('packs.id', 'packs.donhang', 'packs.status','packs.created_at','packs.updated_at','cctvs.address','cctvs.user','cctvs.pass')
                                ->join('licenses','licenses.id','license_id')
                                ->join('cctvs','cctvs.id','licenses.cctv_id')
                                ->whereDate('packs.created_at', Carbon::today())->get();
        $data = [
            'devices'=>\App\Models\license::count(),
            'cameras'=>\App\Models\cctv::count() . '/' . \App\Models\cctv::sum('channels'),
            'packs'=>$packs->count().'/'.\App\Models\pack::count(),
        ];
        //dd($packs);
        return view('main',['data'=>$data,'packs'=>$packs]);
    }
    public function scan()
    {
        $scans = \App\Models\license::get();//whereDate('created_at', Carbon::today())->get();
        $cameras = \App\Models\cctv::get();
        return view('scan',['scans'=>$scans,'cameras'=>$cameras]);
    }
    public function neweditscan(Request $request)
    {
        $validated = $request->validate([
            'txtID' => 'required|max:64',
            'txtTen' => 'required|max:32',
            'txtCamera' => 'required|numeric',
            'txtChannel' => 'required|numeric',
            'txtLicense' => 'required',
        ]);
        try{
            $license = \App\Models\license::updateOrCreate(
                ['id'=>$request->txtID],
                [
                    //'id'=>$request->txtID,
                    'name'=>$request->txtTen,
                    'cctv_id'=>$request->txtCamera,
                    'channel'=>$request->txtChannel,
                    'lic'=>$request->txtLicense
                ]
        );//dd($license);
        }catch(QueryException $e){
            return \Redirect::back()->with("error", "Có lỗi, không thể thêm! ".implode(" ",$e->errorInfo));
        }
        return \Redirect::back()->with("status", "Đã thêm điểm đóng hàng thành công");
    }
    public function camera()
    {
        $cameras = \App\Models\cctv::get();
        return view('camera',['cameras'=>$cameras]);
    }
    public function neweditcamera(Request $request)
    {
        
        if($request->txtID > 0){
            $validated = $request->validate([
                'txtID' => 'required',
                'txtName' => 'required|max:32',
                'txtIP' => 'required|max:64',
                'txtUser' => 'required|max:32',
                'txtSN' => 'required|max:15',
                'txtChannels' => 'required|numeric'
            ]);
            try{
                if(!empty($request->txtPass))
                {
                    $cameras = \App\Models\cctv::where('id',$request->txtID)->update([
                        'name'=>$request->txtName,
                        'address'=>$request->txtIP,
                        'user'=>$request->txtUser,
                        'pass'=>$request->txtPass,
                        'sn'=>$request->txtSN,
                        'channels'=>$request->txtChannels
                    ]);
                }
                $cameras = \App\Models\cctv::where('id',$request->txtID)->update([
                    'name'=>$request->txtName,
                    'address'=>$request->txtIP,
                    'user'=>$request->txtUser,
                    'sn'=>$request->txtSN,
                    'channels'=>$request->txtChannels
                ]);
            }catch(QueryException $e){
                return \Redirect::back()->with("error", "Có lỗi, không thể thêm! ".implode(" ",$e->errorInfo));
            }
            return \Redirect::back()->with("status", "Đã cập nhật thông tin thành công");
        }
        $validated = $request->validate([
            'txtID' => 'required',
            'txtName' => 'required|max:32',
            'txtIP' => 'required|max:64',
            'txtUser' => 'required|max:32',
            'txtPass' => 'required|max:32',
            'txtSN' => 'required|max:15',
            'txtChannels' => 'required|numeric'
        ]);
        try{
            $response = Http::withDigestAuth($request->txtUser, $request->txtPass)->get('http://'.$request->txtIP.'/cgi-bin/magicBox.cgi?action=getSerialNo');
        }catch(ConnectionException $e){
            $sn = $request->txtSN;
        }
        if(!isset($response)){
            $cameras = \App\Models\cctv::create([
                'name'=>$request->txtName,
                'address'=>$request->txtIP,
                'user'=>$request->txtUser,
                'pass'=>$request->txtPass,
                'sn'=>$sn,
                'channels'=>$request->txtChannels
            ]);
            return \Redirect::back()->with("error", "Không thể kết nối CCTV nhưng đã thêm hệ thống camera thành công");
        }
        if(!$response->ok())
        {
            try{
                $response = Http::withBasicAuth($request->txtUser, $request->txtPass)->get('http://'.$request->txtIP.'/cgi-bin/magicBox.cgi?action=getSerialNo');
            }catch(ConnectionException $e){
                $sn = $request->txtSN;
            }
            if(!$response->ok())
            {
                $sn = $request->txtSN;
            }
        }
        $sn = isset($sn)?$sn:preg_replace('/(\v|\s)+/', '', str_replace("sn=","",$response->body()));
        try{
            $cameras = \App\Models\cctv::create([
                'name'=>$request->txtName,
                'address'=>$request->txtIP,
                'user'=>$request->txtUser,
                'pass'=>$request->txtPass,
                'sn'=>$sn,
                'channels'=>$request->txtChannels
            ]);
        }catch(QueryException $e){
            return \Redirect::back()->with("error", "Có lỗi, không thể thêm! ".implode(" ",$e->errorInfo));
        }
        return \Redirect::back()->with("status", "Đã thêm hệ thống camera thành công");
        
    }
}
