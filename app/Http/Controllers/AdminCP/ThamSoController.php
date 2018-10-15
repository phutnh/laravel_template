<?php

namespace App\Http\Controllers\AdminCP;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ThamSo;
use App\Http\Requests\DemoRequest;
use Session;
use DB;

class ThamSoController extends Controller
{   
    protected $template ='';
    public function __construct()
    {
      $this->template['title'] = 'Tham số hoa hồng';
      $this->template['title-breadcrumb'] = 'Tham số hoa hồng';
    }
    
    public function index()
    {
        $template = $this->template;
        $template['form-datatable'] = true;
        $template['breadcrumbs'] = [
            [
                'name' => 'Danh sách tham số hoa hồng',
                'link' => '',
                'active' => true
            ],
        ];
      $template['thamso'] = ThamSo::select('id','mathamso','tenthamso','giatrithamso','mota')->get();
      return view('back.thamso.index',compact('template'));
    }
    
    public function update($id){
        $template = $this->template;
        $template['form-datatable'] = true;
        $template['breadcrumbs'] = [
            [
                'name' => 'Danh sách tham số hoa hồng',
                'link' => route('admin.thamso.index'),
                'active' => false
            ],
            [
                'name' => 'Thay đổi',
                'link' => '',
                'active' => true
            ],
        ];
        $thamso = ThamSo::findOrFail($id);
        return view('back.thamso.edit',compact('template','thamso','id'));
    }
    
    public function action(Request $request, $id){

        $this->validate($request,[
            'txttenthamso'      => 'required',
            'txtthongtinthamso' => 'required',
            'txtgiatrithamso'   => 'required'
        ],
        [
            'txttenthamso.required'     => 'Vui lòng nhập tên tham số',
            'txtthongtinthamso.required'=> 'Vui lòng nhập thông tin tham số',
            'txtgiatrithamso.required'  => 'Vui lòng nhập giá trị tham số'
        ]);
        

        $thamso = ThamSo::find($id);
        $thamso -> tenthamso = $request->txttenthamso;
        $thamso -> giatrithamso = $request->txtgiatrithamso;
        $thamso -> mota = $request->txtthongtinthamso;
        $thamso -> timestamps = false;
        $thamso -> save();
        
        session()->flash('success','Bạn đã thay đổi thành công giá trị tham số !');
        return redirect()->route('admin.thamso.index',compact('template'));
        
    }
}
