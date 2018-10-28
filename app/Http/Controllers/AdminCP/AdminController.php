<?php

namespace App\Http\Controllers\AdminCP;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\DemoRequest;
use Illuminate\Support\Facades\Input;
use App\Models\NhanVien;
use DB;
use Auth;
use DateTime;
use File;
use Hash;
use App\Repositories\Repository\HopDongRepository;
use App\Repositories\Repository\NhanVienRepository;
use App\Repositories\Repository\HoaHongRepository;

class AdminController extends Controller
{
  protected $hopDongRepository = '';
  protected $nhanVienRepository = '';
  protected $hoaHongRepository = '';
  
  public function __construct(HopDongRepository $hopDongRepository, NhanVienRepository $nhanVienRepository, HoaHongRepository $hoaHongRepository)
  {
    $this->hopDongRepository = $hopDongRepository;
    $this->nhanVienRepository = $nhanVienRepository;
    $this->hoaHongRepository = $hoaHongRepository;
  }
  
  public function dashboard()
  {
    $template['title'] = 'Quản lý';
    $template['title-breadcrumb'] = 'Quản lý';
    $template['breadcrumbs'] = [
      [
        'name' => 'Quản lý',
        'link' => '',
        'active' => true
      ],
    ];

    $data['soluongnhanvien'] = $this->nhanVienRepository
      ->query()->count();
    $danhSachHopDong = $this->hopDongRepository
      ->query()->where('trangthai', 'Đã duyệt');
    if (getQuyenNhanVien() != 1)
      $danhSachHopDong->where('nhanvien_id', getNhanVienID());
    
    $danhSachHopDong->whereDate('created_at', '>=', getFristDayOfMonth());
    $danhSachHopDong->whereDate('created_at', '<=', getLastDayOfMonth());

    $data['danhsachhopdong'] = $danhSachHopDong->get();

    $queryHopDong = $this->hopDongRepository
      ->query()->where('deleted', 0);
    if (!isAdminCP())
      $queryHopDong->where('nhanvien_id', getNhanVienID());

    $data['soluonghopdong'] =  $queryHopDong->count();
    // dd($this->hopDongRepository->bieuDoHopDong('p'));

    return view('back.index', compact('template', 'data'));
  }

  public function markAsReadNotifications(Request $request)
  {
    foreach (Auth::user()->unreadNotifications as $notification) {
      $notification->markAsRead();
    }
    return responseFormData('Đánh dấu đã đọc thành công');
  }

  public function getNotifications()
  {
    $template['title'] = 'Quản lý thông báo';
    $template['title-breadcrumb'] = 'Quản lý thông báo';
    $template['breadcrumbs'] = [
      [
        'name' => 'Quản lý thông báo',
        'link' => '',
        'active' => true
      ],
    ];

    $notifications = Auth::user()->notifications;
    return view('back.nhanvien.notifications', compact('template', 'notifications'));
  }
  
   public function lstQLNS(){
    //$lstNS = DB::table('nhanvien')->get();
    //return view('nhanvien.qlynhansu')->with('data', $lstNS);
    
    
    $template['title'] = 'Quản lý';
    $template['title-breadcrumb'] = '';
    $template['breadcrumbs'] = [
      [
        'name' => 'Quản lý nhân sự',
        'link' => '',
        'active' => true
      ]
    ];
    
    $ma_quyen = getQuyenNhanVien();
    $nv_id = getNhanVienID();
    if($ma_quyen != 1){
      //return redirect()->route('admin.dashboard');
      $template['users'] = DB::select('select *, IF((ADDTIME(created_at, (select concat(giatrithamso,":00:00") from thamso where id = 3)) < NOW()) and trangthai = 0, "Hết hạn", "") as stt, IF(trangthai = 0, "Chưa duyệt", IF(trangthai=1, "Đã duyệt", "Đã nghĩ")) as trangthai from nhanvien where trangthai in (0,1) and parent_id = '.$nv_id);
    }
    else {
      $template['users'] = DB::select('select *, IF((ADDTIME(created_at, (select concat(giatrithamso,":00:00") from thamso where id = 3)) < NOW()) and trangthai = 0, "Hết hạn", "") as stt, IF(trangthai = 0, "Chưa duyệt", IF(trangthai=1, "Đã duyệt", "Đã nghĩ")) as trangthai from nhanvien where trangthai in (0,1)');
    }
    
    return view('back.nhanvien.qlynhansu', compact('template'));
  }
  
