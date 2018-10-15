@extends('back.layouts.app')
@section('styles')
@endsection
@section('scripts')
<script>
optionsDataTable = {
  "ajax": {
    url: "{{ route('api.doanhthu.dachot') }}",
    "type": "POST",
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
  },
  "language": languageDatatable,
  "processing": true,
  "serverSide": true,
  "columns": [
    { "data": "nguoichot.tennhanvien" , "name": "nguoichot.tennhanvien" },
    { "data": "sotien" , "name": "sotien"},
    { "data": "ngaychot", "name": "ngaychot" },
    { "data": "action" },
  ]
};
table = $('#table-data-content').DataTable(optionsDataTable);
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
          <div class="table-responsive">
            <table id="table-data-content" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th nowrap>Người chốt</th>
                  <th nowrap>Số tiền</th>
                  <th width="150" nowrap>Ngày chốt</th>
                  <th width="70" nowrap>Chi tiết</th>
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