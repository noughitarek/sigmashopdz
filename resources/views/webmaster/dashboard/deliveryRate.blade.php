<div class="col-12">
	<div class="card">
		<div class="card-header">
			<h5 class="card-title">Delivery & back rate over the last month</h5>
		</div>
		<div class="card-body">
			<div class="chart w-100">
				<div id="chart"></div>
			</div>
		</div>
	</div>
</div>
<script>
    var options = {
        series: [{
        name: 'Delivery',
        data: [
            @foreach(\Carbon\CarbonPeriod::create(Carbon\Carbon::now()->subMonth(), Carbon\Carbon::now()) as $date)
                @if(isset($data['deliveryOrdersPerDay'][$date->format("Y-m-d")]))
                    {{count($data['deliveryOrdersPerDay'][$date->format("Y-m-d")])}}
                @else
                    0
                @endif
                ,
            @endforeach
            ]}
        ,{
        name: 'Delivered',
        data: [
            @foreach(\Carbon\CarbonPeriod::create(Carbon\Carbon::now()->subMonth(), Carbon\Carbon::now()) as $date)
                @if(isset($data['deliveredOrdersPerDay'][$date->format("Y-m-d")]))
                    {{count($data['deliveredOrdersPerDay'][$date->format("Y-m-d")])}}
                @else
                    0
                @endif
                ,
            @endforeach
        ]
        }, {
        name: 'Back',
        data: [
            @foreach(\Carbon\CarbonPeriod::create(Carbon\Carbon::now()->subMonth(), Carbon\Carbon::now()) as $date)
                @if(isset($data['backOrdersPerDay'][$date->format("Y-m-d")]))
                    {{count($data['backOrdersPerDay'][$date->format("Y-m-d")])}}
                @else
                    0
                @endif
                ,
            @endforeach
        ]
        }, {
        name: 'Canceled',
        data: [
            @foreach(\Carbon\CarbonPeriod::create(Carbon\Carbon::now()->subMonth(), Carbon\Carbon::now()) as $date)
                @if(isset($data['canceledOrdersPerDay'][$date->format("Y-m-d")]))
                    {{count($data['canceledOrdersPerDay'][$date->format("Y-m-d")])}}
                @else
                    0
                @endif
                ,
            @endforeach
        ]
        }, {
        name: 'Pending',
        data: [
            @foreach(\Carbon\CarbonPeriod::create(Carbon\Carbon::now()->subMonth(), Carbon\Carbon::now()) as $date)
                @if(isset($data['pendingOrdersPerDay'][$date->format("Y-m-d")]))
                    {{count($data['pendingOrdersPerDay'][$date->format("Y-m-d")])}}
                @else
                    0
                @endif
                ,
            @endforeach
        ]
        }
    ],
      chart: {
      type: 'bar',
      height: 350,
      stacked: true,
      stackType: '100%'
    },
    stroke: {
      width: 1,
      colors: ['#ff']
    },
    xaxis: {
      categories: [
        @foreach(\Carbon\CarbonPeriod::create(Carbon\Carbon::now()->subMonth(), Carbon\Carbon::now()) as $date)
            '{{$date->format("d M")}}',
        @endforeach
    ],
    },
    tooltip: {
      y: {
        formatter: function (val) {
          return val
        }
      }
    },
    fill: {
      opacity: 1
    
    },
    legend: {
      position: 'top',
      offsetX: 40
    }
    };
    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
</script>