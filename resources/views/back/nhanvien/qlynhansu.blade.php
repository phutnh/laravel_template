@extends('back.layouts.app')
@section('styles')
@endsection

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <div class="block-header">
            <h5 class="card-title">Danh sách nhân sự</h5>
            <div class="block-tool">
              <a class="btn btn-success" href="{{ route('admin.qlnhansu.create') }}">Tạo mới</a>
            </div>
          </div>
          <table id="table-data-content" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>ID</th>
                <th>Tên nhân sự</th>
                <th>Mã nhân sự</th>
                <th>Tài khoản</th>
                <th>Số di động</th>
                <th>Trạng thái</th>
                <th>Ngày tạo</th>
                <th>Ngày cập nhật</th>
              </tr>
            </thead>
            <tbody>
                @foreach($template['users'] as $user)
                <tr>
                    <td>{{ $user-> id }}</td>
                    <!--TinhNT11 add route profile 12102018-->
                    <td><a href="{{ route('admin.profile.view',$user->id) }}">{{ $user-> tennhanvien }}</a></td>
                    <td>{{ $user-> manhanvien }}</td>
                    <td>{{ $user-> taikhoan }}</td>
                    <td>{{ $user-> sodidong }}</td>
                    <td>{{ $user-> trangthai }}</td>
                    <td>{{ $user-> created_at }}</td>
                    <td>{{ $user-> updated_at }}</td>
                </tr>
                @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection