@extends('back.layouts.app')
@section('styles')
@endsection
@section('scripts')
<script>
  $('#btnXem').click(function(){
    var startTime = $('#startDate').val();
    var endTime = $('#endDate').val();
    $.ajax({
      headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
      url: "{{ route('admin.contract.search', $userViewed) }}", 
      type: 'POST',
      data: {
           startTime: startTime,
           endTime: endTime
      },
      dataType:"json",
      success: function(data){
          console.log(data.sql);
          $('#table-data-content').DataTable( {
              processing: true,
              responsive: true,
              data: data.lstContract,
              bDestroy: true,
              columns: [
                        { "data": "tennhanvien" },
                        { "data": "sohopdong" },
                        { "data": "tenhopdong" },
                        { "data": "tenkhachhang" },
                        { "data": "tonghh" },
                        { "data": "created_at" },
                        { "data": "trangthai" }
                      ]
          });
      }
    });
  });
        
  $(document).ready(function(){
    $('#table-data-content').DataTable();
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
            <h5 class="card-title">Quản lý lịch sử hợp đồng</h5>
            <div class="block-tool">
              
            </div>
          </div>
          
          <form class="form-inline">
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-12 col-xs-12">Thời gian bắt đầu </label>
              <div class="col-md-4 col-sm-4 col-xs-12">
                <input type="date" id="startDate" class="form-control"/>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-12 col-xs-12">Thời gian kết thúc </label>
              <div class="col-md-4 col-sm-4 col-xs-12">
                <input type="date" id="endDate" class="form-control"/>
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
                      <th>NHÂN VIÊN</th>
                      <th>SỐ HỢP ĐỒNG</th>
                      <th>TÊN HỢP ĐỒNG</th>
                      <th>TÊN KH</th>
                      <th>GIÁ TRỊ HĐ</th>
                      <th>NGÀY LÊN HĐ</th>
                      <th>TRẠNG THÁI</th>
              </thead>
              <tbody>
                @foreach($template['lstContract'] as $contract)
                <tr>
                  <td>{{ $contract-> tennhanvien }}</td>
                  <td>{{ $contract-> sohopdong }}</td>
                  <td>{{ $contract-> tenhopdong }}</td>
                  <td>{{ $contract-> tenkhachhang }}</td>
                  <td>{{ formatMoneyData($contract-> giatri) }}</td>
                  <td>{{ $contract-> created_at }}</td>
                  <td>{{ $contract-> trangthai }}</td>
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