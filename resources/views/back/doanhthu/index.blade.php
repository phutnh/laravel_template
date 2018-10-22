@extends('back.layouts.app')
@section('styles')
@endsection
@section('scripts')
<script>
var start_date = $("#start-date").val();
optionsDataTable = {
  "ajax": {
    url: "{{ route('api.doanhthu.dachot') }}",
    "type": "POST",
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    data: function(d) {
      d.start_date = start_date
    }
  },
  "language": languageDatatable,
  "processing": true,
  "serverSide": true,
  "columns": [
    { "data": "nguoichot.tennhanvien" , "name": "nguoichot.tennhanvien", className: "nowrap" },
    { "data": "sotien" , "name": "sotien", className: "nowrap" },
    { "data": "thangchot", "name": "thangchot", className: "nowrap" },
    { "data": "ngaychot", "name": "ngaychot", className: "nowrap" },
    { "data": "action", className: "nowrap" },
  ]
};
table = $('#table-data-content').DataTable(optionsDataTable);
$("#btn-search").click(function() {
  start_date = $("#start-date").val();
  table.ajax.reload();
});
</script>
@endsection

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        @include('back.partials.ajax_form_messages')
        <div class="card-body">
          <div class="block-header">
            <h5 class="card-title">Danh sách doanh thu đã chốt</h5>
          </div>
          <div class="form-inline float-sm-right">
            <div class="input-group mb-2 mr-sm-2">
              <div class="input-group-prepend">
                <div class="input-group-text">Chọn năm chốt</div>
              </div>
              @php
              $selecteYear = date('Y');
              @endphp
              <select id="start-date" class="form-control">
                @for ($year = 2017; $year <= date('Y'); $year++)
                  <option value="{{ $year }}" {{ $selecteYear == $year ? 'selected' : '' }}>Năm {{ $year }}</option>
                @endfor
              </select>
            </div>
            <div class="input-group mb-2 mr-sm-2">
              <div class="input-group-prepend">
                <div class="input-group-text btn btn-success" id="btn-search">
                <i class="fas fa-search m-r-10"></i>Lọc
              </div>
              <input type="text" hidden id="title-filter-none" data-start="{{ formatDateData(getFristDayOfMonth()) }}" data-end="{{ formatDateData(getLastDayOfMonth()) }}">
              </div>
            </div>
          </div>
          <hr style="clear: both;">
          <div class="table-responsive">
            <table id="table-data-content" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>Người chốt</th>
                  <th>Số tiền</th>
                  <th>Tháng chốt</th>
                  <th width="150">Thời gian chốt</th>
                  <th width="70">Chi tiết</th>
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