  public function delAll(Request $request){
    $arrUser = $request->arrUser;
    $bSuccesss = true;
    $szMsg = "Xóa thành công các user đã chọn!!!";
    
    foreach($arrUser as $user){
      $sqlUpdate = "update nhanvien set trangthai = 2, updated_at = NOW() where id = $user";
      $result = DB::update($sqlUpdate);
      if(!$result){
        $bSuccesss = false;
        $szMsg = "Có lỗi trong quá trình cập nhật CSDL!!!";
      }
    }
    
    return response()->json(['msg'=> $szMsg, 'success' => $bSuccesss]);
  }
  
  public function transDetail(){
    $template['title'] = 'Quản lý';
    $template['title-breadcrumb'] = '';
    $template['breadcrumbs'] = [
      [
        'name' => 'Quản lý giao dịch',
        'link' => '',
        'active' => true
      ]
    ];
    
    
    $nv_id = getNhanVienID();
    // Lấy ra ds các giao dịch trong tháng
    $sql = "select ma_gd, ngayrut, ngayduyet, sotien, trangthaiduyet from giaodich ";
    $sql .= "WHERE DATE_FORMAT(ngayrut, '%Y%m') >= DATE_FORMAT(NOW(), '%Y%m') ";
    $sql .= "and DATE_FORMAT(ngayrut, '%Y%m') <= DATE_FORMAT(NOW(), '%Y%m') ";
    $sql .= "and nhanvien_id = '$nv_id' ";
    $sql .= "order by ngayrut asc";
    $template['lstTrans'] = DB::select($sql);
    
    // Lấy ra tổng hoa hồng đã rút trong tháng
    $sql = "select IFNULL(sum(sotien),0) as tien from giaodich ";
    $sql .= "WHERE DATE_FORMAT(ngayrut, '%Y%m') >= DATE_FORMAT(NOW(), '%Y%m') ";
    $sql .= "and DATE_FORMAT(ngayrut, '%Y%m') <= DATE_FORMAT(NOW(), '%Y%m') ";
    $sql .= "and trangthaiduyet = 1 ";
    $sql .= "and nhanvien_id = '$nv_id'";
    $template['tongdarut'] = formatMoneyData(collect(\DB::select($sql))->first()->tien);
    
    return view('back.nhanvien.qlyruttien', compact('template'));
  }
  
  public function getTransDetail(Request $request){
    $startTime = $request->startTime;
    $endTime = $request->endTime;
    $stt = $request->status;
    
    //Chuyển đổi định dạng ngày tháng
    $startTime = date_create($startTime);
		$startTime = date_format($startTime, 'Ymd');
		$endTime = date_create($endTime);
		$endTime = date_format($endTime, 'Ymd');
    
    $nv_id = getNhanVienID();
    // Lấy ra ds các giao dịch trong thời gian đã chọn
    $sql = "select ma_gd, ngayrut, ngayduyet, format(sotien, '#,##0') as tongtien, trangthaiduyet from giaodich ";
    $sql .= "WHERE DATE_FORMAT(ngayrut, '%Y%m%d') >= '$startTime' ";
    $sql .= "and DATE_FORMAT(ngayrut, '%Y%m%d') <= '$endTime' ";
    $sql .= "and nhanvien_id = '$nv_id' ";
    if($stt != 3){
      $sql .= "and trangthaiduyet = '$stt' ";
    }
    $sql .= "order by ngayrut asc";
    $lstTrans = DB::select($sql);
    
    // Lấy ra tổng hoa hồng đã rút
    $sql = "select IFNULL(sum(sotien),0) as tien from giaodich ";
    $sql .= "WHERE DATE_FORMAT(ngayrut, '%Y%m%d') >= '$startTime' ";
    $sql .= "and DATE_FORMAT(ngayrut, '%Y%m%d') <= '$endTime' ";
    $sql .= "and trangthaiduyet = 1 ";
    $sql .= "and nhanvien_id = '$nv_id'";
    $tongdarut = collect(\DB::select($sql))->first()->tien;
    
    
    return response()->json(['tongdarut'=> formatMoneyData($tongdarut), 'lstTrans' => $lstTrans]);
  }
  
