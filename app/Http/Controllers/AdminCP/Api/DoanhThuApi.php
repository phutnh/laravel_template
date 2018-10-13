<?php

namespace App\Http\Controllers\AdminCP\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Repository\DoanhThuRepository;
use App\Repositories\Repository\HoaHongRepository;
use Datatables;
use DateTime;
use App\Models\DoanhThu;
use App\Models\ChiTietDoanhThu;

class DoanhThuApi extends Controller
{
  protected $repository = '';
  protected $hoaHongRepository = '';

  public function __construct(DoanhThuRepository $repository, HoaHongRepository $hoaHongRepository)
  {
  	$this->repository = $repository;
    $this->hoaHongRepository = $hoaHongRepository;
  }

  public function all(Request $request)
  {
  	$doanhthu = $this->repository->datatables($request);
  	return Datatables::of($doanhthu)
      ->editColumn('ngaychot', function($model) {
        return formatDateTimeData($model->ngaychot);
      })
      ->addColumn('action', function($model) {
        $link = route('admin.doanhthu.detail', $model->id);
        return '<a href="'.$link.'" class="btn btn-info btn-sm"><i class="fas fa-link"></i> Chi tiết</a>';
      })
      ->editColumn('sotien', function($model) {
        return formatMoneyData($model->sotien);
      })
      ->make(true);
  }

  public function actionData(Request $request)
  {
    $action = $request->action;
    $ids = $request->id;
    if (!$ids)
      return responseFormData('Vui lòng chọn dòng để thao tác');
    $message = '';

    switch ($action) {
      case 'approve':
      {
        if (!isAdminCP())
        {
          $message = 'Bạn không có quyền thao tác';
          break;
        }

        $tongtiendoanhthu = 0;
        $dataChiTietDoanhThu = [];
        foreach ($ids as $id) {
          $hoahong = $this->hoaHongRepository->query()->where('id', $id)->first();
          if (!$hoahong)
          {
            $message = 'Không tìm thấy dữ liệu vui lòng truy cập lại';
            break;
          }

          if($hoahong->trangthai == 1)
          {
            $message = 'Hoa hồng <b>' .$hoahong->mota. '</b> đã được chốt';
            break;
          }
          // Tính tiền cho nhân viên
          $hoahong->trangthai = 1;
          $hoahong->save();
          $giatrihoahong = $hoahong->giatri;
          $nhanvien = $hoahong->nhanvien;
          $nhanvien->soduthucte = ($nhanvien->soduthucte + $giatrihoahong);
          $nhanvien->hoahongtamtinh = ($nhanvien->hoahongtamtinh - $giatrihoahong);
          $nhanvien->save();
          $tongtiendoanhthu += $giatrihoahong;
          array_push($dataChiTietDoanhThu, [
            'nhanvien_id' => $nhanvien->id,
            'sotien' => $giatrihoahong,
            'created_at' => new DateTime,
            'updated_at' => new DateTime
          ]);
        }

        // Lưu lại doanh thu
        $doanhthu = new DoanhThu;
        $doanhthu->sotien = $tongtiendoanhthu;
        $doanhthu->ngaychot = new DateTime;
        $doanhthu->nguoichot_id = getNhanVienID();
        $doanhthu->solanin = 0;
        $doanhthu->created_at = new DateTime;
        $doanhthu->updated_at = new DateTime;
        $doanhthu->save();
        // Lưu lại chi tiết doanh thu
        foreach ($dataChiTietDoanhThu as $chitiet) {
          $check = ChiTietDoanhThu::where('nhanvien_id', $chitiet['nhanvien_id'])
            ->where('doanhthu_id', $doanhthu->id)->first();
          if($check)
          {
            $check->sotien = $check->sotien + $chitiet['sotien'];
            $check->save();
          }
          else
          {
            $doanhthu->chitietdoanhthu()->create($chitiet);
          }
        }
        
        $message = 'Chốt doanh thu thành công';
        break;
      }
      default:
        $message = 'Không tìm thấy hành động nào';
        break;
    }

    return responseFormData($message);
  }
}