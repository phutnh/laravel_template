<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Models\NhanVien;
use Illuminate\Http\Request;
use Hash;
use DateTime;
use File;


class RegisterController extends Controller
{
  use RegistersUsers;
 
  protected $redirectTo = '/home';

  public function __construct()
  {
      $this->middleware('guest');
  }

  public function showRegistrationForm(Request $request)
  {
      // return view('front.auth.register');
      // TinhNT11 update
      $ref = $request->ref;
      if($ref != null){
        $nguoigioithieu = NhanVien::select('id','tennhanvien','manhanvien','trangthai')->where('magioithieu', $ref)->first();
        $trangthai = $nguoigioithieu->trangthai;
        if($trangthai == 0){
          return view('auth.noregister');
        }
        else{
          return view('auth.register',compact('nguoigioithieu'));
        }
      }
      else {
        return view('auth.register');
      }
  }

  protected function validator(array $request)
  {
    return Validator::make($request,
  		[
    		'txtname' 		      => 'required',
    		'txtimage' 		      => 'required|mimes:jpeg,jpg,png',
    		'txtaccount' 	      => 'required|unique:nhanvien,taikhoan',
    		'txtpass'		        => 'required|min:6|max:20',
    		'txtrepass'		      => 'same:txtpass',
    		'txtemail' 		      => 'required|email|unique:nhanvien,email',
    		'txtcmnd'	          => 'required|min:9|max:12|unique:nhanvien,cmnd',
    		'txtphone'	        => 'required|unique:nhanvien,sodidong',
    		'txtgender'	        => 'required',
    		'txtday'	          => 'required',
    		'txtaddress'	      => 'required|max:100',
    		'txtnumberbank'	    => 'required|unique:nhanvien,sotaikhoan',
    		'txtnamebank1'	    => 'required',
    		'txtnamebank2'	    => 'required',
    		
			],
			[
				'txtname.required' 	  	  => 		'Vui lòng nhập họ tên',
				'txtimage.required' 	    =>		'Vui lòng chọn hình ảnh đại diện của bạn',
				'txtimage.unique' 	      =>		'File hình ảnh không đúng định dạng',
				'txtaccount.required' 	  =>		'Vui lòng nhập tên tài khoản đăng ký',
				'txtaccount.unique' 	    =>		'Tên tài khoản đăng ký đã tồn tại',
				'txtpass.required' 	      =>		'Vui lòng nhập mật khẩu',
				'txtpass.min' 	          =>		'Mật khẩu phải từ 6 đến 20 ký tự',
				'txtpass.max' 	          =>		'Mật khẩu phải từ 6 đến 20 ký tự',
				'txtrepass.same' 	        =>		'Mật khẩu nhập lại không đúng',
				'txtemail.required' 	    =>		'Vui lòng nhập email',
				'txtemail.email' 	        =>		'Email không đúng định dạng',
				'txtemail.unique' 	      =>		'Email đã tồn tại',
				'txtcmnd.required' 	      =>		'Vui lòng nhập số chứng minh nhân dân',
				'txtcmnd.unique' 	        =>		'Số chứng minh nhân dân đã tồn tại',
				'txtcmnd.min' 	          =>		'Số chứng minh nhân dân từ 9 đến 12 chữ số',
				'txtcmnd.max' 	          =>		'Số chứng minh nhân dân từ 9 đến 12 chữ số',
				'txtphone.required' 	    =>		'Vui lòng nhập số điện thoại',
				'txtphone.unique' 	      =>		'Số điện thoại đã tồn tại',
				'txtgender.required' 	    =>		'Vui lòng chọn giới tính',
				'txtgender.required' 	    =>		'Vui lòng chọn giới tính',
				'txtday.required' 	      =>		'Vui lòng chọn ngày tháng năm sinh',
				'txtaddress.required' 	  =>		'Vui lòng nhập địa chỉ',
				'txtaddress.max' 	        =>		'Đia chỉ không được vượt quá 100 ký tự',
				'txtnumberbank.required' 	=>		'Vui lòng nhập số tài khoản ngân hàng',
				'txtnumberbank.unique' 	  =>		'Số tài khoản ngân hàng đã tồn tại',
				'txtnamebank1.required' 	=>		'Vui lòng nhập tên ngân hàng',
				'txtnamebank2.required' 	=>		'Vui lòng nhập tên chi nhánh ngân hàng',
			]);
  }

  protected function create(Request $request)
  {
    $nhanvien = new NhanVien();
    $nhanvien->tennhanvien = $request->txtname;
    
    $file_hinh = $request->file('txtimage')->getClientOriginalName();
    $nhanvien->hinhanh = time()."_".$file_hinh;
        $request->file('txtimage')->move(public_path('uploads/profile'),time()."_".$file_hinh);
    $nhanvien->taikhoan = $request->txtaccount;
    $nhanvien->password = Hash::make($request->txtpass);
    $nhanvien->email = $request->txtemail;
    $nhanvien->cmnd = $request->txtcmnd;
    $nhanvien->magioithieu = uniqid();
    $nhanvien->phanquyen = 0;
    $nhanvien->solanchinhsua = 0;
    $nhanvien->sodidong = $request->txtphone;
    $nhanvien->gioitinh = $request->txtgender;
    $nhanvien->namsinh = $request->txtday;
    $nhanvien->diachi = $request->txtaddress;
    $nhanvien->sotaikhoan = $request->txtnumberbank;
    $nhanvien->tennganhang = $request->txtnamebank1;
    $nhanvien->chinhanh = $request->txtnamebank2;
    $nhanvien->created_at = new DateTime();
    $nhanvien->updated_at = new DateTime();
    $nhanvien->parent_id = $request->nguoigioithieuban;
    
    $nhanvien -> save();
    $nhanvien-> manhanvien = renderMaNV($nhanvien->id);
    $nhanvien -> save();
    session()->flash('success','Bạn đã đăng ký thành công !');
    return redirect()->route('user.register.index');
  }
}