  public function withdraw(){
    $template['title'] = 'Quản lý';
    $template['title-breadcrumb'] = '';
    $template['breadcrumbs'] = [
      [
        'name' => 'Quản lý rút tiền',
        'link' => route('admin.trans.detail'),
        'active' => false
      ],
      [
        'name' => 'Rút tiền',
        'link' => '',
        'active' => true
      ]
    ];
    
    $user = DB::table('nhanvien')->where('id', getNhanVienID())->first();
    
    // Lấy ra tổng hoa hồng đã rút
    $sql = "select IFNULL(sum(sotien),0) as tien from giaodich ";
    $sql .= "where trangthaiduyet = 0 ";
    $sql .= "and nhanvien_id = ". $user->id;
    $tongchorut = collect(\DB::select($sql))->first()->tien;
    
    // Lấy ra số dư thực tế
    $template['soduthucte'] = formatMoneyData($user->soduthucte - $tongchorut);
    
    return view('back.nhanvien.ruttien', compact('template'));
  }
  
  public function withdrawAction(Request $request){
    $sotienrut = $request->sorut;
    
    $user = DB::table('nhanvien')->where('id', getNhanVienID())->first();
    
    // Lấy ra tổng hoa hồng đã rút
    $sql = "select IFNULL(sum(sotien),0) as tien from giaodich ";
    $sql .= "where trangthaiduyet = 0 ";
    $sql .= "and nhanvien_id = ". $user->id;
    $tongchorut = collect(\DB::select($sql))->first()->tien;
    
    // Số tiền thực tế có thể rút
    $soduthucte = $user->soduthucte - $tongchorut;
    
    if($soduthucte >= $sotienrut){
      $sqlInsert = "insert into giaodich(nhanvien_id, ngayrut, sotien, trangthaiduyet) values(".$user->id.", NOW(), $sotienrut, 0)";
      $result = DB::insert($sqlInsert);
      if($result == true){
        $msg = "Bạn đã rút ". formatMoneyData($sotienrut) ." thành công! Chờ phê duyệt....";
        $soduconlai = $soduthucte - $sotienrut;
      }
      else {
        $msg = "Rút tiền không thành công! Lỗi trong quá trình insert....";
        $soduconlai = $soduthucte;
      }
    }
    else {
      $msg = "Rút tiền không thành công! Số dư của bạn không đủ....";
      $soduconlai = $soduthucte;
    }
    return response()->json(['msg'=> $msg, 'sodu' => formatMoneyData($soduconlai)]);
  }
  
