<?php

namespace App\Http\Controllers\AdminCP;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ThamSo;
use App\Http\Requests\DemoRequest;
use DB;

class ProfileController extends Controller
{   
    protected $template ='';
    public function __construct()
    {
      $this->template['title'] = 'Thông tin nhân sự';
      $this->template['title-breadcrumb'] = 'Thông tin nhân sự';
    }
    
    public function view($id)
    {
        $template = $this->template;
        $template['form-datatable'] = true;
        $template['breadcrumbs'] = [
            [
                'name' => 'Thông tin nhân sự',
                'link' => route('admin.qlnhansu'),
                'active' => false
            ],
            [
                'name' => 'Thông tin',
                'link' => '',
                'active' => true
            ],
        ];
    //   $template['thamso'] = ThamSo::select('id','mathamso','tenthamso','giatrithamso','mota')->get();
      return view('back.profile.index',compact('template'));
    }

}
