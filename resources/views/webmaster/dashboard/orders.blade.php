<div class="col-sm-12 col-xl-4">
    <div class="card">
        <div class="card-header">
            <div class="card-actions float-end">
                <div class="col-auto">
                    <select class="form-select form-select-sm bg-light border-0" id="ordersMonthSelect" role="tablist">
                        @foreach($data['dashboard']::months() as $key=>$month)
                        <option value="#orders{{$month['start_timestamp']}}" {{$key==(count($data['dashboard']::months())-1)?'selected':''}}>{{$month['formatted']}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col mt-1">
                    <h5 class="card-title">Orders</h5>
                </div>
            </div>  
        </div>
        <div class="card-body">
            <div class="tab-content">
                @foreach($data['dashboard']::months() as $key=>$month)
                <div class="tab-pane tab-pane-orders fade {{$key==(count($data['dashboard']::months())-1)?'show active':''}}" id="orders{{$month['start_timestamp']}}" role="tabpanel">
                    <div class="row">
                        <div class="col mt-0">
                            <label for="value{{$month['start_timestamp']}}">{{$month['formatted']}}</label>
                            <h2 id="value{{$month['start_timestamp']}}">{{$data['dashboard']::getOrders($month)}}</h2>
                        </div>
                        <div class="col-auto">
                            <div class="stat text-primary">
                                <i class="align-middle" data-feather="shopping-cart"></i>
                            </div>
                        </div>
                    </div>
                    @if($key==(count($data['dashboard']::months())-1))
                    <div class="mb-0">
                        <span class="text-muted">All time data</span>
                    </div>
                    @elseif($key != 0)
                    <div class="mb-0">
                        <span class="badge badge-{{$data['dashboard']::changes($data['dashboard']::getOrders($month), $data['dashboard']::getorders($data['dashboard']::months()[$key-1]))>=0?'success':'danger'}}-light"> <i class="mdi mdi-arrow-bottom-right"></i> {{abs($data['dashboard']::changes($data['dashboard']::getorders($month), $data['dashboard']::getorders($data['dashboard']::months()[$key-1])))}}% </span>
                        <span class="text-muted">Since {{$data['dashboard']::months()[$key-1]['formatted']}}</span>
                    </div>
                    @else
                    <div class="mb-0">
                        <span class="badge badge-success-light"> <i class="mdi mdi-arrow-bottom-right"></i> 100%</span>
                        <span class="text-muted">No data before {{$month['formatted']}}</span>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('ordersMonthSelect').addEventListener('change', function() {
        var selectedTab = this.value;
        var tabPane = document.querySelector(selectedTab);
        document.querySelectorAll('.tab-pane-orders').forEach(function(pane) {
            pane.classList.remove('show', 'active');
        });
        tabPane.classList.add('show', 'active');
    });
</script>