  public function applytrans(){
    $template['title'] = 'Quản lý';
    $template['title-breadcrumb'] = '';
    $template['breadcrumbs'] = [
      [
        'name' => 'Quản lý phê duyệt',
        'link' => '',
        'active' => true
      ]
    ];
    
    $ma_quyen = getQuyenNhanVien();
    if($ma_quyen != 1){
      return redirect()->route('admin.dashboard');
    }
    
    // Lấy ra ds các giao dịch trong tháng
    $sql = "select a.ma_gd, a.ngayrut, a.sotien, b.tennhanvien as nguoirut from giaodich a, nhanvien b ";
    $sql .= "WHERE DATE_FORMAT(a.ngayrut, '%Y%m') >= DATE_FORMAT(NOW(), '%Y%m') ";
    $sql .= "and DATE_FORMAT(a.ngayrut, '%Y%m') <= DATE_FORMAT(NOW(), '%Y%m') ";
    $sql .= "and a.trangthaiduyet = 0 ";
    $sql .= "and b.id = a.nhanvien_id ";
    $sql .= "order by a.ngayrut asc";
    $template['lstTrans'] = DB::select($sql);
    
    return view('back.nhanvien.qlyduyettien', compact('template'));
  }
  
  public function applytransAction(Request $request){
    $ma_gd = $request->ma_gd;
    
    $ma_quyen = getQuyenNhanVien();
    $ma_nv_pheduyet = getNhanVienID();
    
    if($ma_quyen == 1){
      $sqlUpdate = "update giaodich set trangthaiduyet = 1, nguoiduyet = '$ma_nv_pheduyet', ngayduyet = NOW() where ma_gd = '$ma_gd'";
      $result = DB::update($sqlUpdate);
      
      $sqlUpdateTien = "UPDATE nhanvien a INNER JOIN giaodich b on a.id = b.nhanvien_id set soduthucte = soduthucte - b.sotien where b.ma_gd = '$ma_gd'";
      DB::update($sqlUpdateTien);
      
      if($result == true){
        $msg = "Bạn đã phê duyệt thành công!";
      }
      else {
        $msg = "Duyêt rút tiền không thành công! Lỗi trong quá trình update CSDL....";
      }
    }
    else {
      $msg = "Bạn không có quyền phê duyệt....";
    }
    return response()->json(['msg'=> $msg]);
  }
  
  public function applytransSearch(Request $request){
    $startTime = $request->startTime;
    $endTime = $request->endTime;
    
    //Chuyển đổi định dạng ngày tháng
    $startTime = date_create($startTime);
		$startTime = date_format($startTime, 'Ymd');
		$endTime = date_create($endTime);
		$endTime = date_format($endTime, 'Ymd');
    
    $ma_quyen = getQuyenNhanVien();
    if($ma_quyen != 1){
      return redirect()->route('admin.dashboard');
    }
    
    // Lấy ra ds các giao dịch trong thời gian đã chọn
    $sql = "select a.ma_gd, a.ngayrut, format(a.sotien, '#,##0') as tongtien, b.tennhanvien, '<button>DUYỆT</button>' as chucnang from giaodich a, nhanvien b ";
    $sql .= "WHERE DATE_FORMAT(a.ngayrut, '%Y%m%d') >= '$startTime' ";
    $sql .= "and DATE_FORMAT(a.ngayrut, '%Y%m%d') <= '$endTime' ";
    $sql .= "and a.nhanvien_id = b.id ";
    $sql .= "and a.trangthaiduyet = 0 ";
    $sql .= "order by a.ngayrut asc";
    $lstTrans = DB::select($sql);
    
    return response()->json(['lstTrans' => $lstTrans]);
  }
  
