@extends('back.layouts.app')
@section('styles')
@endsection
@section('scripts')
<script src="{{ asset(config('setting.admin.path_js') . 'chart.min.js') }}"></script>
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
          <div class="d-md-flex align-items-center">
            <div>
              <h4 class="card-title">Thông tin cơ bản</h4>
              <h5 class="card-subtitle">Trong tháng</h5>
            </div>
          </div>
          <div class="row">
            <div class="col-md-9">
              <canvas id="chart-home" height="120"></canvas>
            </div>
            <div class="col-md-3">
              <div class="row">
                <div class="col-6">
                  <div class="bg-success p-10 text-white text-center">
                    <i class="fa fa-plus m-b-5 font-16"></i>
                    <h5 class="m-b-0 m-t-5">2540</h5>
                    <small class="font-light">Hợp đồng</small>
                  </div>
                </div>
                <div class="col-6">
                  <div class="bg-cyan p-10 text-white text-center">
                    <i class="fa fa-cart-plus m-b-5 font-16"></i>
                    <h5 class="m-b-0 m-t-5">656</h5>
                    <small class="font-light">Hoa hồng</small>
                  </div>
                </div>
                <div class="col-6 m-t-15">
                  <div class="bg-info p-10 text-white text-center">
                    <i class="fa fa-cart-plus m-b-5 font-16"></i>
                    <h5 class="m-b-0 m-t-5">656</h5>
                    <small class="font-light">Số dư</small>
                  </div>
                </div>
                <div class="col-6 m-t-15">
                  <div class="bg-dark p-10 text-white text-center">
                    <i class="fa fa-user m-b-5 font-16"></i>
                    <h5 class="m-b-0 m-t-5">656</h5>
                    <small class="font-light">Nhân viên</small>
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