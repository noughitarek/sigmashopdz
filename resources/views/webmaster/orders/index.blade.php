@extends('layouts.webmaster')
@section('content')
<div class="row">
  <div class="col-12 col-lg-12 col-xxl-12 d-flex">
    <div class="card flex-fill">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">{{$data["title"]}}</h5>
      </div>
    </div>
  </div>
  <div class="col-12 col-lg-12 col-xxl-12 d-flex">
    <div class="card flex-fill">
      <div class="card-header"></div>
      <div class="card-body">
        <table class="table table-hover my-0" id="orders_table">
          <thead>
            <tr>
              <th class="d-xl-table-cell">Order</th>
              <th class="d-xl-table-cell">Status</th>
              <th class="d-xl-table-cell">Customer</th>
              <th class="d-xl-table-cell">Address</th>
              <th class="d-xl-table-cell">Product</th>
              <th class="d-xl-table-cell">Prices</th>
            </tr>
          </thead>
          <tbody>
            @foreach($data["orders"] as $order)
            <tr>
              <td class="d-xl-table-cell single-line">
                <p>
                  <i class="align-middle me-2 fas fa-fw fa-hashtag"></i> <a href="{{route('webmaster_orders_show', $order->id)}}">{{$order->id}}</a><br>
                  <i class="align-middle me-2 fas fa-fw fa-calendar"></i> {{$order->created_at}}<br>
                  <i class="align-middle me-2 fas fa-fw fa-barcode"></i> <a target="_blank" href="https://suivi.ecotrack.dz/suivi/{{$order->tracking}}">{{$order->tracking}}</a><br>
                  <i class="align-middle me-2 fas fa-fw fa-barcode"></i> <a target="_blank" href="{{route('main_orders_tracking', $order->intern_tracking)}}">{{$order->intern_tracking}}</a><br>
                  <i class="align-middle me-2 fas fa-fw fa-shopping-cart"></i>
                  <span class="badge bg-success">
                    {{$order->State()}}
                  </span>
                </p>
              </td>
              <td class="d-xl-table-cell">
                <p>
                  @foreach($order->Status() as $status)
                  <span class="badge bg-{{$status[0]}}">
                    {{$status[1]}}
                  </span>
                  @endforeach
                </p>
              </td>
              <td class="d-xl-table-cell single-line">
                <p>
                  <i class="align-middle me-2 fas fa-fw fa-user-tie"></i> {{$order->name}}<br>
                  <i class="align-middle me-2 fas fa-fw fa-phone"></i> <a href="tel:{{$order->phone}}">{{$order->phone}}</a><br>
                  <i class="align-middle me-2 fas fa-fw"></i> <a href="tel:{{$order->phone}}">{{$order->phone2}}</a>
                </p>
              </td>
              <td class="d-xl-table-cell single-line">
                <p>
                  <i class="align-middle me-2 fas fa-fw fa-map-pin"></i> {{$order->address}}<br>
                  <i class="align-middle me-2 fas fa-fw fa-map"></i> {{$order->Commune()->name}} - {{$order->Wilaya()->name}}<br>
                  <i class="align-middle me-2 fas fa-fw fa-globe"></i> {{$order->ip}}
                </p>
              </td>
              <td class="d-xl-table-cell single-line">
                <p>
                  <i class="align-middle me-2 fas fa-fw fa-ad"></i> <a href="{{$order->campaign!=null?route('webmaster_campaigns_show', $order->campaign):'#'}}">{{$order->Campaign()->name}}</a><br>
                  <i class="align-middle me-2 fas fa-fw fa-box"></i> <a href="{{$order->product!=null?route('webmaster_products_show', $order->product):'#'}}">{{$order->Product()->name}}</a><br>
                  <i class="align-middle me-2 fas fa-fw fa-boxes"></i> {{$order->quantity}}
                </p>
              </td>
              <td class="d-xl-table-cell single-line">
                <p>
                <i class="align-middle me-2 fas fa-fw fa-wallet"></i> {{$order->total_price}} DZD<br>
                <i class="align-middle me-2 fas fa-fw fa-truck-loading"></i> {{$order->delivery_price}} DZD<br>
                <i class="align-middle me-2 fas fa-fw fa-dollar-sign"></i> {{$order->clean_price}} DZD
                </p>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
		</div>
  </div>
</div>

@endsection
@section('scripts')
<script src="{{asset('js/datatables.js')}}"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
	$("#orders_table").DataTable({
		responsive: true
	});
});
</script>
@endsection