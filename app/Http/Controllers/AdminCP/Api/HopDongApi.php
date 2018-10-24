<?php

namespace App\Http\Controllers\AdminCP\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Repository\HopDongRepository;
use App\Repositories\Repository\NhanVienRepository;
use App\Repositories\Repository\HoaHongRepository;
use Datatables;
use DateTime;
use App\Http\Requests\HopDongRequest;
use App\Notifications\SendContractApprove;
use App\Notifications\SendContractApproved;
use App\Models\ThamSo;
use DB;

class HopDongApi extends Controller
{
  protected $repository = '';
  protected $nhanVienRepository = '';
  protected $hoaHongRepository = '';

  public function __construct(HopDongRepository $repository, NhanVienRepository $nhanVienRepository, HoaHongRepository $hoaHongRepository)
  {
    $this->repository = $repository;
    $this->nhanVienRepository = $nhanVienRepository;
    $this->hoaHongRepository = $hoaHongRepository;
  }
  
  public function all(Request $request)
  {
    $hopdong = $this->repository->datatables($request);
  	return Datatables::of($hopdong)
      ->addColumn('action', function ($hopdong) {
        $linkEdit = route('admin.hopdong.update', $hopdong->id);
        $link = '<a href="'.$linkEdit.'" class="btn btn-info btn-sm"><i class="mdi mdi-table-edit"></i> Edit</a>';
        return $link;
      })
      ->editColumn('giatri', function($model) {
        return formatMoneyData($model->giatri);
      })
      ->make(true);
  }

  public function create(HopDongRequest $request) {
    $this->repository->createHopDong($request);
    return responseFormData('Tạo hợp đồng thành công');
  }

  public function update(HopDongRequest $request) {
    
    $this->repository->updateHopDong($request);
    return responseFormData('Chỉnh sửa hợp đồng thành công');
  }

  public function dataBieuDoHopDong(Request $request)
  {
    $dataBieuDoHopDong = $this->repository->dataBieuDoHopDong($request);
    $json = [];

    foreach ($dataBieuDoHopDong as $bieudo) {
      $data = [
        'nd' => formatDateData($bieudo->nd, 'Y/m/d'),
        'tonghopdong' => $bieudo->tonghopdong
      ];
      array_push($json, $data);
    }

    return response()->json($json, 200);
  }

  public function removeImage(Request $request)
  {
    $file_name = $request->file_name;
    $hopdong_id = $request->hopdong_id;
    $hopdong = $this->repository->query()->find($hopdong_id);

    if ($hopdong) {

      $path = public_path() . '/uploads/hopdong/' . $file_name;
      if(file_exists($path))
      {
        @unlink($path);
      }
      // trường hợp file k tồn tại sẽ update lại database
      $dinhkem = $hopdong->dinhkem;
      $dinhkem = explode('|', $dinhkem);
      $save_dinhkem = '';
      foreach ($dinhkem as $dk) {
        if ($dk != $file_name)
          $save_dinhkem .= $dk . '|';
      }
      $hopdong->dinhkem = rtrim($save_dinhkem, '|');;
      $hopdong->save();
    }
  }

  public function actionData(Request $request)
  {
    $action = $request->action;
    $ids = $request->id;
    if (!$ids)
      return responseFormData('Vui lòng chọn dòng để thao tác');
    $message = '';

    switch ($action) {
      case 'delete':
      {
        if (!isAdminCP())
        {
          $message = 'Bạn không có quyền thao tác';
          break;
        }
        
        foreach ($ids as $id) {
          $hopdong = $this->repository->query()->where(['sohopdong' => $id])->first();
          if (!$hopdong)
          {
            $message = 'Không tìm thấy hợp đồng ' .$sohopdong;
            break;
          }

          if($hopdong->trangthaiduyet() == 1)
          {
            $message = 'Hợp đồng <b>'.$hopdong->sohopdong.'</b> đã được duyệt nên không thể xóa';
            break;
          } else {
            $hopdong->remove();
            $message = 'Xóa dữ liệu thành công';
          }
        }
        break;
      }
      case 'approve':
      {
        if (!isAdminCP())
        {
          $message = 'Bạn không có quyền thao tác';
          break;
        }

        // Kiểm tra xem đã được chốt doanh thu chưa nếu chưa thì không được duyệt
        $countHoaHong = $this->hoaHongRepository->query()
          ->whereMonth('created_at', '<', date('m'))
          ->where('trangthai', 0)->count();
        $lastMonth = date('m-Y', strtotime('first day of last month'));
        if ($countHoaHong > 0)
        {
          $message = 'Vui lòng chốt doanh thu của tháng <b>'.$lastMonth.'</b> để duyệt hợp đồng mới';
          break;
        }  
        
        foreach ($ids as $id) {
          $hopdong = $this->repository->query()->where(['sohopdong' => $id])->first();
          if (!$hopdong)
          {
            $message = 'Không tìm thấy hợp đồng ' .$sohopdong;
            break;
          }

          if($hopdong->trangthaiduyet() == 1)
          {
            $message = 'Hợp đồng <b>'.$hopdong->sohopdong.'</b> đã được duyệt nên không cần duyệt';
            break;
          } else {
            // Tính hoa hồng
            $this->approved($hopdong);
            // Duyệt hợp đồng
            $hopdong->trangthai = 'Đã duyệt';
            $hopdong->nguoiduyet_id = getNhanVienID();
            $hopdong->ngayduyet = new DateTime;
            $hopdong->save();
            // $hopdong->nhanvien->notify(new SendContractApproved($hopdong->id));
            $message = 'Duyệt hợp đồng thành công';
          }
        }
        break;
      }
      case 'send':
      {
        foreach ($ids as $id) {
          $hopdong = $this->repository->query()->where(['sohopdong' => $id])->first();
          if (!$hopdong)
          {
            $message = 'Không tìm thấy hợp đồng ' .$sohopdong;
            break;
          }

          if($hopdong->trangthaiduyet() == 1)
          {
            $message = 'Hợp đồng <b>'.$hopdong->sohopdong.'</b> đã được duyệt nên không cần gửi duyệt';
            break;
          } else if($hopdong->trangthaiduyet() == 2) {
            $message = 'Hợp đồng <b>'.$hopdong->sohopdong.'</b> đã được gửi duyệt nên không cần gửi duyệt';
            break;
          } else {
            $hopdong->trangthai = 'Gửi duyệt';
            $hopdong->save();
            // $admin = $this->nhanVienRepository->find(1);
            // $admin->notify(new SendContractApprove($hopdong->id));
            $message = 'Gửi duyệt hợp đồng thành công';
          }
        }
        break;
      }
      default:
        $message = 'Không tìm thấy hành động nào';
        break;
    }

    return responseFormData($message);
  }

