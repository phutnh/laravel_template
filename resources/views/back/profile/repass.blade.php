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
        <form class="form-horizontal" action="{{ route('user.profile.repassaction', $user->id) }}" method="POST" id="form-edit" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="card-body">
             @if (session()->has('danger'))
               <div class="alert alert-danger" role="alert" id="flash">
                  <i class="mdi mdi-check"></i> {{session()->get('danger')}}
               </div>
             @endif
             @if(count($errors)>0)
                    <div class="alert alert-danger error">
                        @foreach($errors->all() as $error)
                            {{$error}}<br/>
                        @endforeach
                    </div>
            @endif
            <h4 class="card-title">Thay đổi mật khẩu</h4>
            <div class="form-group row">
              <label class="col-md-3 control-label col-form-label">Mật khẩu cũ</label>
              <div class="col-md-9 mc-form-input">
                <input type="password" class="form-control" name="txtpass" id="txtpass">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-3 control-label col-form-label">Mật khẩu mới</label>
              <div class="col-md-9 mc-form-input">
                <input type="password" class="form-control" name="txtrepass" id="txtrepass">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-3 control-label col-form-label">Xác nhận lại mật khẩu</label>
              <div class="col-md-9 mc-form-input">
                <input type="password" class="form-control" name="txtconfirmrepass" id="txtconfirmrepass">
              </div>
            </div>
          </div>
          <div class="border-top">
            <div class="card-body float-right">
              <button type="submit" class="btn btn-primary" onclick="return confirm('Bạn có muốn cập nhật mật khẩu ?')">Lưu thay đổi</button>
              <a href="{{ route('user.profile.view') }}" class="btn btn-secondary">Quay lại</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection