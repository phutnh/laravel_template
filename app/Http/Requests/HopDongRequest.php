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

    return [
      'sohopdong' => 'required|unique:hopdong' . $id,
      'tenhopdong' => 'required|min:5',
      'giatri' => 'required|numeric|min:0',
      'tenkhachhang' => 'required|min:3',
      'sodienthoai' => 'required|min:10|max:11',
      'email' => 'required|email',
      'diachi' => 'required|min:5',
      'dinhkem.*' => 'mimes:png,jpg,jpge,pdf,png,doc,docx'
    ];
  }

  public function messages()
  {
    return [
      'sohopdong.required' => 'Vui lòng nhập số hợp đồng',
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
      'dinhkem.*.mimes' => 'File đính kèm không hợp lệ'
    ];
  }
}
