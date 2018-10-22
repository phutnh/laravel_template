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
<script type="text/javascript">
v1 = new ValueCharjs(20, {
  tooltip : 'Doanh thu tháng 1 là 2,000,000'
})

v2 = new ValueCharjs(30, {
  tooltip : 'Doanh thu tháng 2 là 5,000,000'
})
data = {
  labels: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6'],
  datasets: 
  [
    {
      label: 'Số hợp đồng',
      data: [v1, v2, v1, v2, v1, v2],
      "fill": false,
      "backgroundColor": "rgba(255, 99, 132, 0.2)",
      "borderColor": "rgb(255, 99, 132)",
      "borderWidth": 1
    },
  ]
};
var ctx = document.getElementById("chart-home");
var chartHome = new Chart(ctx, {
  type: 'bar',
  data: data,
  options: {
    scales: {
      yAxes: [{
          ticks: {
          beginAtZero:true
        }
      }]
    },
    title: {
      display: true,
      text: 'Biểu đồ doanh thu'
    },
    tooltips: {
      enabled: true,
      mode: 'single',
      callbacks: {
        title: function (tooltipItems, data) {
          return data.datasets[0].data[tooltipItems[0].index].metadata.tooltip;
        },
        label: function(tooltipItem, data) {
          var label = data.datasets[tooltipItem.datasetIndex].label;
          var datasetLabel = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
          return label + ': ' + addCommas(datasetLabel) ;
        }
      }
    }, 
  }
});

</script>
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
                  <h4 class="card-title">Danh sách hợp đồng</h4>
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
            <div class="col-md-12">
              <div class="d-md-flex align-items-center">
                <div>
                  <h4 class="card-title">Thông tin cơ bản</h4>
                  <h5 class="card-subtitle">Trong tháng</h5>
                </div>
              </div>
            </div>
            <div class="col-md-9">
              <canvas id="chart-home" height="200"></canvas>
            </div>
            <div class="col-md-3">
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