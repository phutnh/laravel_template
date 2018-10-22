<?php

namespace App\Http\Controllers\AdminCP;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Repository\HopDongRepository;

class HopDongController extends Controller
{
  protected $template = '';

  protected $repository = '';

  public function __construct(HopDongRepository $repository)
  {
    $this->template['title'] = 'Hợp đồng';
    $this->template['title-breadcrumb'] = 'Hợp đồng';
    $this->repository = $repository;
  }
  public function index()
  {
  	$template = $this->template;
    $template['breadcrumbs'] = [
      [
        'name' => 'Hợp đồng',
        'link' => route('admin.hopdong.index'),
        'active' => false
      ],
      [
        'name' => 'Danh sách',
        'link' => '',
        'active' => true
      ],
    ];

    return view('back.hopdong.index', compact('template'));
  }
  
  public function create() {
    $template = $this->template;
    $template['breadcrumbs'] = [
      [
        'name' => 'Hợp đồng',
        'link' => route('admin.hopdong.index'),
        'active' => false
      ],
      [
        'name' => 'Thêm mới',
        'link' => '',
        'active' => true
      ],
    ];

    return view('back.hopdong.create', compact('template'));
  }

  public function update($id) {
    $template = $this->template;
    $template['breadcrumbs'] = [
      [
        'name' => 'Hợp đồng',
        'link' => route('admin.hopdong.index'),
        'active' => false
      ],
      [
        'name' => 'Chỉnh sửa',
        'link' => '',
        'active' => true
      ],
    ];

    $hopdong = $this->repository->find($id);
    if($hopdong->nhanvien_id != getNhanVienID() && $hopdong->trangthai == 'Chưa gửi')
      return redirect()->back();
    if($hopdong->nhanvien_id != getNhanVienID() && getQuyenNhanVien() != 1)
      return redirect()->back();

    return view('back.hopdong.update', compact('template', 'hopdong'));
  }
}
