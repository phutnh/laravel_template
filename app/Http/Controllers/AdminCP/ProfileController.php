<?php

namespace App\Http\Controllers\AdminCP;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\NhanVien;
use App\Models\ThamSo;
use App\Http\Requests\DemoRequest;
use Illuminate\Support\Facades\Input;
use Auth;
use DateTime;
use File;
use DB;
use Hash;

class ProfileController extends Controller
{   
    protected $template ='';
    public function __construct()
    {
      $this->template['title'] = 'Thông tin cá nhân';
      $this->template['title-breadcrumb'] = 'Thông tin cá nhân';
    }
    
    public function view()
    {
        $template = $this->template;
        $template['form-datatable'] = true;
        $template['breadcrumbs'] = [
            [
                'name' => 'Thông tin cá nhân',
                'link' => '',
                'active' => true
            ],
        ];
        $user = Auth::user();
        $id = $user->id;
        if($user->parent_id != null){
            $magioithieu = ($user->parent_id);
            $nguoigioithieu = NhanVien::select('manhanvien','tennhanvien')->where('id',$magioithieu)->first();
        }
        // Hàm đệ qui
        $quanhe = NhanVien::select('id','parent_id','tennhanvien','manhanvien')->get()->toArray();
        // End
        return view('back.profile.index',compact('template','user','nguoigioithieu','quanhe'));
    }

    public function update(){
        $user = Auth::user();
        $id = $user->id;
        $solan = ThamSo::select('giatrithamso')->where('id',4)->first();
        $kiemtra = NhanVien::select('solanchinhsua','phanquyen')->where('id',$id)->first();
        if($kiemtra->solanchinhsua >= $solan->giatrithamso && $kiemtra->phanquyen != 1){
            echo '<script type="text/javascript">
                alert("Xin lỗi, số lần thay đổi thông tin của bạn đã vượt giới hạn cho phép!");
                window.location ="';
                echo route('user.profile.view');
                echo '"
            </script>';
        }
        else {
            $template = $this->template;
            $template['form-datatable'] = true;
            $template['breadcrumbs'] = [
                [
                    'name' => 'Thông tin cá nhân',
                    'link' => route('user.profile.view'),
                    'active' => false
                ],
                [
                    'name' => 'Chỉnh sửa',
                    'link' => '',
                    'active' => true
                ],
            ];
            $profile_update = NhanVien::select('id','tennhanvien','email','sodidong','cmnd','diachi','hinhanh','solanchinhsua')->where('id', $id)->get();
            return view('back.profile.update',compact('template','profile_update','kiemtra', 'solan'));
        }
    }
    
    public function action(Request $request){
        $this->validate($request,[
            'txthinhanh'        => 'mimes:jpeg,jpg,png',
            'txttennhanvien'    => 'required',
            'txtemail'          => 'required|max:100',
            'txtphone'          => 'required|min:10|max:11',
            'txtcmnd'           => 'required|min:9|max:12',
            'txtaddress'        => 'required|max:100'
        ],
        [
            'txthinhanh.mimes'          => 'Hình ảnh không đúng định dạng',
            'txttennhanvien.required'   => 'Vui lòng tên nhân viên',
            'txtemail.required'         => 'Vui lòng nhập email',
            'txtemail.max'              => 'Email không được vượt quá 100 ký tự',
            'txtphone.required'         => 'Vui lòng nhập số điện thoại',
            'txtphone.min'              => 'Số điện thoại từ 10 đến 11 số',
            'txtphone.max'              => 'Số điện thoại từ 10 đến 11 số',
            'txtcmnd.required'          => 'Vui lòng nhập số chứng minh nhân dân',
            'txtcmnd.min'               => 'Số chứng minh nhân dân chỉ từ 9 đến 12 chữ số',
            'txtcmnd.max'               => 'Số chứng minh nhân dân chỉ từ 9 đến 12 chữ số',
            'txtaddress.required'       => 'Vui lòng nhập địa chỉ',
            'txtaddress.required'       => 'Địa chỉ không được vượt quá 100 ký tự',
        ]);
        
        $user = Auth::user();
        $id = $user->id;
        $solanhientai = NhanVien::select('solanchinhsua')->where('id', $id)->first();
        $solanupdate  = $solanhientai->solanchinhsua + 1;
        DB::table('nhanvien')->where('id', $id)->update(['solanchinhsua'=> $solanupdate]);
        
        $nhanvien = NhanVien::find($id);
        $nhanvien -> tennhanvien = $request->txttennhanvien;
        $nhanvien -> email = $request->txtemail;
        $nhanvien -> sodidong = $request->txtphone;
        $nhanvien -> cmnd = $request->txtcmnd;
        $nhanvien -> diachi = $request->txtaddress;
        $nhanvien -> updated_at = new DateTime();
        
        $file_hinh = Input::file('txthinhanh'); 
        
        if(isset($file_hinh)){
            $file_hinh = $request->file('txthinhanh')->getClientOriginalName();
            File::delete('uploads/profile/'.$nhanvien->hinhanh);
            $nhanvien -> hinhanh = time()."_".$file_hinh;
            $request->file('txthinhanh')->move(public_path('uploads/profile'),time()."_".$file_hinh);
        }
        
        $nhanvien -> save();
        session()->flash('success','Bạn đã cập nhật thành công thông tin cá nhân !');
        return redirect()->route('user.profile.view');
        
    }
    
    public function repass()
    {
        $template = $this->template;
        $template['form-datatable'] = true;
        $template = $this->template;
        $template['form-datatable'] = true;
        $template['breadcrumbs'] = [
            [
                'name' => 'Thông tin cá nhân',
                'link' => route('user.profile.view'),
                'active' => false
            ],
            [
                'name' => 'Đổi mật khẩu',
                'link' => '',
                'active' => true
            ],
        ];
        $user = Auth::user();
        return view('back.profile.repass',compact('template', 'user'));
    }
    
    public function repassaction(Request $request){
        $this->validate($request,[
            'txtpass'		                => 'required|min:6|max:20',
            'txtrepass'		                => 'required|min:6|max:20',
    		'txtconfirmrepass'		        => 'same:txtrepass',
        ],
        [
            'txtpass.required'          => 'Vui lòng nhập mật khẩu của bạn',
            'txtpass.min'               => 'Mật khẩu chỉ từ 6 đến 20 ký tự',
            'txtpass.max'               => 'Mật khẩu chỉ từ 6 đến 20 ký tự',
            'txtrepass.required'        => 'Vui lòng nhập mật khẩu mới của bạn',
            'txtrepass.min'             => 'Mật khẩu chỉ từ 6 đến 20 ký tự',
            'txtrepass.max'             => 'Mật khẩu chỉ từ 6 đến 20 ký tự',
            'txtconfirmrepass.same'     => 'Mật khẩu nhập lại không đúng',
        ]);
        
        $user = Auth::user();
        $id = $user->id;
        $user = NhanVien::find(Auth::user()->id);
        if(Hash::check(Input::get('txtpass'), $user['password']) && Input::get('txtrepass') == Input::get('txtconfirmrepass')){
            $user = NhanVien::find($id);
            $user->password = Hash::make($request->txtrepass);
            $user->updated_at = new DateTime();
            $user -> save();
            session()->flash('success','Bạn đã thay đổi thành công mật khẩu !');
            return redirect()->route('user.profile.view');
        }
        else{
            session()->flash('danger','Mật khẩu không đúng !');
            return redirect()->route('user.profile.repass');
        }
        
        
    }
}
