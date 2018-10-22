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
  $('#txt-error-file').html(m);
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
      <form class="form-horizontal" action="{{ route('api.hopdong.create') }}" method="post" id="form-create" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="card-body">
          <h4 class="card-title">Tạo hợp đồng mới</h4>
          <div class="form-group row">
            <label class="col-md-2 control-label col-form-label">Số hợp đồng</label>
            <div class="col-md-10 mc-form-input">
              <input type="text" class="form-control" name="sohopdong" id="sohopdong" placeholder="Số hợp đồng">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-2 control-label col-form-label">Tên hợp đồng</label>
            <div class="col-md-10 mc-form-input">
              <input type="text" class="form-control" name="tenhopdong" id="tenhopdong" placeholder="Tên hợp đồng">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-2 control-label col-form-label">Tên khách hàng</label>
            <div class="col-md-10 mc-form-input">
              <input type="text" class="form-control" name="tenkhachhang" id="tenkhachhang" placeholder="Tên khách hàng">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-2 control-label col-form-label">Số điện thoại</label>
            <div class="col-md-10 mc-form-input">
              <input type="text" class="form-control" name="sodienthoai" id="sodienthoai" placeholder="Số điện thoại">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-2 control-label col-form-label">Địa chỉ email</label>
            <div class="col-md-10 mc-form-input">
              <input type="text" class="form-control" name="email" id="email" placeholder="Địa chỉ email">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-2 control-label col-form-label">Địa chỉ</label>
            <div class="col-md-10 mc-form-input">
              <input type="text" class="form-control" name="diachi" id="diachi" placeholder="Địa chỉ">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-2 control-label col-form-label">Giá trị hợp đồng</label>
            <div class="col-md-10 mc-form-input">
              <input type="number" min="0" class="form-control" name="giatri" id="giatri" placeholder="Giá trị hợp đồng">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-2 control-label col-form-label">File/Ảnh đính kèm</label>
            <div class="col-md-10 mc-form-input">
              <input type="file" class="custom-file-input" name="dinhkem[]" id="dinhkem" multiple="multiple">
              <span id="txt-error-file" class="small text-danger"></span>
            </div>
          </div>
          <div class="form-group row mc-no-margin-bottom">
            <div class="col-md-2"></div>
            <div class="col-md-10">
              <div class="progress">
                <div class="progress-bar progress-bar-striped" id="send-process" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="border-top">
          <div class="card-body">
            <button type="submit" class="btn btn-primary" id="button-create">Tạo mới</button>
            <a href="{{ route('admin.hopdong.index') }}" class="btn btn-secondary">Quay lại</a>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
</div>
@endsection