  private function approved($hopdong)
  {
    $nhanvien = $hopdong->nhanvien;
    $giatri = $hopdong->giatri;
    $thamsotructiep = ThamSo::where('mathamso', '=', 'k1')->first()->giatrithamso;
    $thamsogiantiep = ThamSo::where('mathamso', '=', 'k2')->first()->giatrithamso;
    $hoahongtructiep = $giatri * ($thamsotructiep / 100);
    // Tính tiền trực tiếp
    $nhanvien->hoahongtamtinh = ($nhanvien->hoahongtamtinh + $hoahongtructiep);
    $nhanvien->save();
    // Nếu chưa kích hoạt thì sẽ kích hoạt
    if ($nhanvien->trangthai == 0){
      $nhanvien->trangthai = 1;
      $nhanvien->save();
    }

    // Lưu hoa hồng nhân viên trực tiếp
    $this->hoaHongRepository->save([
      'loaihoahong' => 'Trực tiếp',
      'mota' => 'Nhận tiền hoa hồng trực tiếp từ hợp đồng ' . $hopdong->sohopdong,
      'nhanvien_id' => $nhanvien->id,
      'giatri' => $hoahongtructiep,
      'hopdong_id' => $hopdong->id,
      'cayhoahong' => '',
      'created_at' => new DateTime,
      'trangthai' => 0
    ]);
    
    $ancestors = $nhanvien->ancestors;
    // Tính tiền gián tiếp
    $hoahonggiantiep = $hoahongtructiep * ($thamsogiantiep / 100);
    $sotiendanhan = $hoahongtructiep;
    $flag = 1;
    $cayhoahong = $nhanvien->id.',';
    $oldNhanVien = $nhanvien;
    foreach ($ancestors as $act) {
      // Nếu user được kích hoạt thì mới nhận
      if($act->trangthai == 0)
        break;
      // Cộng thêm số tiền trực tiếp
      if ($flag == 1)
        $sotiendanhan += $hoahonggiantiep;
      
      $act->hoahongtamtinh = ($act->hoahongtamtinh + $hoahonggiantiep);
      $act->save();
      // Lưu hoa hồng nhân viên gián tiếp
      $mota = 'Nhận tiền hoa hồng gián tiếp từ nhân viên '.$oldNhanVien->tennhanvien. '['.$oldNhanVien->manhanvien.'] thông qua hợp đồng ' .$hopdong->sohopdong;
      $this->hoaHongRepository->save([
        'loaihoahong' => 'Gián tiếp',
        'mota' => $mota,
        'nhanvien_id' => $act->id,
        'giatri' => $hoahonggiantiep,
        'hopdong_id' => $hopdong->id,
        'cayhoahong' => rtrim($cayhoahong, ','),
        'created_at' => new DateTime,
        'trangthai' => 0
      ]);
      $hoahonggiantiep = $hoahonggiantiep * ($thamsogiantiep / 100);
      // Cộng thêm số tiền gián tiếp
      $sotiendanhan += $hoahonggiantiep;
      $oldNhanVien = $act;
      $cayhoahong .= $act->id . ',';
      if (intval($hoahonggiantiep) == 0)
        break;
      $flag++;
    }

    // Tính phần tiền đã nhận được của hợp đồng
    $hopdong->sotiendanhan = $sotiendanhan;
    $hopdong->save();
  }
}
