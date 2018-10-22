@extends('back.layouts.app')
@section('styles')
@endsection
@section('scripts')
<script src="{{ asset(config('setting.admin.path_js') . 'dataTables.buttons.min.js') }}"></script>
<script src="{{ asset(config('setting.admin.path_js') . 'buttons.print.min.js') }}"></script>
<script>
var start_date = $("#start-date").val();
optionsDataTable = {
  "ajax": {
    url: "{{ route('api.doanhthu.thang') }}",
    "type": "POST",
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    data: function (d) {
      d.start_date = start_date
    },
  },
  'paging': false,
  "searching": false,
  "language": languageDatatable,
  "processing": true,
  "serverSide": true,
  "columns": [
    { "data": "manhanvien" , "name": "nhanvien.manhanvien", className: "nowrap" },
    { "data": "tennhanvien" , "name": "nhanvien.tennhanvien", className: "nowrap" },
    { "data": "sodidong" , "name": "nhanvien.sodidong", className: "nowrap" },
    { "data": "sotien" , "name": "chitietdoanhthu.sotien", className: "nowrap"},
  ]
};
table = $('#table-data-content').DataTable(optionsDataTable);
$("#btn-search").click(function() {
  start_date = $("#start-date").val();
  table.ajax.reload();
});

new $.fn.dataTable.Buttons( table, {
  buttons: [
    {
      text: `<i class="m-r-10 mdi mdi-printer"></i>In phiếu chi`,
      extend: 'print',
      className: 'btn btn-info'
    }
  ]
});

table.buttons( 0, null ).container().appendTo( '#print_button' );
</script>
@endsection

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        @include('back.partials.ajax_form_messages')
        <div class="card-body">
          <div class="mc-block-header" style="width: 160px;">
            <h5 class="card-title">Doanh thu nhân viên</h5>
          </div>
          <div class="form-inline float-sm-right">
            <div class="input-group mb-2 mr-sm-2">
              <div class="input-group-prepend">
                <div class="input-group-text">Chọn tháng</div>
              </div>
              @php
              $prevMonth = (date('m') - 1);
              $prevMonth = $prevMonth < 10 ? ('0'.$prevMonth) : $prevMonth;
              $selected = date('Y').'/'.$prevMonth;
              @endphp
              <select id="start-date" class="form-control">
                @for ($year = 2018; $year <= date('Y'); $year++)
                  <optgroup label="{{ $year }}">
                    @for ($month = 1; $month < 12; $month++)
                      @php
                      $month = $month < 10 ? ('0'.$month) : $month;
                      $value = $year.'/'.$month;
                      @endphp
                      <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>
                        Tháng {{ $month }} / {{ $year }}
                      </option>
                    @endfor
                  </optgroup>
                @endfor
              </select>
            </div>
            <div class="input-group mb-2 mr-sm-2">
              <div class="input-group-prepend">
                <div class="input-group-text btn btn-success" id="btn-search">
                <i class="fas fa-search m-r-10"></i>Lọc
              </div>
              </div>
            </div>
            <div class="input-group mb-2">
              <div class="input-group-prepend" id="print_button">
              </div>
          </div>
        </div>
          <hr style="clear: both;">
          <div class="table-responsive">
            <table id="table-data-content" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>Mã nhân viên</th>
                  <th>Nhân viên</th>
                  <th>Số điện thoại</th>
                  <th>Số tiền</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection