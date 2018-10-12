@extends('back.layouts.app')
@section('styles')
@endsection
@section('scripts')
<script>
  $('#btnRut').click(function(){
            var sodu = $('#txtSoDu').val();
            sodu = sodu.replace(/[.]/g, '');
            sodu = parseFloat(sodu);
            var sorut = parseFloat($('#txtRutTien').val());
            
            if(isNaN(sorut)){
                alert("Số tiền cần rút phải là số nguyên!!!");
                return false;
            }
            
            if(sodu < sorut){
                alert("Số dư của bạn không đủ!!!");
                return false;
            }
            
            $.ajax({
               headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
               url: "{{ route('admin.withdraw.action') }}", 
               type: 'POST',
               data: {
                 sorut: sorut
               },
               dataType:"json",
               success: function(data){
                        $("#txtThongBao").html(data.msg);
                        $("#txtSoDu").val(data.sodu);
                        $("#txtRutTien").val(0);
                    }
            });
        });
</script>
@endsection
@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <div class="block-header">
            <h5 class="card-title">Rút tiền</h5>
            <div class="block-tool">
              <!--<a class="btn btn-danger" href="{{ route('admin.trans.detail') }}">Quay lại</a> -->
            </div>
          </div>
          
          <form class="form-horizontal">
            <div class="form-group">
              <label class="control-label col-xs-12 error-red" id="txtThongBao"> </label>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Số dư tài khoản </label>
              <div class="col-md-4 col-sm-4 col-xs-12">
                <input type="text" id="txtSoDu" class="form-control" disabled value="{{$template['soduthucte']}}"/>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Số tiền rút </label>
              <div class="col-md-4 col-sm-4 col-xs-12">
                <input type="text" id="txtRutTien" class="form-control" maxlength="9"/>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-8 col-md-offset-3 col-sm-8 col-sm-offset-3 col-xs-12">
                <button type="button" class="btn btn-info" ondblclick="return false;" id="btnRut">Rút tiền</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection