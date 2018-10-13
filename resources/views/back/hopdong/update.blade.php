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
$("#form-action-detail").ajaxForm({
  complete: function(response) {
    if (response.status == 200) {

      $("#ajax-messases").css({
        "display": "block"
      });

      messages = response.responseJSON.messages;
      $("#ajax-messases").find('.messases-text').html(messages);

      window.setTimeout(function() {
        $("#ajax-messases").css({
          "display": "none"
        });
      }, 3000);

      $('html, body').animate({
        scrollTop: 0
      }, 500);
      setTimeout(window.location.reload(), 800);

    } else {}
  },
  beforeSubmit: function(arr, $form, options) {
    if (!confirm("Bạn có chắc chắn chọn thao tác này không !"))
      return false;
  },
});
</script>
@endsection
@section('content')
@php
  $canUpdate = $hopdong->trangthaiduyet() != 0 ? false : true;
  $readonly = !$canUpdate ? 'readonly' : '';
  $approved = $hopdong->trangthaiduyet() == 1 ? true : false;
@endphp
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        @include('back.partials.ajax_form_messages')
        @if ($canUpdate)
        <form class="form-horizontal" action="{{ route('api.hopdong.update', $hopdong->id) }}" method="post" id="form-update" enctype="multipart/form-data">
        @else
        <form action="{{ route('api.hopdong.action') }}" method="post" id="form-action-detail">
        @endif
          {{ csrf_field() }}
          <div class="card-body">
            <h4 class="card-title">
              Chỉnh sửa hợp đồng
              @if (!$canUpdate)
                @if ($hopdong->trangthaiduyet() == 1)
                  @if (isAdminCP())
                  <span class="mc-notify badge badge-warning">Hợp đồng này đã được duyệt</span>
                  @else
                  <span class="mc-notify badge badge-warning">Hợp đồng này đã duyệt nên không thể chỉnh sửa</span>
                  @endif
                @else
                <span class="mc-notify badge badge-warning">Hợp đồng này đã gửi duyệt nên không thể chỉnh sửa</span>
                @endif
              @endif
              @if (isAdminCP() && $hopdong->trangthaiduyet() == 2)
              <span class="mc-notify badge badge-info">Bạn có thể duyệt hợp đồng này</span>
              @endif
            </h4>
            <div class="form-group row">
              <label class="col-md-2 control-label col-form-label">Số hợp đồng</label>
              <div class="col-md-10 mc-form-input">
                <input type="text" class="form-control" name="sohopdong" id="sohopdong" placeholder="Số hợp đồng" value="{{ $hopdong->sohopdong }}" {{ $readonly }}>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-2 control-label col-form-label">Tên hợp đồng</label>
              <div class="col-md-10 mc-form-input">
                <input type="text" class="form-control" name="tenhopdong" id="tenhopdong" placeholder="Tên hợp đồng" value="{{ $hopdong->tenhopdong }}" {{ $readonly }}>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-2 control-label col-form-label">Tên khách hàng</label>
              <div class="col-md-10 mc-form-input">
                <input type="text" class="form-control" name="tenkhachhang" id="tenkhachhang" placeholder="Tên khách hàng" value="{{ $hopdong->tenkhachhang }}" {{ $readonly }}>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-2 control-label col-form-label">Số điện thoại</label>
              <div class="col-md-10 mc-form-input">
                <input type="text" class="form-control" name="sodienthoai" id="sodienthoai" placeholder="Số điện thoại" value="{{ $hopdong->sodienthoai }}" {{ $readonly }}>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-2 control-label col-form-label">Địa chỉ email</label>
              <div class="col-md-10 mc-form-input">
                <input type="text" class="form-control" name="email" id="email" placeholder="Địa chỉ email" value="{{ $hopdong->email }}" {{ $readonly }}>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-2 control-label col-form-label">Địa chỉ</label>
              <div class="col-md-10 mc-form-input">
                <input type="text" class="form-control" name="diachi" id="diachi" placeholder="Địa chỉ" value="{{ $hopdong->diachi }}" {{ $readonly }}>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-2 control-label col-form-label">Giá trị hợp đồng</label>
              <div class="col-md-10 mc-form-input">
                <input type="text" class="form-control" name="giatri" id="giatri" placeholder="Giá trị hợp đồng" value="{{ $hopdong->giatri }}" {{ $readonly }}>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-2 control-label col-form-label">File/Ảnh đính kèm</label>
              <div class="col-md-10 mc-form-input">
                <input type="file" class="custom-file-input" name="dinhkem" id="dinhkem" multiple="multiple">
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
              @if ($canUpdate)
              <button type="submit" class="btn btn-primary">Chỉnh sửa</button>
              @else
              @if (isAdminCP())
                <input type="text" name="id[]" value="{{ $hopdong->sohopdong }}" hidden>
                <input type="text" name="form_detail" value="true" hidden>
                <button type="submit" id="action-detail" class="btn btn-info" name="action" value="approve" {{ $approved ? 'disabled' : ''  }}>Duyệt hợp đồng</button>
              @endif
              <button type="submit" class="btn btn-primary" disabled>Chỉnh sửa</button>
              @endif
              <a href="{{ route('admin.hopdong.index') }}" class="btn btn-secondary">Quay lại</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection