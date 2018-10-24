@extends('back.layouts.app')
@section('styles')
<style type="text/css">
  .profile-bk {
    width:230px;
    background-color: #eeeeee;
    font-weight: bold;
    text-transform:uppercase;
  }
</style>
@endsection
@section('scripts')
<script type="text/javascript">
  $(function() {
     $('#flash').delay(2500).fadeOut(800);
  });
</script>
@endsection
@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          @if (session()->has('success'))
           <div class="alert alert-success" role="alert" id="flash">
              <i class="mdi mdi-check"></i> {{session()->get('success')}}
           </div>
          @endif
          <div class="block-header">
            <h5 class="card-title">Thông tin cá nhân</h5>
          </div>
            <div class="row">
                <div class="col-lg-3">
                  <img src="{{URL('public/uploads/profile/')}}/{{ $user->hinhanh}}" class="img-thumbnail" alt="user" width="100%">
                </div>
                <div class="col-lg-9">
                  <table id="table-data-content" class="table table-bordered table-hover">
                    <tr>
                        <td class="profile-bk">Tài khoản</td>
                        <td>{{ $user->taikhoan }}</td> 
                    </tr>
                    <tr>
                        <td class="profile-bk">Tên nhân viên</td>
                        <td>{{ $user->tennhanvien }}</td> 
                    </tr>
                    <tr>
                        <td class="profile-bk">Mã nhân viên</td>
                        <td>{{ $user->manhanvien }}</td> 
                    </tr>
                    <tr>
                        <td class="profile-bk">Email</td>
                        <td>{{ $user->email }}</td> 
                    </tr>
                    <tr>
                        <td class="profile-bk">Số điện thoại di động</td>
                        <td>{{ $user->sodidong }}</td> 
                    </tr>
                    <tr>
                        <td class="profile-bk">Chứng minh nhân dân</td>
                        <td>{{ $user->cmnd }}</td> 
                    </tr>
                    <tr>
                        <td class="profile-bk">Link giới thiệu của bạn</td>
                        <td>
                          @if($user->magioithieu != null && $user->trangthai == 1)
                          {{route('user.register.create')}}?ref={{$user->magioithieu}}
                          @else
                          Không có
                          @endif
                        </td> 
                    </tr>
                    <tr>
                        <td class="profile-bk">Người giới thiệu bạn</td>
                        <td>
                          @if(isset($nguoigioithieu))
                          <span class="badge badge-primary">{{ $nguoigioithieu->manhanvien }}</span> 
                          <span class="badge badge-light">{{ $nguoigioithieu->tennhanvien }}</span>
                          @else
                            Không có
                          @endif
                        </td> 
                    </tr>
                    <tr>
                        <td class="profile-bk">Những người bạn đã giới thiệu</td>
                        <td>
                          @foreach($quanhe as $data)
                            @if($data["parent_id"] == $user->id)
                            <span>{{$data["tennhanvien"]}}</span>
                            @endif
                          @endforeach
                        </td> 
                    </tr>
                    <tr>
                        <td class="profile-bk">Giới tính</td>
                        <td>
                          @if($user['gioitinh'] == 0)
                              Nam
                          @else
                              Nữ
                          @endif
                        </td> 
                    </tr>
                    <tr>
                        <td class="profile-bk">Địa chỉ</td>
                        <td>{{ $user->diachi }}</td> 
                    </tr>
                    <tr>
                        <td class="profile-bk">Số tài khoản ngân hàng</td>
                        <td>{{ $user->sotaikhoan }}</td> 
                    </tr>
                    <tr>
                        <td class="profile-bk">Tên ngân hàng</td>
                        <td>{{ $user->tennganhang }}</td> 
                    </tr>
                    <tr>
                        <td class="profile-bk">Chi nhánh</td>
                        <td>{{ $user->chinhanh }}</td> 
                    </tr>
                    <tr>
                        <td class="profile-bk">Số dư thực tế</td>
                        <td>{{ $user->soduthucte }}</td> 
                    </tr>
                    <tr>
                        <td class="profile-bk">Hoa hồng tạm tính</td>
                        <td>{{ $user->hoahongtamtinh }}</td> 
                    </tr>
                  </table>
                  <div class="float-right">
                      <a href="{{route('user.profile.repass')}}" class="btn btn-success">Thay đổi mật khẩu</a>
                      <a href="{{route('user.profile.update')}}" class="btn btn-info">Chỉnh sửa thông tin</a>
                  </div>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection