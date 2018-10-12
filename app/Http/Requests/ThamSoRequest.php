<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ThamSoRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    $id = isset($this->id) ? ',mathamso,' . $this->id : '';

    return [
        'txttenthamso'      => 'required',
        'txtthongtinthamso' => 'required',
        'txtgiatrithamso'   => 'required'
    ];
  }

  public function messages()
  {
    return [
        'txttenthamso.required'     => 'Vui lòng nhập tên tham số',
        'txtthongtinthamso.required'=> 'Vui lòng nhập thông tin tham số',
        'txtgiatrithamso.required'  => 'Vui lòng nhập giá trị tham số'
    ];
  }
}
