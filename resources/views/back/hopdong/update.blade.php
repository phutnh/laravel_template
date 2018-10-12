@extends('back.layouts.app')
@section('styles')
@endsection
@section('scripts')
<script src="{{ asset(config('setting.admin.path_js') . 'bootstrap-fileselect.js') }}"></script>
<script>
$('#dinhkem').fileselect({
  allowedFileExtensions: ['jpg', 'jpge', 'pdf', 'png', 'doc', 'docx'],
  browseBtnClass: 'btn btn-info',
  validationCallback: function (m, type, instance) {
    instance.$inputGroup
    .after('<span class="small text-danger">' + m + '</span>');
  }
});
</script>
@endsection
@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        @include('back.partials.ajax_form_messages')
        <form class="form-horizontal" action="{{ route('api.hopdong.update', $hopdong->id) }}" method="post" id="form-update" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="card-body">
            <h4 class="card-title">Chỉnh sửa hợp đồng</h4>
            <div class="form-group row">
              <label class="col-md-3 control-label col-form-label">Số hợp đồng</label>
              <div class="col-md-9 mc-form-input">
                <input type="text" class="form-control" name="sohopdong" id="sohopdong" placeholder="Số hợp đồng" value="{{ $hopdong->sohopdong }}" readonly>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-3 control-label col-form-label">Tên hợp đồng</label>
              <div class="col-md-9 mc-form-input">
                <input type="text" class="form-control" name="tenhopdong" id="tenhopdong" placeholder="Tên hợp đồng" value="{{ $hopdong->tenhopdong }}">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-3 control-label col-form-label">Tên khách hàng</label>
              <div class="col-md-9 mc-form-input">
                <input type="text" class="form-control" name="tenkhachhang" id="tenkhachhang" placeholder="Tên khách hàng" value="{{ $hopdong->tenkhachhang }}">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-3 control-label col-form-label">Số điện thoại</label>
              <div class="col-md-9 mc-form-input">
                <input type="text" class="form-control" name="sodienthoai" id="sodienthoai" placeholder="Số điện thoại" value="{{ $hopdong->sodienthoai }}">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-3 control-label col-form-label">Địa chỉ email</label>
              <div class="col-md-9 mc-form-input">
                <input type="text" class="form-control" name="email" id="email" placeholder="Địa chỉ email" value="{{ $hopdong->email }}">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-3 control-label col-form-label">Địa chỉ</label>
              <div class="col-md-9 mc-form-input">
                <input type="text" class="form-control" name="diachi" id="diachi" placeholder="Địa chỉ" value="{{ $hopdong->diachi }}">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-3 control-label col-form-label">Giá trị hợp đồng</label>
              <div class="col-md-9 mc-form-input">
                <input type="text" class="form-control" name="giatri" id="giatri" placeholder="Giá trị hợp đồng" value="{{ $hopdong->giatri }}">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-3 control-label col-form-label">File/Ảnh đính kèm</label>
              <div class="col-md-9 mc-form-input">
                <input type="file" class="custom-file-input" name="dinhkem" id="dinhkem" multiple="multiple">
              </div>
            </div>
            <div class="form-group row">
              <div class="col-md-3"></div>
              <div class="col-md-9">
                <div class="progress">
                  <div class="progress-bar progress-bar-striped" id="send-process" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="border-top">
            <div class="card-body">
              <button type="submit" class="btn btn-primary">Chỉnh sửa</button>
              <a href="{{ route('admin.hopdong.index') }}" class="btn btn-secondary">Quay lại</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection