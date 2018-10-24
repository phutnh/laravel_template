@extends('back.layouts.app')
@section('styles')
<style type="text/css">
  .table-min-width thead tr th {
    min-width: 150px;
  }
</style>
@endsection
@section('scripts')
<script>
  $(document).ready(function(){
    $('#table-data-content').DataTable();
    
    $("#btnXoa").click(function(){
      var tmpArr = new Array();
      var msg = "Bạn chắc chắn muôn xóa danh sách người dùng: \n";
      
      $("#table-data-content > tbody > tr").each(function(){
        var user_id = $(this).attr("data-id");
        var stt = $(this).find("td").eq(12).text();
        var name = $(this).find("td").eq(1).text();
        if(stt != ""){
          msg += name + "\n";
          tmpArr.push(user_id);
        }
      });
      
      var result = confirm(msg);
      if(result){
        $.ajax({
               headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
               url: "{{ route('admin.qlnhansu.delAll') }}", 
               type: 'POST',
               data: {
                 arrUser: tmpArr
               },
               dataType:"json",
               success: function(data){
                        alert(data.msg);
                        if(data.success){
                          window.location.reload();
                        }
                    }
            });
      }
    });
  });
</script>
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
              <a class="btn btn-danger" href="#" id="btnXoa">Xóa hết hạn</a>
            </div>
          </div>
          <div class="table-responsive">
            <table id="table-data-content" class="table table-striped table-bordered responsive table-min-width">
              <thead>
                <tr>
                  <th>Mã nhân sự</th>
                  <th>Tên nhân sự</th>
                  <th>STK</th>
                  <th>Ngân hàng</th>
                  <th>Chi nhánh</th>
                  <th>Số di động</th>
                  <th>Email</th>
                  <th>HH tạm tính</th>
                  <th>Mã GT</th>
                  <th>Ngày tạo</th>
                  <th>Ngày cập nhật</th>
                  <th>Trạng thái</th>
                  <th>Hạn nộp HĐ</th>
                  <th>Chức năng</th>
                </tr>
              </thead>
              <tbody>
                  @foreach($template['users'] as $user)
                  <tr data-id="{{ $user-> id }}">
                      <td>{{ $user-> manhanvien }}</td>
                      <td><a href="{{ route('admin.qlnhansu.detail', $user-> id) }}">{{ $user-> tennhanvien }}</a></td>
                      <td>{{ $user-> sotaikhoan }}</td>
                      <td>{{ $user-> tennganhang }}</td>
                      <td>{{ $user-> chinhanh }}</td>
                      <td>{{ $user-> sodidong }}</td>
                      <td>{{ $user-> email }}</td>
                      <td>{{ formatMoneyData($user-> hoahongtamtinh) }}</td>
                      <td>{{ $user-> magioithieu }}</td>
                      <td>{{ $user-> created_at }}</td>
                      <td>{{ $user-> updated_at }}</td>
                      <td>{{ $user-> trangthai }}</td>
                      <td>{{ $user-> stt }}</td>
                      <td>
                        <div class="dropdown">
                          <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Chọn
                          </button>
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="{{ route('admin.commission.history', $user-> id) }}">Hoa hồng</a>
                            <a class="dropdown-item" href="{{ route('admin.qlnhansu.contract', $user-> id) }}">Hợp đồng</a>
                          </div>
                        </div>
                      </td>
                  </tr>
                  @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection