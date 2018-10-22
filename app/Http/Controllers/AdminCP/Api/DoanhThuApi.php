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

  public function doanhThuDaChot(Request $request)
  {
  	$doanhthu = $this->repository->doanhThuDaChot($request);
  	return Datatables::of($doanhthu)
      ->editColumn('ngaychot', function($model) {
        return formatDateTimeData($model->ngaychot);
      })
      ->editColumn('thangchot', function($model) {
        $thangchot = explode('/', $model->thangchot);
        return 'Tháng ' . $thangchot[1] .' - Năm ' . $thangchot[0];
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
      ->editColumn('sotien', function($model) {
        return formatMoneyData($model->sotien);
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

        // Kiểm tra xem được phép chốt doanh thu chưa
        $countHoaHong = $this->hoaHongRepository->query()
          ->whereMonth('created_at', '=', date('m'))
          ->where('trangthai', 0)->count();
        
        if ($countHoaHong > 0)
        {
          $message = '<b>Chưa đến ngày chốt doanh thu</b>';
          break;
        }  

        // Update lại trạng thái hoa hồng
        $listHoaHong = $this->hoaHongRepository->query()
          ->where('trangthai', 0)
          ->update([
            'trangthai' => 1
        ]);
        

        $tongtiendoanhthu = 0;
        $dataChiTietDoanhThu = [];
        $listNhanVien = $this->nhanVienRepository->query()->where('hoahongtamtinh', '>', 0)
          ->where('trangthai', 1)
          ->get();
        // Duyệt qua từng nhân viên
        foreach ($listNhanVien as $nhanvien) {
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
        $thangchot = date('Y/m', strtotime('first day of last month'));
        $doanhthu = new DoanhThu;
        $doanhthu->sotien = $tongtiendoanhthu;
        $doanhthu->maso = strtoupper(uniqid('DT'));
        $doanhthu->ngaychot = new DateTime;
        $doanhthu->thangchot = $thangchot;
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