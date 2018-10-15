@extends('back.layouts.app')
@section('styles')
@endsection
@section('scripts')
<script src="{{ asset(config('setting.admin.path_js') . 'jquery.inputmask.min.js') }}"></script>
<script>
$(".date-inputmask").inputmask("dd/mm/yyyy");
$('.date-inputmask').keypress(function (event) {
 if (event.keyCode === 10 || event.keyCode === 13) {
   event.preventDefault();
 }
});
apiData = '{{ route('api.hopdong.all') }}';
</script>
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
              <div class="mc-block-header">
                 <h5 class="card-title" style="width: 150px;">Danh sách hợp đồng</h5>
              </div>
              <div class="mc-block-tool">
                 <a class="btn btn-success btn-sm" href="{{ route('admin.hopdong.create') }}"><i class="mdi mdi-plus-box"></i> Tạo mới</a>
                 @if(isAdminCP())
                 <button class="btn btn-info btn-sm" name="action" value="approve" type="submit"><i class="mdi mdi-marker-check"></i> Duyệt hợp đồng</button>
                 @endif
                 <button class="btn btn-primary btn-sm" name="action" value="send" type="submit"><i class="mdi mdi-marker-check"></i> Gửi duyệt</button>
                 <button class="btn btn-danger btn-sm" name="action" value="delete" type="submit"><i class="mdi mdi-delete-empty"></i> Xóa bỏ</button>
              </div>
              <hr style="clear: both;">
              <div class="form-inline float-sm-right">
                <div class="input-group mb-2 mr-sm-2">
                  <div class="input-group-prepend">
                    <div class="input-group-text">Trạng thái hợp đồng</div>
                  </div>
                  @if (!isAdminCP())
                  <select class="form-control" id="trangthai">
                    <option value="Chưa gửi">Chưa gửi</option>
                    <option value="Gửi duyệt">Gửi duyệt</option>
                    <option value="Đã duyệt">Đã duyệt</option>
                    <option value="all">Tất cả</option>
                  </select>
                  @else
                  <select class="form-control" id="trangthai">
                    <option value="Gửi duyệt">Gửi duyệt</option>
                    <option value="Chưa gửi">Chưa gửi</option>
                    <option value="Đã duyệt">Đã duyệt</option>
                    <option value="all">Tất cả</option>
                  </select>
                  @endif
                </div>
                <div class="input-group mb-2 mr-sm-2">
                  <div class="input-group-prepend">
                    <div class="input-group-text">Thời gian bắt đầu</div>
                  </div>
                  <input type="text" class="form-control date-inputmask" id="start-date" placeholder="Thời gian bắt đầu" value="{{ formatDateData(getFristDayOfMonth()) }}" data-init="{{ formatDateData(getFristDayOfMonth()) }}">
                </div>
                <div class="input-group mb-2 mr-sm-2">
                  <div class="input-group-prepend">
                    <div class="input-group-text">Thời gian kết thúc</div>
                  </div>
                  <input type="text" class="form-control date-inputmask" id="end-date" placeholder="Thời gian kết thúc" value="{{ formatDateData(getLastDayOfMonth()) }}" data-init="{{ formatDateData(getLastDayOfMonth()) }}">
                </div>
                <div class="input-group mb-2">
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
                          <th width="auto" nowrap></th>
                          <th width="15" nowrap>
                             <!--<input name="select_all" value="all" id="ckb-select-all" type="checkbox" />-->
                             <label class="mc-container">&nbsp;
                             <input type="checkbox" value="all" id="ckb-select-all">
                             <span class="mc-checkmark"></span>
                             </label>
                          </th>
                          <th nowrap>Số hợp đồng</th>
                          <th nowrap>Tên hợp đồng</th>
                          <th nowrap>Khách hàng</th>
                          <th nowrap>Giá trị</th>
                          <th nowrap>Trạng thái</th>
                          <th nowrap>Email</th>
                          <th width="auto" nowrap>Công cụ</th>
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