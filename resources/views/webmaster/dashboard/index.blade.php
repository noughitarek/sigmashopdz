@extends('layouts.webmaster')
@section('content')
<div class="container-fluid p-0">
    <div class="row mb-2 mb-xl-3">
        <div class="col-auto d-none d-sm-block">
            <h3><strong>E-Commerce</strong> Dashboard</h3>
        </div>
        <div class="col-auto ms-auto text-end mt-n1">
            <a href="#" class="btn btn-light bg-white me-2">Invite a Friend</a>
            <a href="#" class="btn btn-primary">New Project</a>
        </div>
    </div>
    <div class="row">
        @if(Auth::user()->Has_permission("consult_all_orders"))
        <div class="col-12 col-lg-12 col-xxl-3 d-flex">
            <div class="card flex-fill">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title">Unvalidated payments</h5>
                        </div>
                        <div class="col-auto">
                            <a href="{{route('webmaster_admins_payement_validate')}}" class="btn btn-sm btn-primary" for="send">Validate</a>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3">{{$data["payedUnvalidated"]}} DZD</h1>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title">Income</h5>
                        </div>
                        <div class="col-auto">
                            <div class="stat text-primary">
                                <i class="align-middle" data-feather="dollar-sign"></i>
                            </div>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3">{{$data["lastMonthIncome"]}} DZD</h1>
                    <div class="mb-0">
                        <span class="badge badge-{{$data['lastMonthIncomeVar']>=0?'success':'danger'}}-light"> <i class="mdi mdi-arrow-bottom-right"></i> {{$data['lastMonthIncomeVar']}}% </span>
                        <span class="text-muted">Since last month</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title">Orders</h5>
                        </div>
                        <div class="col-auto">
                            <div class="stat text-primary">
                                <i class="align-middle" data-feather="shopping-bag"></i>
                            </div>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3">{{$data["lastMonthOrders"]}}</h1>
                    <div class="mb-0">
                        <span class="badge badge-{{$data['lastMonthIncomeVar']>=0?'success':'danger'}}-light"> <i class="mdi mdi-arrow-bottom-right"></i> {{$data['lastMonthIncomeVar']}}% </span>
                        <span class="text-muted">Since last month</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title">Activity</h5>
                        </div>
                        <div class="col-auto">
                            <div class="stat text-primary">
                                <i class="align-middle" data-feather="activity"></i>
                            </div>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3">{{$data["lastMonthActivity"]}}</h1>
                    <div class="mb-0">
                        <span class="badge badge-{{$data['lastMonthActivityVar']>=0?'success':'danger'}}-light"> <i class="mdi mdi-arrow-bottom-right"></i> {{$data['lastMonthActivityVar']}}% </span>
                        <span class="text-muted">Since last month</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title">Revenue</h5>
                        </div>
                        <div class="col-auto">
                            <div class="stat text-primary">
                                <i class="align-middle" data-feather="shopping-cart"></i>
                            </div>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3">{{$data["lastMonthRevenue"]}} DZD</h1>
                    <div class="mb-0">
                        <span class="badge badge-{{$data['lastMonthRevenueVar']>=0?'success':'danger'}}-light"> <i class="mdi mdi-arrow-bottom-right"></i> {{$data["lastMonthRevenueVar"]}}% </span>
                        <span class="text-muted">Since last month</span>
                    </div>
                </div>
            </div>
        </div>
        @endif
        
		<div class="col-12 col-lg-12">
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
    </div>
</div>
@endsection
@section("scripts")
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
@endsection