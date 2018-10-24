<script type="text/javascript">
function ajaxDataChartDoanhThu() {
	$.ajax({
		url: "{{ route('api.doanhthu.bieudo') }}",
		method: "POST",
		headers: {
	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	  },
	  data: {
	  	"start_year": $('#start_year').val()
	  },
	  dataType: "json",
		success: function(data) {
			var thangchot = [];
			var doanhthu = [];
			for(var i in data) {
				thangchot.push(data[i].thangchot);
				doanhthu.push(new ValueCharjs(data[i].sotien, {
				  tooltip : "Doanh thu " + data[i].thangchot
				}));
			}
			generateChartDoanhThu(thangchot, doanhthu);
		},
		error: function(data) {
		}
	});
}

function generateChartDoanhThu(thangchot, doanhthu) {
	var ctxDoanhThu = document.getElementById("chart-doanhthu");
	data = {
	  labels: thangchot,
	  datasets: 
	  [
	    {
	      label: 'Số tiền',
	      data: doanhthu,
	      "fill": false,
	      "backgroundColor": "rgba(255, 99, 132, 0.2)",
	      "borderColor": "rgb(255, 99, 132)",
	      "borderWidth": 1
	    },
	  ]
	};

	var chartDoanhThu = new Chart(ctxDoanhThu, {
	  type: 'bar',
	  data: data,
	  options: {
	    scales: {
	      yAxes: [{
	          ticks: {
	          beginAtZero:true,
	          callback: function(value, index, values) {
              if(parseInt(value) > 999){
                  return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
              } else if (parseInt(value) < -999) {
                  return Math.abs(value).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
              } else {
                  return value;
              }
            }
	        }
	      }]
	    },
	    title: {
	      display: true,
	      text: 'Biểu đồ doanh thu (tháng)'
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
}

$('#btn-search-bieudo-doanhthu').click(function() {
	$('#chart-doanhthu').remove();
	$('.wrapper_chart_doanhthu').append(`<canvas id="chart-doanhthu" height="150"></canvas>`);
	ajaxDataChartDoanhThu();
});

ajaxDataChartDoanhThu();
</script>