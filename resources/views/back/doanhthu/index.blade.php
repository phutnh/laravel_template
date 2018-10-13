@extends('back.layouts.app')
@section('styles')
@endsection
@section('scripts')
<script>
optionsDataTable = {
  "ajax": {
    url: "{{ route('api.doanhthu.all') }}",
    "type": "POST",
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
  },
  "language": languageDatatable,
  "processing": true,
  "serverSide": true,
  "columns": [
    { "data": "nhanvien.tennhanvien" , "name": "nhanvien.tennhanvien" },
    { "data": "sotien" , "name": "sotien"},
    { "data": "ngaychot", "name": "ngaychot" },
    { "data": "nguoichot.tennhanvien", "name": "nguoichot.tennhanvien" },
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
            <h5 class="card-title">Danh sách doanh thu đã chi</h5>
            <div class="block-tool">
              <a class="btn btn-success btn-sm" href="{{ route('admin.hopdong.create') }}"><i class="mdi mdi-plus-box"></i> In phiếu chi</a>
            </div>
          </div>
          <div class="table-responsive">
            <table id="table-data-content" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>Nhân viên</th>
                  <th>Số tiền</th>
                  <th width="150">Ngày chốt</th>
                  <th>Người chốt</th>
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