  public function commissionHis($user_id = null){
    $template['title'] = 'Quản lý';
    $template['title-breadcrumb'] = '';
    $nv_id = null;
    
    if($user_id != null){
      $template['breadcrumbs'] = [
        [
          'name' => 'Quản lý nhân viên',
          'link' => route('admin.qlnhansu'),
          'active' => false
        ],
        [
          'name' => 'Lịch sử hoa hồng',
          'link' => '',
          'active' => true
        ]
      ];
      
      $nv_id = $user_id;
    }
    else {
      $template['breadcrumbs'] = [
        [
          'name' => 'Quản lý lịch sử hoa hồng',
          'link' => '',
          'active' => true
        ]
      ];
      
      $nv_id = getNhanVienID();
    }
    
    $ma_quyen = getQuyenNhanVien();
    
    // Lấy ra ds các lịch sử hoa hồng trong tháng
    $sql = "SELECT a.*, b.tennhanvien, d.tenhopdong, IF(a.trangthai = 0, 'Chưa duyệt', 'Đã duyệt') as trangthaiduyet FROM hoahong a, nhanvien b, hopdong d ";
    $sql .= "WHERE a.nhanvien_id = b.id ";
    $sql .= "and a.hopdong_id = d.id ";
    $sql .= "and DATE_FORMAT(a.created_at, '%Y%m') >= DATE_FORMAT(NOW(), '%Y%m') ";
    $sql .= "and DATE_FORMAT(a.created_at, '%Y%m') <= DATE_FORMAT(NOW(), '%Y%m') ";
    
    if($user_id != null){
      $sql .= "and a.nhanvien_id = '$nv_id' ";
    }
    else {
      if($ma_quyen != 1){
        $sql .= "and a.nhanvien_id = '$nv_id' ";
      }
    }
    
    $sql .= "order by a.created_at asc";
    $template['lstTrans'] = DB::select($sql);
    
    return view('back.nhanvien.qlylichsuhoahong', compact('template', 'nv_id'));
  }
  
  public function commissionSearch(Request $request, $user_id = null){
    $startTime = $request->startTime;
    $endTime = $request->endTime;
    $loaihoahong = $request->loaihoahong;
    
    //Chuyển đổi định dạng ngày tháng
    $startTime = date_create($startTime);
		$startTime = date_format($startTime, 'Ymd');
		$endTime = date_create($endTime);
		$endTime = date_format($endTime, 'Ymd');
    
    if($user_id == null){
      $nv_id = getNhanVienID();
    }
    else {
      $nv_id = $user_id;
    }
    $ma_quyen = getQuyenNhanVien();
    
    // Lấy ra ds các lịch sử hoa hồng theo mốc thời gian
    $sql = "SELECT b.tennhanvien, a.loaihoahong, a.hopdong_id, d.tenhopdong, format(a.giatri, '#,##0') as tonghh, a.created_at, a.trangthai, IF(a.trangthai = 0, 'Chưa duyệt', 'Đã duyệt') as trangthaiduyet, '<button>DUYỆT</button>' as chucnang FROM hoahong a, nhanvien b, hopdong d ";
    $sql .= "WHERE DATE_FORMAT(a.created_at, '%Y%m%d') >= '$startTime' ";
    $sql .= "and DATE_FORMAT(a.created_at, '%Y%m%d') <= '$endTime' ";
    $sql .= "and a.nhanvien_id = b.id ";
    $sql .= "and a.hopdong_id = d.id ";
    
    if($loaihoahong != "all"){
      $sql .= "and a.loaihoahong = '$loaihoahong' ";
    }
    
    if($user_id != null){
      $sql .= "and a.nhanvien_id = '$nv_id' ";
    }
    else {
      if($ma_quyen != 1){
        $sql .= "and a.nhanvien_id = '$nv_id' ";
      }
    }
    
    $sql .= "order by a.created_at asc";
    $lstTrans = DB::select($sql);
    
    return response()->json(['lstTrans' => $lstTrans]);
  }
  
  public function commissionTree(Request $request, $user_id = null){
    $ma_hd = $request->ma_hd;
    
    if($user_id == null){
      $nv_id = getNhanVienID();
    }
    else {
      $nv_id = $user_id;
    }
    $ma_quyen = getQuyenNhanVien();
    
    // Lấy ra ds các lịch sử hoa hồng theo mốc thời gian
    $sql = "SELECT b.tennhanvien, a.loaihoahong, a.hopdong_id, d.tenhopdong, format(a.giatri, '#,##0') as tonghh, a.created_at, a.nhanvien_id FROM hoahong a, nhanvien b, hopdong d ";
    $sql .= "WHERE a.hopdong_id = '$ma_hd' ";
    $sql .= "and a.nhanvien_id = b.id ";
    $sql .= "and a.hopdong_id = d.id ";
    $sql .= "ORDER BY CHAR_LENGTH( a.cayhoahong ) ASC ";
    $lstHH = DB::select($sql);
    
    return response()->json(['lstHH' => $lstHH, 'nv_id' => $nv_id]);
  }
  
