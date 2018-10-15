<?php

namespace App\Http\Controllers\AdminCP;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\NhanVien;
use App\Http\Requests\DemoRequest;
use Illuminate\Support\Facades\Input;
use Auth;
use DateTime;
use File;
use DB;

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
        $magioithieu = ($user->magioithieu); 
        $nguoigioithieu = NhanVien::select('manhanvien','tennhanvien')->where('id',$magioithieu)->first();
        return view('back.profile.index',compact('template', 'user','nguoigioithieu'));
    }

    public function update($id){
        $kiemtra = NhanVien::select('solanchinhsua')->where('id',$id)->first();
        if($kiemtra->solanchinhsua >= 2){
            echo '<script type="text/javascript">
                alert("Xin lỗi, bạn chỉ có thể thay đổi thông tin tối đa 2 lần!");
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
            $profile_update = NhanVien::select('id','tennhanvien','email','sodidong','cmnd','diachi','hinhanh')->where('id', $id)->get();
            return view('back.profile.update',compact('template','profile_update','kiemtra'));
        }
    }
    
    public function action(Request $request, $id){
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
}
