@extends('back.layouts.app')
@section('styles')
@endsection
@section('scripts')
<script>
  $('#btnXem').click(function(){
    var startTime = $('#startDate').val();
    var endTime = $('#endDate').val();
    var loaihoahong = $('#loaihoahong').val();
    $.ajax({
      headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
      url: "{{ route('admin.commission.search') }}", 
      type: 'POST',
      data: {
           startTime: startTime,
           endTime: endTime,
           loaihoahong: loaihoahong
      },
      dataType:"json",
      success: function(data){
          $('#table-data-content').DataTable( {
              processing: true,
              responsive: true,
              data: data.lstTrans,
              bDestroy: true,
              columns: [
                        { "data": "tennhanvien" },
                        { "data": "loaihoahong" },
                        { "data": "hopdong_id" },
                        { "data": "tenhopdong" },
                        { "data": "tonghh" },
                        { "data": "created_at" },
                        { "data": "trangthai" },
                        { "data": "chucnang" }
                      ]
          });
      }
    });
  });
        
  $(document).ready(function(){
    $('#table-data-content').DataTable();
    
    $('#table-data-content tbody').on( 'click', 'button', function () {
        var ma_hd = $(this).parents('tr').find('td').eq(2).text();
        $.ajax({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
          url: "{{ route('admin.commission.tree') }}", 
          type: 'POST',
          data: {
               ma_hd: ma_hd
          },
          dataType:"json",
          success: function(data){
            var nv = data.nv_id;
            var szAlert = "";
            for(var i = 0; i < data.lstHH.length; i++){
              szAlert += (i+1) + ". [" + data.lstHH[i].loaihoahong + "] " + data.lstHH[i].tennhanvien + " : " + data.lstHH[i].tonghh + "\n";
              if(nv == data.lstHH[i].nhanvien_id){
                break;
              }
            }
            alert(szAlert);
          }
        });
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
            <h5 class="card-title">Quản lý lịch sử hoa hồng</h5>
            <div class="block-tool">
              
            </div>
          </div>
          <form class="form-inline">
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Thời gian bắt đầu </label>
              <div class="col-md-4 col-sm-4 col-xs-12">
                <input type="date" id="startDate" class="form-control"/>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Thời gian kết thúc </label>
              <div class="col-md-4 col-sm-4 col-xs-12">
                <input type="date" id="endDate" class="form-control"/>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-12 col-xs-12">Loại HH </label>
              <div class="col-md-4 col-sm-8 col-xs-12">
                <select class="form-control" id="loaihoahong">
                  <option value="all">Tất cả</option>
                  <option value="Trực tiếp">Trực tiếp</option>
                  <option value="Gián tiếp">Gián tiếp</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-8 col-md-offset-3 col-sm-12 col-sm-offset-3 col-xs-12">
                <button type="button" class="btn btn-info" id="btnXem">Xem</button>
              </div>
            </div>
          </form>
          <hr>
          <div class="table-responsive">
            <table id="table-data-content" class="table table-striped table-bordered responsive">
              <thead>
                  <tr>
                      <th>NHÂN VIÊN NHẬN</th>
                      <th>LOẠI HOA HỒNG</th>
                      <th>HỢP ĐỒNG ID</th>
                      <th>HỢP ĐỒNG</th>
                      <th>HOA HỒNG</th>
                      <th>NGÀY HƯỞNG</th>
                      <th>TRẠNG THÁI</th>
                      <th>CHỨC NĂNG</th>
              </thead>
              <tbody>
                @foreach($template['lstTrans'] as $trans)
                <tr data-id="{{ $trans-> cayhoahong }}">
                  <td>{{ $trans-> tennhanvien }}</td>
                  <td>{{ $trans-> loaihoahong }}</td>
                  <td>{{ $trans-> hopdong_id }}</td>
                  <td>{{ $trans-> tenhopdong }}</td>
                  <td>{{ formatMoneyData($trans-> giatri) }}</td>
                  <td>{{ $trans-> created_at }}</td>
                  <td>{{ $trans-> trangthai }}</td>
                  <td><button>Chi tiết</button></td>
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