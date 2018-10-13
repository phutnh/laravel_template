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

class HopDongApi extends Controller
{
  protected $repository = '';
  protected $nhanVienRepository = '';
  protected $hoaHongRepository = '';

  public function __construct(HopDongRepository $repository, NhanVienRepository $nhanVienRepository, HoaHongRepository $hoaHongRepository)
  {
    $this->repository = $repository;
    $this->nhanVienRepository = $nhanVienRepository;
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
      ->make(true);
  }

  public function create(HopDongRequest $request) {
    $this->repository->createHopDong($request);
    return responseFormData('Tạo hợp đồng thành công');
  }

  public function update(HopDongRequest $request) {
    
    return responseFormData('Chỉnh sửa hợp đồng thành công');
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
        foreach ($ids as $id) {
          $hopdong = $this->repository->query()->where(['sohopdong' => $id])->first();
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
        foreach ($ids as $id) {
          $hopdong = $this->repository->query()->where(['sohopdong' => $id])->first();
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
    // Lưu hoa hồng nhân viên
    
    $ancestors = $nhanvien->ancestors;
    // Tính tiền gián tiếp
    $hoahonggiantiep = $hoahongtructiep * ($thamsogiantiep / 100);
    $sotiendanhan = $hoahongtructiep;
    $flag = 1;

    foreach ($ancestors as $act) {
      if ($flag == 1)
        $sotiendanhan += $hoahonggiantiep;
      $act->hoahongtamtinh = ($act->hoahongtamtinh + $hoahonggiantiep);
      $act->save();
      $hoahonggiantiep = $hoahonggiantiep * ($thamsogiantiep / 100);
      $sotiendanhan += $hoahonggiantiep;
      $flag++;
    }

    // Tính phần tiền đã nhận được của hợp đồng
    $hopdong->sotiendanhan = $sotiendanhan;
    $hopdong->save();
  }
}
