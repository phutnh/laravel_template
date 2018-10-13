<?php

namespace App\Http\Controllers\AdminCP;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Repository\HoaHongRepository;

class DoanhThuController extends Controller
{
  protected $template = '';

  protected $repository = '';

  public function __construct(HoaHongRepository $repository)
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
        'name' => 'Danh sách đã chi',
        'link' => '',
        'active' => true
      ],
    ];

    return view('back.doanhthu.index', compact('template'));
  }
}