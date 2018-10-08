@extends('back.layouts.app')
@section('styles')
@endsection
@section('scripts')
  <script type="text/javascript">
    optionsDataTable = {
      "ajax": "{{ route('api.hopdong.all') }}",
      "language": languageDatatable,
      "processing": true,
      "serverSide": true,
      "columns": [
        { "data": "sohopdong" },
        { "data": "tenhopdong" },
        { "data": "tenkhachhang" },
        { "data": "giatri" },
        { "data": "trangthai" }
      ]
    };
  </script>
@endsection

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <div class="block-header">
            <h5 class="card-title">Danh sách hợp đồng</h5>
            <div class="block-tool">
              <a class="btn btn-success" href="{{ route('admin.hopdong.create') }}">Tạo mới</a>
            </div>
          </div>
          <table id="table-data-content" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>Số hợp đồng</th>
                <th>Tên hợp đồng</th>
                <th>Khách hàng</th>
                <th>Giá trị</th>
                <th>Trạng thái</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection