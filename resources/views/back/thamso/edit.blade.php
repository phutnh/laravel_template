@extends('back.layouts.app')
@section('styles')
@endsection
@section('scripts')
<script type="text/javascript">
  $(function() {
     $('#flash').delay(2500).fadeOut(800);
  });
</script>
@endsection


@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
         @include('back.partials.ajax_form_messages')
        <form class="form-horizontal" action="{{ route('admin.thamso.action', $thamso->id) }}" method="POST" id="form-edit" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="card-body">
            @if(count($errors)>0)
                    <div class="alert alert-danger error">
                        @foreach($errors->all() as $error)
                            {{$error}}<br/>
                        @endforeach
                    </div>
            @endif
            <h4 class="card-title">Chỉnh sửa tham số hoa hồng</h4>
            <div class="form-group row">
              <label class="col-md-3 control-label col-form-label">Mã tham số</label>
              <div class="col-md-9 mc-form-input">
                <input type="text" class="form-control" name="txtmathamso" id="txtmathamso" value="{{ $thamso->mathamso }}"  readonly>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-3 control-label col-form-label">Tên tham số</label>
              <div class="col-md-9 mc-form-input">
                <input type="text" class="form-control" name="txttenthamso" id="txttenthamso" value="{{ $thamso->tenthamso }}" maxlength="50" placeholder="Tên tham số">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-3 control-label col-form-label">Mô tả thông tin tham số</label>
              <div class="col-md-9 mc-form-input">
                <textarea class="form-control" rows="10" name="txtthongtinthamso" id="txtthongtinthamso" maxlength="500" placeholder="Mô tả thông tin tham số">{!! $thamso->mota !!}</textarea>
              </div>
            </div><div class="form-group row">
              <label class="col-md-3 control-label col-form-label">Giá trị tham số</label>
              <div class="col-md-9 mc-form-input">
                <input type="number" class="form-control" min="0" max="100" name="txtgiatrithamso" id="txtgiatrithamso" value="{{ $thamso->giatrithamso }}" placeholder="Tên tham số">
              </div>
            </div>
          </div>
          <div class="border-top">
            <div class="card-body">
              <button type="submit" class="btn btn-primary" onclick="return confirm('Bạn có muốn cập nhật giá trị tham số ?')">Lưu thay đổi</button>
              <a href="{{ route('admin.thamso.index') }}" class="btn btn-secondary">Quay lại</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection