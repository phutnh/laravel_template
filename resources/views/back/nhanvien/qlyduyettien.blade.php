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
      url: "{{ route('admin.applytrans.search') }}", 
      type: 'POST',
      data: {
           startTime: startTime,
           endTime: endTime
      },
      dataType:"json",
      success: function(data){
          $('#table-data-content').DataTable( {
              processing: true,
              responsive: true,
              data: data.lstTrans,
              bDestroy: true,
              columns: [
                        { "data": "ma_gd" },
                        { "data": "tennhanvien" },
                        { "data": "ngayrut" },
                        { "data": "tongtien" },
                        { "data": "chucnang" }
                      ]
          });
      }
    });
  });
        
  $(document).ready(function(){
    $('#table-data-content').DataTable();
    
    $('#table-data-content tbody').on( 'click', 'button', function () {
        //var table = $('#table-data-content').DataTable();
        //var data = table.row( $(this).parents('tr') ).data();
        var ma_gd = $(this).parents('tr').find('td').eq(0).text();
        var nguoirut = $(this).parents('tr').find('td').eq(1).text();
        var tienrut = $(this).parents('tr').find('td').eq(3).text();
        
        var result = confirm("CHẤP NHẬN PHÊ DUYỆT RÚT TIỀN CHO [" + nguoirut + "] VỚI SỐ TIỀN LÀ: " + tienrut);
        if (result == true) {
          ruttien(ma_gd.trim());
        }
    });
  });
  
  function ruttien(ma_gd){
    $.ajax({
      headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
      url: "{{ route('admin.applytrans.action') }}", 
      type: 'POST',
      data: {
             ma_gd: ma_gd
      },
      dataType:"json",
      success: function(data){
              alert(data.msg);
              var startTime = $('#startDate').val();
              var endTime = $('#endDate').val();
              if(startTime == "" || endTime == ""){
                window.location.reload();
              }
              else {
                $("#btnXem").click();
              }
      }
    });
  }
  
</script>
@endsection
@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <div class="block-header">
            <h5 class="card-title">Quản lý phê duyệt rút tiền</h5>
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
                      <th>MÃ GD</th>
                      <th>NGƯỜI RÚT</th>
                      <th>NGÀY RÚT</th>
                      <th>SỐ TIỀN</th>
                      <th>CHỨC NĂNG</th>
                  </tr>
              </thead>
              <tbody>
                @foreach($template['lstTrans'] as $trans)
                <tr data-id="{{ $trans-> ma_gd }}">
                  <td>{{ $trans-> ma_gd }}</td>
                  <td>{{ $trans-> nguoirut }}</td>
                  <td>{{ $trans-> ngayrut }}</td>
                  <td>{{ formatMoneyData($trans-> sotien) }}</td>
                  <td><button>Duyệt</button></td>
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