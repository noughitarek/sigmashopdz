<div class="col-12">
    <div class="card flex-fill">
        <div class="card-header">
            <div class="card-actions float-end">
                <div class="col-auto">
                    <select class="form-select form-select-sm bg-light border-0" id="productMonthSelect" role="tablist">
                        @foreach($data['dashboard']::months() as $key=>$month)
                        <option value="#product{{$month['start_timestamp']}}" {{$key==(count($data['dashboard']::months())-1)?'selected':''}}>{{$month['formatted']}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col mt-1">
                    <h5 class="card-title">Products</h5>
                </div>
            </div>  
        </div>
        <div class="card-body">
            <div class="tab-content">
                @foreach($data['dashboard']::months() as $key=>$month)
                <div class="table-responsive tab-pane tab-pane-product fade {{$key==(count($data['dashboard']::months())-1)?'show active':''}}" id="product{{$month['start_timestamp']}}" role="tabpanel">
                    <table class="table table-borderless my-0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th class="text-end">Activities</th>
                                <th class="text-end">Orders</th>
                                <th class="text-end">Order/Activity</th>
                                <th>Revenue</th>
                                <th>Income</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['dashboard']::Products($month) as $product)
                            <tr>
                                <td>
                                    <div class="d-flex">
                                        <div class="flex-shrink-0">
                                            <div class="bg-light rounded-2">
                                                <img class="feather2 img-fluid" src="{{$product['photo']}}" alt="{{$product['name']}}">
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <strong>{{$product['name']}}</strong>
                                            <div class="text-muted">
                                                {{$product['category']}}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-end">
                                    {{$product['activities']}}
                                </td>
                                <td class="text-end">
                                    {{$product['orders']}}
                                </td>
                                <td class="text-end">
                                    {{$product['orderPerActivity']}}%
                                </td>
                                <td>{{$product['revenue']}} DZD</td>
                                <td>{{$product['income']}} DZD</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('productMonthSelect').addEventListener('change', function() {
        var selectedTab = this.value;
        var tabPane = document.querySelector(selectedTab);
        document.querySelectorAll('.tab-pane-product').forEach(function(pane) {
            pane.classList.remove('show', 'active');
        });
        tabPane.classList.add('show', 'active');
    });
</script>