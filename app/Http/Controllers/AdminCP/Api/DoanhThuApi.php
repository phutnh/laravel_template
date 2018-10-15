<?php

namespace App\Http\Controllers\AdminCP\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Repository\DoanhThuRepository;
use App\Repositories\Repository\HoaHongRepository;
use App\Repositories\Repository\NhanVienRepository;
use Datatables;
use DateTime;
use App\Models\DoanhThu;
use App\Models\ChiTietDoanhThu;
use App\Http\Requests\ChotDoanhThuRequest;

class DoanhThuApi extends Controller
{
  protected $repository = '';
  protected $hoaHongRepository = '';
  protected $nhanVienRepository = '';

  public function __construct(DoanhThuRepository $repository, HoaHongRepository $hoaHongRepository, NhanVienRepository $nhanVienRepository)
  {
  	$this->repository = $repository;
    $this->hoaHongRepository = $hoaHongRepository;
    $this->nhanVienRepository = $nhanVienRepository;
  }

  public function danhThuDaChot(Request $request)
  {
  	$doanhthu = $this->repository->danhThuDaChot($request);
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

  public function doanhThuThang(Request $request)
  {
    $doanhthu = $this->repository->doanhThuThang($request);
    return Datatables::of($doanhthu)
      ->editColumn('doanhthu.ngaychot', function($model) {
        return formatDateTimeData($model->doanhthu->ngaychot);
      })
      ->editColumn('sotiennv', function($model) {
        return formatMoneyData($model->sotiennv);
      })
      ->make(true);
  }

  public function dataChotDoanhThu(Request $request)
  {
    $data = $this->nhanVienRepository->query()->where('hoahongtamtinh', '>', 0)
      ->where('trangthai', 1)
      ->get();
    return Datatables::of($data)
      ->editColumn('hoahongtamtinh', function($model) {
          return formatMoneyData($model->hoahongtamtinh);
        })
      ->make(true);
  }

  public function actionData(ChotDoanhThuRequest $request)
  {
    $action = $request->action;
    $ids = $request->id;
    $message = '';

    switch ($action) {
      case 'approve':
      {
        if (!isAdminCP())
        {
          $message = 'Bạn không có quyền thao tác';
          break;
        }
        
        foreach ($ids as $id) {
          $nhanvien = $this->nhanVienRepository->query()->where('id', $id)->first();
          if (!$nhanvien)
          {
            $message = 'Không tìm thấy dữ liệu vui lòng truy cập lại';
            break;
          }
          if($nhanvien->trangthai == 0)
          {
            $message = 'Nhân viên '.$nhanvien->tennhanvien. ' chưa được kích hoạt';
            break;
          }
        }

        $tongtiendoanhthu = 0;
        $dataChiTietDoanhThu = [];
        // Duyệt qua từng nhân viên
        foreach ($ids as $id) {
          $nhanvien = $this->nhanVienRepository->query()->where('id', $id)->first();
          // Tính tiền cho nhân viên
          $hoahongtamtinh = $nhanvien->hoahongtamtinh;
          $sotien = $hoahongtamtinh;
          $nhanvien->soduthucte = $nhanvien->soduthucte + $hoahongtamtinh;
          $nhanvien->hoahongtamtinh = 0;
          $nhanvien->save();
          $tongtiendoanhthu += $hoahongtamtinh;

          array_push($dataChiTietDoanhThu, [
            'nhanvien_id' => $nhanvien->id,
            'sotien' => $sotien,
            'created_at' => new DateTime,
            'updated_at' => new DateTime
          ]);
          // dd($dataChiTietDoanhThu);
        }

        // Lưu lại bảng doanh thu
        $doanhthu = new DoanhThu;
        $doanhthu->sotien = $tongtiendoanhthu;
        $doanhthu->maso = strtoupper(uniqid('DT'));
        $doanhthu->ngaychot = new DateTime;
        $doanhthu->nguoichot_id = getNhanVienID();
        $doanhthu->solanin = 0;
        $doanhthu->created_at = new DateTime;
        $doanhthu->updated_at = new DateTime;
        $doanhthu->save();

        // Lưu lại bảng chi tiết doanh thu
         $doanhthu->chitietdoanhthu()->createMany($dataChiTietDoanhThu);
        
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