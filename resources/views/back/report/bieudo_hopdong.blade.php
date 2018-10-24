<script type="text/javascript">
function ajaxDataChartHopDong() {
	$.ajax({
		url: "{{ route('api.hopdong.bieudo') }}",
		method: "POST",
		headers: {
	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	  },
	  dataType: "json",
	  data: {
	  	"start_date": $('#start_date').val(),
	  	"end_date": $('#end_date').val(),
	  },
		success: function(data) {
			var thangchot = [];
			var tonghopdong = [];
			for(var i in data) {
				thangchot.push(data[i].nd);
				tonghopdong.push(new ValueCharjs(data[i].tonghopdong, {
				  tooltip : "Ngày " + data[i].nd
				}));
			}
			generateChartHopDong(thangchot, tonghopdong);
		},
		error: function(data) {
			return 'Error';
		}
	});
}
// Call ajax
ajaxDataChartHopDong();

$('#btn-search-bieudo-hopdong').click(function() {
	$('#chart-hopdong').remove();
	$('.wrapper_chart_hopdong').append(`<canvas id="chart-hopdong" height="150"></canvas>`);
	ajaxDataChartHopDong();
});

function generateChartHopDong(thangchot, tonghopdong) {
	data = {
	  labels: thangchot,
	  datasets: 
	  [
	    {
	      label: 'Tổng hợp đồng',
	      data: tonghopdong,
	      "fill": false,
	      "backgroundColor": "rgba(255, 205, 86, 0.2)",
	      "borderColor": "rgb(255, 205, 86)",
	      "borderWidth": 1
	    },
	  ]
	};
	var ctxHopDong = document.getElementById("chart-hopdong");
	var chartHopDong = new Chart(ctxHopDong, {
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
	      text: 'Biểu đồ họp đồng (ngày)'
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

	chartHopDong.render();
}
</script>