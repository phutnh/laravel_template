@extends('back.layouts.app')
@section('styles')
@endsection
@section('scripts')
<script>
apiData = "{{ route('api.hoahong.all') }}";
</script>
<script src="{{ asset(config('setting.admin.path_js') . 'doanhthu.js') }}"></script>
@endsection

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        @include('back.partials.ajax_form_messages')
        <form action="{{ route('api.doanhthu.action') }}" method="post" id="form-data-doanhthu">
          {{ csrf_field() }}
          <div class="card-body">
            <div class="block-header">
              <h5 class="card-title">Chốt doanh thu</h5>
              <div class="block-tool">
                <button class="btn btn-info btn-sm" name="action" value="approve" type="submit"><i class="mdi mdi-marker-check"></i> Chốt doanh thu</button>
              </div>
            </div>
            <div class="form-group row" style="justify-content: flex-end;">
              <label class="control-label col-form-label">Thời gian bắt đầu</label>
              <div class="col-md-2 mc-form-input">
                <input type="text" class="form-control" id="start-date" placeholder="Thời gian bắt đầu">
              </div>
               <label class="control-label col-form-label">Thời gian kết thúc</label>
              <div class="col-md-2 mc-form-input">
                <input type="text" class="form-control" id="end-date" placeholder="Thời gian kết thúc">
              </div>
              <div class="mc-form-input">
                <button class="btn btn-success" type="button" id="btn-search">
                  <i class="fas fa-search m-r-10"></i>Tìm kiếm nâng cao</button>
              </div>
            </div>
            <hr>
            <div class="table-responsive">
              <table id="table-data-content" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th width="15">
                      <label class="mc-container">&nbsp;
                        <input type="checkbox" value="all" id="ckb-select-all">
                        <span class="mc-checkmark"></span>
                      </label>
                    </th>
                    <th>Nhân viên</th>
                    <th>Số hợp đồng</th>
                    <th>Hợp đồng</th>
                    <th>Số tiền</th>
                    <th width="70">Hình thức</th>
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