  public function viewUserDetail($user_id){
    $template['title'] = 'Quản lý';
    $template['form-datatable'] = true;
    $template['title-breadcrumb'] = '';
    $template['breadcrumbs'] = [
                [
                    'name' => 'Danh sách nhân sự',
                    'link' => route('admin.qlnhansu'),
                    'active' => false
                ],
                [
                    'name' => 'Chi tiết',
                    'link' => '',
                    'active' => true
                ],
            ];
    $ma_quyen = getQuyenNhanVien();
    if($ma_quyen != 1){
      return redirect()->route('admin.dashboard');
    }
    
    $profile_update = NhanVien::select('id','tennhanvien','email','sodidong','cmnd','diachi','hinhanh','trangthai')->where('id', $user_id)->get();
    return view('back.nhanvien.update',compact('template','profile_update'));
  }
  
  public function actionUserDetail(Request $request, $user_id){
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
    
    $ma_quyen = getQuyenNhanVien();
    if($ma_quyen != 1){
      return redirect()->route('admin.dashboard');
    }
    
    $nhanvien = NhanVien::find($user_id);
    $nhanvien -> tennhanvien = $request->txttennhanvien;
    $nhanvien -> email = $request->txtemail;
    $nhanvien -> sodidong = $request->txtphone;
    $nhanvien -> cmnd = $request->txtcmnd;
    $nhanvien -> diachi = $request->txtaddress;
    $nhanvien -> updated_at = new DateTime();
    $nhanvien -> trangthai = $request->opTrangthai;
     
    $file_hinh = Input::file('txthinhanh'); 
    
    if(isset($file_hinh)){
            $file_hinh = $request->file('txthinhanh')->getClientOriginalName();
            File::delete('uploads/profile/'.$nhanvien->hinhanh);
            $nhanvien -> hinhanh = time()."_".$file_hinh;
            $request->file('txthinhanh')->move(public_path('uploads/profile'),time()."_".$file_hinh);
    }
    
    $nhanvien -> save();
    session()->flash('success','Bạn đã cập nhật thành công thông tin cá nhân :' . $nhanvien -> tennhanvien);
    return redirect()->route('admin.qlnhansu');
  }
  
  public function viewCreateUser(){
    $template['title'] = 'Quản lý';
    $template['form-datatable'] = true;
    $template['title-breadcrumb'] = '';
    $template['breadcrumbs'] = [
                [
                    'name' => 'Danh sách nhân sự',
                    'link' => route('admin.qlnhansu'),
                    'active' => false
                ],
                [
                    'name' => 'Tạo user',
                    'link' => '',
                    'active' => true
                ],
            ];
    $template['magioithieu'] = "";
    $ma_quyen = getQuyenNhanVien();
    $nv_id = getNhanVienID();
    
    if($ma_quyen != 1){
      //return redirect()->route('admin.dashboard');
      $sqlGetParent = "select * from nhanvien where id = '$nv_id'";  
      $mgt = collect(\DB::select($sqlGetParent))->first()->magioithieu;
      $template['magioithieu'] = $mgt;
    }
    
    return view('back.nhanvien.dangkyuser',compact('template'));
  }
  
