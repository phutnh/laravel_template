@extends('back.layouts.app')
@section('styles')
@endsection
@section('scripts')
<script src="{{ asset(config('setting.admin.path_js') . 'chart.min.js') }}"></script>
<script type="text/javascript">
$('#data-hopdong').DataTable({
  "language": languageDatatable,
});
</script>
@include('back.report.bieudo_doanhthu')
@include('back.report.bieudo_hopdong')
@endsection

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <div class="d-md-flex align-items-center">
                <div>
                  <h4 class="card-title">Danh sách hợp đồng đã duyệt</h4>
                  <h5 class="card-subtitle">Trong tháng {{ date('m-Y') }}</h5>
                </div>
              </div>
              <div class="table-responsive">
                 <table id="data-hopdong" class="table table-striped table-bordered">
                    <thead>
                     <tr>
                        <th>Số hợp đồng</th>
                        <th>Tên hợp đồng</th>
                        <th>Khách hàng</th>
                        <th>Giá trị</th>
                        <th>Trạng thái</th>
                        <th>Email</th>
                        <th width="auto">Công cụ</th>
                     </tr>
                    </thead>
                    <tbody>
                      @foreach ($data['danhsachhopdong'] as $hopdong)
                      <tr>
                        <th>{{ $hopdong->sohopdong }}</th>
                        <th>{{ $hopdong->tenhopdong }}</th>
                        <th>{{ $hopdong->khachhang }}</th>
                        <th>{{ formatMoneyData($hopdong->giatri) }}</th>
                        <th>{{ $hopdong->trangthai }}</th>
                        <th>{{ $hopdong->email }}</th>
                        <th width="auto">
                          <a class="btn btn-info btn-sm" href="{{ route('admin.hopdong.update', $hopdong->id) }}" target="_blank">
                            <i class="mdi mdi-link"></i>Chi tiết
                          </a>
                        </th>
                       </tr>
                      @endforeach
                    </tbody>
                 </table>
              </div>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-md-9">
              <div class="d-md-flex align-items-center">
                <div class="col-md-12">
                  <h4 class="card-title">Biểu đồ doanh thu</h4>
                  <h5 class="card-subtitle">Trong tháng</h5>
                  <div class="form-inline float-sm-right">
                    <div class="input-group mb-2 mr-sm-2">
                      <div class="input-group-prepend">
                        <div class="input-group-text">Thời gian bắt đầu</div>
                      </div>
                      @php
                      $selecteYear = date('Y');
                      @endphp
                      <select name="start_year" id="start_year" class="form-control">
                        @for ($year = 2017; $year <= date('Y'); $year++)
                          <option value="{{ $year }}" {{ $selecteYear == $year ? 'selected' : '' }}>Năm {{ $year }}</option>
                        @endfor
                      </select>
                    </div>
                    <div class="input-group mb-2">
                      <div class="input-group-prepend">
                          <div class="input-group-text btn btn-success" id="btn-search-bieudo-doanhthu">
                          <i class="fas fa-search m-r-10"></i>Lọc
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="wrapper_chart_doanhthu">
                <canvas id="chart-doanhthu" height="150"></canvas>
              </div>
              <hr>
              <div class="d-md-flex align-items-center">
                <div class="col-md-12">
                  <h4 class="card-title">Biểu đồ hợp đồng</h4>
                  <h5 class="card-subtitle">Theo ngày</h5>
                  <div class="form-inline float-sm-right">
                    <div class="input-group mb-2 mr-sm-2">
                      <div class="input-group-prepend">
                        <div class="input-group-text">Thời gian bắt đầu</div>
                      </div>
                      <input type="date" class="form-control" id="start_date" placeholder="Thời gian bắt đầu" value="{{ getFristDayOfMonth() }}">
                    </div>
                     <div class="input-group mb-2 mr-sm-2">
                      <div class="input-group-prepend">
                        <div class="input-group-text">Thời gian bắt đầu</div>
                      </div>
                      <input type="date" class="form-control" id="end_date" placeholder="Thời gian kết thúc" value="{{ getLastDayOfMonth() }}">
                    </div>
                    <div class="input-group mb-2">
                      <div class="input-group-prepend">
                          <div class="input-group-text btn btn-success" id="btn-search-bieudo-hopdong">
                          <i class="fas fa-search m-r-10"></i>Lọc
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="wrapper_chart_hopdong">
                <canvas id="chart-hopdong" height="150"></canvas>
              </div>
            </div>
            <div class="col-md-3">
              <div class="d-md-flex align-items-center">
                <div>
                  <h4 class="card-title">Thông tin cơ bản</h4>
                  <h5 class="card-subtitle">Dữ liệu</h5>
                </div>
              </div>
              <div class="row">
                <div class="col-6 m-t-5">
                  <a href="{{ route('admin.hopdong.index') }}">
                    <div class="bg-success p-10 text-white text-center">
                      <i class="fa fa-plus m-b-5 font-16"></i>
                      <h5 class="m-b-0 m-t-5">{{ formatMoneyData($data['soluonghopdong']) }}</h5>
                      <small class="font-light">
                        Hợp đồng
                      </small>
                    </div>
                    </a>
                </div>
                @if(isAdminCP())
                <div class="col-6 m-t-5">
                  <a href="{{ route('admin.qlnhansu') }}">
                    <div class="bg-dark p-10 text-white text-center">
                      <i class="fa fa-user m-b-5 font-16"></i>
                      <h5 class="m-b-0 m-t-5">{{ formatMoneyData($data['soluongnhanvien']) }}</h5>
                      <small class="font-light">
                        Nhân viên
                      </small>
                    </div>
                  </a>
                </div>
                @endif
                <div class="col-6 m-t-5">
                  <a href="{{ route('admin.commission.history') }}">
                    <div class="bg-cyan p-10 text-white text-center">
                      <i class="fa fa-cart-plus m-b-5 font-16"></i>
                      <h5 class="m-b-0 m-t-5">{{ formatMoneyData(Auth::user()->hoahongtamtinh) }}</h5>
                      <small class="font-light">Hoa hồng</small>
                    </div>
                  </a>
                </div>
                <div class="col-6 m-t-5">
                  <div class="bg-info p-10 text-white text-center">
                    <i class="fa fa-cart-plus m-b-5 font-16"></i>
                    <h5 class="m-b-0 m-t-5">{{ formatMoneyData(Auth::user()->soduthucte) }}</h5>
                    <small class="font-light">Số dư</small>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection