<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HopDongRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    $id = isset($this->id) ? ',sohopdong,' . $this->id : '';
    $rules = [];
    $rules['sohopdong'] = 'required|regex:/^[A-Za-z0-9-_+]+$/|unique:hopdong' . $id;
    $rules['tenhopdong'] = 'required|min:5';
    $rules['giatri'] = 'required|numeric|min:0';
    $rules['tenkhachhang'] = 'required|min:3';
    $rules['sodienthoai'] = 'required|min:10|max:11';
    $rules['email'] = 'required|email';
    $rules['diachi'] = 'required|min:5';
    if (isset($this->id)) {
      $rules['dinhkem.*'] = 'nullable|mimetypes:image/jpeg,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf,image/png';
    } else {
      $rules['dinhkem.*'] = 'mimetypes:image/jpeg,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf,image/png';
    }
    
    return $rules;
  }

  public function messages()
  {
    return [
      'sohopdong.required' => 'Vui lòng nhập số hợp đồng',
      'sohopdong.regex' => 'Số hợp đồng chỉ có thể chứa chữ cái, số và các ký tự - + _.',
      'sohopdong.unique' => 'Số hợp đồng vừa nhập đã tồn tại',
      'tenhopdong.required' => 'Vui lòng nhập tên hợp đồng',
      'tenhopdong.min' => 'Vui lòng nhập tên hợp đồng từ 5 ký tự',
      'giatri.required' => 'Vui lòng nhập giá trị của hợp đồng',
      'giatri.numeric' => 'Giá trị của hợp đồng là số',
      'giatri.min' => 'Giá trị của hợp đồng là số lớn hơn 0',
      'tenkhachhang.required' => 'Vui lòng nhập tên khách hàng',
      'tenkhachhang.min' => 'Tên khách hàng phải từ 3 ký tự',
      'sodienthoai.required' => 'Vui lòng nhập số điện thoại khách hàng',
      'sodienthoai.min' => 'Số điện thoại phải từ 10 số',
      'sodienthoai.max' => 'Số điện thoại không được quá 11 số',
      'sodienthoai.regex' => 'Số điện tthoại không hợp lệ',
      'email.required' => 'Vui lòng nhập email',
      'email.email' => 'Email không hợp lệ',
      'diachi.required' => 'Vui lòng nhập địa chỉ',
      'diachi.min' => 'Địa chỉ phải từ 5 ký tự',
      'dinhkem.*.mimetypes' => 'File đính kèm không hợp lệ'
    ];
  }
}
