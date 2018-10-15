@extends('back.layouts.app')
@section('styles')
@endsection
@section('scripts')
<script>
  $(document).ready(function(){
    $('#table-data-content').DataTable();
  });
  
  $('#btnXem').click(function(){
            var startTime = $('#startDate').val();
            var endTime = $('#endDate').val();
            var status = $("#status").val();
            $.ajax({
               headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
               url: "{{ route('admin.get.transdetail') }}", 
               type: 'POST',
               data: {
                 startTime: startTime,
                 endTime: endTime,
                 status: status
               },
               dataType:"json",
               success: function(data){
                        var sztonghoahong = data.tongdarut;
                        $("#spanTongDaRut").html("Tổng HH đã rút: " + sztonghoahong);

                        $('#table-data-content').DataTable( {
                            processing: true,
                            responsive: true,
                            data: data.lstTrans,
                            bDestroy: true,
                            columns: [
                                { "data": "ma_gd" },
                                { "data": "ngayrut" },
                                { "data": "ngayduyet" },
                                { "data": "tongtien" },
                                { "data": "trangthaiduyet" }
                            ]
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
            <h5 class="card-title">Quản lý rút tiền</h5>
            <div class="block-tool">
              <a class="btn btn-success" href="{{ route('admin.trans.withdraw') }}">Rút tiền</a>
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
              <label class="control-label col-md-3 col-sm-12 col-xs-12">Trạng thái </label>
              <div class="col-md-4 col-sm-8 col-xs-12">
                <select class="form-control" id="status">
                  <option value="3">Tất cả</option>
                  <option value="1">Đã duyệt</option>
                  <option value="0">Chờ duyệt</option>
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
          <div class='form-group'>
            <span class='error-red control-label col-md-6 col-sm-6 col-xs-12' id="spanTongDaRut">{{ $template['tongdarut'] }}</span>
          </div>
          <div class="table-responsive">
            <table id="table-data-content" class="table table-striped table-bordered responsive">
              <thead>
                  <tr>
                      <th>MÃ GD</th>
                      <th>NGÀY RÚT</th>
                      <th>NGÀY DUYỆT</th>
                      <th>SỐ TIỀN</th>
                      <th>TRẠNG THÁI</th>
                  </tr>
              </thead>
              <tbody>
                @foreach($template['lstTrans'] as $trans)
                <tr>
                  <td>{{ $trans-> ma_gd }}</td>
                  <td>{{ $trans-> ngayrut }}</td>
                  <td>{{ $trans-> ngayduyet }}</td>
                  <td>{{ formatMoneyData($trans-> sotien) }}</td>
                  <td>{{ $trans-> trangthaiduyet }}</td>
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