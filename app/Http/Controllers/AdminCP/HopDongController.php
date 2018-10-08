<?php

namespace App\Http\Controllers\AdminCP;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HopDongController extends Controller
{
  protected $template = '';

  public function __construct()
  {
    $this->template['title'] = 'Hợp đồng';
    $this->template['title-breadcrumb'] = 'Hợp đồng';
  }
  public function index()
  {
  	$template = $this->template;
    $template['form-datatable'] = true;
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
}
