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
      <div class="table-responsive">
        <table class="table table-hover my-0" id="datatables-orders">
          <thead>
            <tr>
              <th class="d-xl-table-cell">Order</th>
              <th class="d-xl-table-cell">Customer</th>
              <th class="d-xl-table-cell">Address</th>
              <th class="d-xl-table-cell">Product</th>
              <th class="d-xl-table-cell">Prices</th>
              <th>Recovered</th>
              <th>Action</th>
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
                  <i class="align-middle me-2 fas fa-fw fa-shopping-cart"></i>
                  <span class="badge bg-{{$order->State()=='Delivered'?'danger':($order->State()=='Ready'?'warning':'success')}}">
                    {{$order->State()}}
                  </span>
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
                <i class="align-middle me-2 fas fa-fw fa-ad"></i> <a href="{{route('webmaster_campaigns_show', $order->campaign)}}">{{$order->Campaign()->name}}</a><br>
                  <i class="align-middle me-2 fas fa-fw fa-box"></i> <a href="{{route('webmaster_products_show', $order->product)}}">{{$order->Product()->name}}</a><br>
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
              <td class="single-line">
                <p>
                  <i class="align-middle me-2 fas fa-fw fa-user"></i> {{$order->Recovered_by()->name}}<br>
                  <i class="align-middle me-2 fas fa-fw fa-calendar"></i> {{$order->recovered_at}}
                </p>
              </td>
              <td>
                @if($data['can_archive'] && $order->State() == "Recovered")
                <a href="{{route('webmaster_orders_archive', $order->id)}}" class="btn btn-primary" >
                  Archive
                </a>
                @endif
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
		</div>
    
  {{ $data["orders"]->links('components.pagination') }}
  </div>
</div>

@endsection