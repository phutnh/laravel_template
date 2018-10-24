@extends('back.layouts.app')
@section('styles')
@endsection
@section('scripts')
<script>
function searchDoanhThu(checkin) {
  data = {
    "thangchot": $('#thangchot').val(),
    "lanin": false
  };

  if (checkin == true)
  {
    if (!printContent('printAble'))
      return false;

    data = {
    "thangchot": $('#thangchot').val(),
      "lanin": true
    };
  }

  $.ajax({
    url: "{{ route('api.doanhthu.thang') }}",
    method: "POST",
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    data: data,
    dataType: "html",
    success: function(data) {
      $('#ajax_doanhthu').html(data);
      check = $('#data_doanhthu_table').data('check');
      if (check == 'ok')
        $('#btn_print').css({"display": "block"});
      else
        $('#btn_print').css({"display": "none"});
    },
    beforeSend: function() {
      $('#ajax-messases-loading').css({ "display": "block" });
    },
    complete: function() {
      $('#ajax-messases-loading').css({ "display": "none" });
    },
    error: function(data) {
    }
  });
}
</script>
@endsection
@section('content')
<div class="container-fluid">
 <div class="row">
    <div class="col-md-12">
      <div class="card card-body printableArea">
          <div class="row">
            <div class="col-md-12">
              <h5 class="card-title">Doanh thu nhân viên</h5>
              <div class="form-inline float-sm-right">
                <div class="input-group mb-2 mr-sm-2">
                  <div class="input-group-prepend">
                    <div class="input-group-text">Chọn tháng</div>
                  </div>
                  @php
                  $prevMonth = (date('m') - 1);
                  $prevMonth = $prevMonth < 10 ? ('0'.$prevMonth) : $prevMonth;
                  $selected = date('Y').'/'.$prevMonth;
                  @endphp
                  <select id="thangchot" class="form-control">
                    @for ($year = 2018; $year <= date('Y'); $year++)
                      <optgroup label="{{ $year }}">
                        @for ($month = 1; $month < 12; $month++)
                          @php
                          $month = $month < 10 ? ('0'.$month) : $month;
                          $value = $year.'/'.$month;
                          @endphp
                          <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>
                            Tháng {{ $month }} / {{ $year }}
                          </option>
                        @endfor
                      </optgroup>
                    @endfor
                  </select>
                </div>
                <div class="input-group mb-2 mr-sm-2">
                  <div class="input-group-prepend">
                    <div class="input-group-text btn btn-success" onclick="return searchDoanhThu(false);">
                      <i class="fas fa-search m-r-10"></i>Lọc
                    </div>
                  </div>
                </div>
                @if ($doanhthu)
                <div class="input-group mb-2">
                  <div class="input-group-text btn btn-info" id="btn_print" onclick="return searchDoanhThu(true);">
                    <i class="m-r-10 mdi mdi-printer"></i> In phiếu chi
                  </div>
                </div>
                @endif
              </div>
              <h3>Chi tiết doanh thu</h3>
              <hr>
              <div id="ajax_doanhthu">
                @include('back.doanhthu.table', ['doanhthu' => $doanhthu])
              </div>
            </div>
        </div>
      </div>
    </div>
 </div>
</div>
@endsection