  public function createAction(Request $request){
    $this->validate($request,[
            'txthinhanh'        => 'mimes:jpeg,jpg,png',
            'txttennhanvien'    => 'required',
            'txtaccount'        => 'required',
            'txtpass'           => 'required',
            'txtday'            => 'required',
            'txtemail'          => 'required|max:100',
            'txtphone'          => 'required|min:10|max:11',
            'txtcmnd'           => 'required|min:9|max:12',
            'txtaddress'        => 'required|max:100'
        ],
        [
            'txthinhanh.mimes'          => 'Hình ảnh không đúng định dạng',
            'txttennhanvien.required'   => 'Vui lòng nhập tên nhân viên',
            'txtaccount.required'       => 'Vui lòng nhập account',
            'txtpass.required'          => 'Vui lòng nhập mật khẩu',
            'txtday.required'           => 'Vui lòng chọn ngày sinh',
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
    
    $parent_id = "";
    $magt = $request->txtmagioithieu;
    if($magt != ""){
      $sqlGetParent = "select * from nhanvien where magioithieu = '$magt'";  
      $parent_id = collect(\DB::select($sqlGetParent))->first()->id;
    }
    
    $tk = $request->txtaccount;
    $sqlGetTK = "select * from nhanvien where taikhoan = '$tk'";  
    $numrow = DB::select($sqlGetTK);
    if(count($numrow) > 0){
      session()->flash('status','Username đã tồn tại, vui lòng chọn username khác !');
      return redirect()->route('admin.qlnhansu.create');
    }
    
    $socmnd = $request->txtcmnd;
    $sqlGetCMND = "select * from nhanvien where cmnd = '$socmnd'";  
    $numrow2 = DB::select($sqlGetCMND);
    if(count($numrow2) > 0){
      session()->flash('status','CMND đã tồn tại, vui lòng chọn CMND khác !');
      return redirect()->route('admin.qlnhansu.create');
    }
    
    $sotkbank = $request->txtnumberbank;
    $sqlGetSoTK = "select * from nhanvien where sotaikhoan = '$sotkbank'";  
    $numrow3 = DB::select($sqlGetSoTK);
    if(count($numrow3) > 0){
      session()->flash('status','Tài khoản ngân hàng đã tồn tại, vui lòng chọn tài khoản khác !');
      return redirect()->route('admin.qlnhansu.create');
    }
    
    $nhanvien = new NhanVien();
    $nhanvien -> tennhanvien = $request->txttennhanvien;
    $nhanvien -> email = $request->txtemail;
    $nhanvien -> sodidong = $request->txtphone;
    $nhanvien -> cmnd = $request->txtcmnd;
    $nhanvien -> diachi = $request->txtaddress;
    $nhanvien -> created_at = new DateTime();
    $nhanvien -> updated_at = new DateTime();
    $nhanvien -> trangthai = $request->opTrangthai;
    $nhanvien -> phanquyen = 0;
    $nhanvien -> solanchinhsua = 0;
    $nhanvien -> gioitinh = $request->opGioiTinh;
    $nhanvien -> taikhoan = $request->txtaccount;
    $nhanvien -> password = Hash::make($request->txtpass);
    $nhanvien -> sotaikhoan = $request->txtnumberbank;
    $nhanvien -> tennganhang = $request->txtnamebank1;
    $nhanvien -> chinhanh = $request->txtnamebank2;
    $nhanvien -> namsinh = $request->txtday;
    $nhanvien -> parent_id = $parent_id;
    $nhanvien -> magioithieu = uniqid();
     
    $file_hinh = Input::file('txthinhanh'); 
    
    if(isset($file_hinh)){
            $file_hinh = $request->file('txthinhanh')->getClientOriginalName();
            File::delete('uploads/profile/'.$nhanvien->hinhanh);
            $nhanvien -> hinhanh = time()."_".$file_hinh;
            $request->file('txthinhanh')->move(public_path('uploads/profile'),time()."_".$file_hinh);
    }
    
    $nhanvien -> save();
    
    $nhanvien -> manhanvien = renderMaNV($nhanvien->id);
    $nhanvien -> save();
    
    session()->flash('status','Bạn đã đăng ký thành công !');
    return redirect()->route('admin.qlnhansu.create');
  }
  
  public function lstContract($user_id){
    $template['title'] = 'Quản lý';
    $template['form-datatable'] = true;
    $template['title-breadcrumb'] = '';
    $template['breadcrumbs'] = [
                [
                    'name' => 'Danh sách nhân sự',
                    'link' => route('admin.qlnhansu'),
                    'active' => false
                ],
                [
                    'name' => 'Xem hợp đồng',
                    'link' => '',
                    'active' => true
                ],
            ];
            
    $nv_id = getNhanVienID();
    $ma_quyen = getQuyenNhanVien();
    $userViewed = $user_id;
    // Lấy ra ds các lịch sử hoa hồng trong tháng
    $sql = "SELECT a.*, b.tennhanvien FROM hopdong a, nhanvien b ";
    $sql .= "WHERE a.nhanvien_id = b.id ";
    $sql .= "and DATE_FORMAT(a.created_at, '%Y%m') >= DATE_FORMAT(NOW(), '%Y%m') ";
    $sql .= "and DATE_FORMAT(a.created_at, '%Y%m') <= DATE_FORMAT(NOW(), '%Y%m') ";
    $sql .= "and a.deleted = 0 ";
    
    if($ma_quyen == 1){
        $sql .= "and a.nhanvien_id = '$user_id' ";
    }
    else {
      $sql .= "and a.nhanvien_id = '$user_id' ";
      $sql .= "and b.parent_id = '$nv_id' ";
    }
    
    $sql .= "order by a.created_at desc";
    $template['sql'] = $sql;
    $template['lstContract'] = DB::select($sql);
    
    return view('back.nhanvien.qlylichsuhopdong', compact('template', 'userViewed'));
  }
  
  public function contractSearch(Request $request, $user_id){
    $startTime = $request->startTime;
    $endTime = $request->endTime;
    
    $template['title'] = 'Quản lý';
    $template['form-datatable'] = true;
    $template['title-breadcrumb'] = '';
    $template['breadcrumbs'] = [
                [
                    'name' => 'Danh sách nhân sự',
                    'link' => route('admin.qlnhansu'),
                    'active' => false
                ],
                [
                    'name' => 'Xem hợp đồng',
                    'link' => '',
                    'active' => true
                ],
            ];
            
    $nv_id = getNhanVienID();
    $ma_quyen = getQuyenNhanVien();
    $userViewed = $user_id;
    
    //Chuyển đổi định dạng ngày tháng
    $startTime = date_create($startTime);
		$startTime = date_format($startTime, 'Ymd');
		$endTime = date_create($endTime);
		$endTime = date_format($endTime, 'Ymd');
		
    // Lấy ra ds các lịch sử hoa hồng theo mốc thời gian
    $sql = "SELECT a.*, format(a.giatri, '#,##0') as tonghh, b.tennhanvien FROM hopdong a, nhanvien b ";
    $sql .= "WHERE a.nhanvien_id = b.id ";
    $sql .= "and DATE_FORMAT(a.created_at, '%Y%m%d') >= '$startTime' ";
    $sql .= "and DATE_FORMAT(a.created_at, '%Y%m%d') <= '$endTime' ";
    $sql .= "and a.deleted = 0 ";
    if($ma_quyen == 1){
        $sql .= "and a.nhanvien_id = '$user_id' ";
    }
    else {
      $sql .= "and a.nhanvien_id = '$user_id' ";
      $sql .= "and b.parent_id = '$nv_id' ";
    }
    
    $sql .= "order by a.created_at desc";
    $lstContract = DB::select($sql);
    
    return response()->json(['lstContract' => $lstContract, 'userViewed' => $userViewed, 'sql' => $sql]);
  }
}
