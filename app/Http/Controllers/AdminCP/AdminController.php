<?php

namespace App\Http\Controllers\AdminCP;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\DemoRequest;
use DB;

class AdminController extends Controller
{
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
    return view('back.index', compact('template'));
  }

  // Sample function post
  public function postSample(DemoRequest $request)
  {
    # code...
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
    
    $template['users'] = DB::select('select * from nhanvien');
    return view('back.nhanvien.qlynhansu', compact('template'));
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
}
