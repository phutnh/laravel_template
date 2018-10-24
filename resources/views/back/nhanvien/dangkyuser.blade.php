@extends('back.layouts.app')
@section('styles')
<style type="text/css">
  .form-control, .thumbnail {
    border-radius: 2px;
}
.btn-danger {
    background-color: #B73333;
}

/* File Upload */
.fake-shadow {
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
}
.fileUpload {
    position: relative;
    overflow: hidden;
}
.fileUpload #logo-id {
    position: absolute;
    top: 0;
    right: 0;
    margin: 0;
    padding: 0;
    font-size: 33px;
    cursor: pointer;
    opacity: 0;
    filter: alpha(opacity=0);
}
.img-preview {
    max-width: 100%;
}
</style>
@endsection
@section('scripts')
<script type="text/javascript">
  $(document).ready(function() {
    var brand = document.getElementById('logo-id');
    brand.className = 'attachment_upload';
    brand.onchange = function() {
        document.getElementById('fakeUploadLogo').value = this.value.substring(12);
    };

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
                $('.img-preview').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#logo-id").change(function() {
        readURL(this);
    });
    function confirmedit(){
        if(confirm("Bạn có muốn thay đổi thông tin?")){
            return true;
        }
        return false;
    }
});

</script>
@endsection


@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <form class="form-horizontal" action="{{ route('admin.qlnhansu.createAction') }}" method="POST" id="form-edit" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="card-body">
            @if(count($errors)>0)
                    <div class="alert alert-danger error">
                        @foreach($errors->all() as $error)
                            {{$error}}<br/>
                        @endforeach
                    </div>
            @endif
            <h4 class="card-title">Đăng ký thông tin cá nhân</h4>
            @if (session('status'))
                <div class="alert alert-danger">{{session('status')}}</div>
            @endif
            <div class="form-group row">
              <label class="col-md-3 control-label col-form-label">Hình ảnh</label>
              <div class="col-md-9">
                <div class="main-img-preview">
                  <img class="thumbnail img-preview" src="#" title="Preview Logo" width="100">
                </div>
                <div class="input-group">
                  <input id="fakeUploadLogo" class="form-control fake-shadow" placeholder="File name" disabled="disabled">
                  <div class="input-group-btn">
                    <div class="fileUpload btn btn-danger fake-shadow">
                      <span><i class="glyphicon glyphicon-upload"></i> Upload Image</span>
                      <input id="logo-id" type="file" class="attachment_upload form-control" name="txthinhanh" id="txthinhanh">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-3 control-label col-form-label">Tên nhân viên</label>
              <div class="col-md-9 mc-form-input">
                <input type="text" class="form-control" name="txttennhanvien" id="txttennhanvien" value="">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-3 control-label col-form-label">Username</label>
              <div class="col-md-9 mc-form-input">
                <input type="text" class="form-control" name="txtaccount" id="txtaccount" value="">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-3 control-label col-form-label">Mật khẩu</label>
              <div class="col-md-9 mc-form-input">
                <input type="text" class="form-control" name="txtpass" id="txtpass" value="">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-3 control-label col-form-label">Email</label>
              <div class="col-md-9 mc-form-input">
                <input type="email" class="form-control" name="txtemail" id="txtemail" value="">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-3 control-label col-form-label">Số điện thoại di động</label>
              <div class="col-md-9 mc-form-input">
                <input type="number" class="form-control" name="txtphone" id="txtphone" value="">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-3 control-label col-form-label">Số chứng minh nhân dân</label>
              <div class="col-md-9 mc-form-input">
                <input type="number" class="form-control" name="txtcmnd" id="txtcmnd" value="">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-3 control-label col-form-label">Giới tính</label>
              <div class="col-md-9 mc-form-input">
                <select class="form-control" name="opGioiTinh">
                  <option value="1">Nữ</option>
                  <option value="0" selected>Nam</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-3 control-label col-form-label">Ngày sinh</label>
              <div class="col-md-9 mc-form-input">
                <input class="form-control" type="date"  id="example-date-input" name="txtday" required>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-3 control-label col-form-label">Địa chỉ</label>
              <div class="col-md-9 mc-form-input">
                <input type="text" class="form-control" name="txtaddress" id="txtaddress" value="">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-3 control-label col-form-label">Số tài khoản</label>
              <div class="col-md-9 mc-form-input">
                <input type="text" class="form-control" name="txtnumberbank" id="txtnumberbank" value="">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-3 control-label col-form-label">Ngân hàng</label>
              <div class="col-md-9 mc-form-input">
                <input type="text" class="form-control" name="txtnamebank1" id="txtnamebank1" value="">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-3 control-label col-form-label">Chi nhánh ngân hàng</label>
              <div class="col-md-9 mc-form-input">
                <input type="text" class="form-control" name="txtnamebank2" id="txtnamebank2" value="">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-3 control-label col-form-label">Mã người giới thiệu</label>
              <div class="col-md-9 mc-form-input">
                <input type="text" class="form-control" name="txtmagioithieu" id="txtmagioithieu" value="{{ $template['magioithieu'] }}">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-3 control-label col-form-label">Trạng thái</label>
              <div class="col-md-9 mc-form-input">
                <select class="form-control" name="opTrangthai">
                  <option value="0" selected>Chưa phê duyệt</option>
                </select>
              </div>
            </div>
          </div>
          <div class="border-top">
            <div class="card-body float-right">
              <button type="submit" class="btn btn-primary" onclick="return confirm('Bạn có muốn đăng ký thông tin người dùng ?')">Đăng ký</button>
              <a href="{{ route('admin.qlnhansu') }}" class="btn btn-secondary">Quay lại</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection