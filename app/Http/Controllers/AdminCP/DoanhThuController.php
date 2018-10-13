<?php

namespace App\Http\Controllers\AdminCP;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Repository\DoanhThuRepository;

class DoanhThuController extends Controller
{
  protected $template = '';

  protected $repository = '';

  public function __construct(DoanhThuRepository $repository)
  {
    $this->template['title'] = 'Doanh thu';
    $this->template['title-breadcrumb'] = 'Doanh thu';
    $this->repository = $repository;
  }
  public function index()
  {
  	$template = $this->template;
    $template['breadcrumbs'] = [
      [
        'name' => 'Doanh thu',
        'link' => route('admin.doanhthu.index'),
        'active' => false
      ],
      [
        'name' => 'Danh sách',
        'link' => '',
        'active' => true
      ],
    ];

    return view('back.doanhthu.index', compact('template'));
  }

  public function action()
  {
    $template = $this->template;
    $template['breadcrumbs'] = [
      [
        'name' => 'Doanh thu',
        'link' => route('admin.doanhthu.index'),
        'active' => false
      ],
      [
        'name' => 'Chốt doanh thu',
        'link' => '',
        'active' => true
      ],
    ];

    return view('back.doanhthu.action', compact('template'));
  }

  public function detail($id)
  {
    if (!isAdminCP()) 
      return redirect()->back();
    $template = $this->template;
    $template['breadcrumbs'] = [
      [
        'name' => 'Doanh thu',
        'link' => route('admin.doanhthu.index'),
        'active' => false
      ],
      [
        'name' => 'Chi tiết doanh thu',
        'link' => '',
        'active' => true
      ],
    ];

    $doanhthu = $this->repository->find($id);
    return view('back.doanhthu.detail', compact('template', 'doanhthu'));
  }
}