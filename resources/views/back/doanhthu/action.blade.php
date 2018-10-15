@extends('back.layouts.app')
@section('styles')
@endsection
@section('scripts')
<script src="{{ asset(config('setting.admin.path_js') . 'jquery.inputmask.min.js') }}"></script>
<script>
$(".date-inputmask").inputmask("dd/mm/yyyy");
apiData = "{{ route('api.doanhthu.data') }}";
</script>
<script src="{{ asset(config('setting.admin.path_js') . 'doanhthu.js') }}"></script>

@endsection

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
          @include('back.partials.ajax_form_messages')
          <div class="card-body">
            <form action="{{ route('api.doanhthu.action') }}" method="post" id="form-data-doanhthu">
            {{ csrf_field() }}
            <div class="block-header">
              <h5 class="card-title">Chốt doanh thu</h5>
              <div class="block-tool">
                <button class="btn btn-info btn-sm" name="action" value="approve" type="submit"><i class="mdi mdi-marker-check"></i> Chốt doanh thu</button>
              </div>
            </div>
            <div class="table-responsive">
              <table id="table-data-content" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th width="15" nowrap>
                      <label class="mc-container">&nbsp;
                        <input type="checkbox" value="all" id="ckb-select-all">
                        <span class="mc-checkmark"></span>
                      </label>
                    </th>
                    <th nowrap>Mã nhân viên</th>
                    <th nowrap>Tên nhân viên</th>
                    <th nowrap>Email</th>
                    <th nowrap>Số tiền</th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection