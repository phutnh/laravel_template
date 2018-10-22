<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChotDoanhThuRequest extends FormRequest
{
  public function authorize()
  {
    return isAdminCP();
  }

  public function rules()
  {
    return [
      'id' => 'required|exists:nhanvien,id'
    ];
  }

  public function messages()
  {
    return [
      'id.required' => 'Vui lòng chọn dòng để thao tác',
      'id.exists' => 'Dữ liệu nhân viên không hợp lệ vui lòng làm mới lại trang'
    ];
  }
}
