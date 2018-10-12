@extends('back.layouts.app')
@section('styles')
@endsection
@section('scripts')
<script>apiData = '{{ route('api.hopdong.all') }}'</script>
<script src="{{ asset(config('setting.admin.path_js') . 'hopdong.js') }}"></script>
@endsection

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        @include('back.partials.ajax_form_messages')
        <div class="card-body">
          <form action="{{ route('api.hopdong.action') }}" method="post" id="form-data-hopdong">
            {{ csrf_field() }}
            <div class="block-header">
              <h5 class="card-title">Danh sách hợp đồng</h5>
              <div class="block-tool">
                <a class="btn btn-success btn-sm" href="{{ route('admin.hopdong.create') }}"><i class="mdi mdi-plus-box"></i> Tạo mới</a>
                <button class="btn btn-info btn-sm" name="action" value="approve" type="submit"><i class="mdi mdi-marker-check"></i> Duyệt hợp đồng</button>
                <button class="btn btn-primary btn-sm" name="action" value="send" type="submit"><i class="mdi mdi-marker-check"></i> Gửi duyệt</button>
                <button class="btn btn-danger btn-sm" name="action" value="delete" type="submit"><i class="mdi mdi-delete-empty"></i> Xóa bỏ</button>
              </div>
            </div>
            <div class="table-responsive">
              <table id="table-data-content" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th width="auto"></th>
                    <th width="15">
                      <!--<input name="select_all" value="all" id="ckb-select-all" type="checkbox" />-->
                      <label class="mc-container">&nbsp;
                        <input type="checkbox" value="all" id="ckb-select-all">
                        <span class="mc-checkmark"></span>
                      </label>
                    </th>
                    <th>Số hợp đồng</th>
                    <th>Tên hợp đồng</th>
                    <th>Khách hàng</th>
                    <th>Giá trị</th>
                    <th>Trạng thái</th>
                    <th width="auto">Công cụ</th>
                  </tr>
                </thead>
              </table>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection