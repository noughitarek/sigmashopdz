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
              <th>Deliveries attempts</th>
              <th>Shipped</th>
              <th>Validated</th>
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
                  <span class="badge bg-{{$order->State()=='Shipped'?'danger':($order->State()=='Validated'?'warning':'success')}}">
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
              <td>
                <p class="px-0 py-0 mx-0 my-0">
                  @foreach($order->Delivery_attempts() as $attempt)
                  <div class="m-1 m-1" title="{{$attempt->created_at}}" data-bs-toggle="tooltip" data-bs-placement="left">
                    <span class="px-1 py-1 badge bg-primary w-full">
                      {{$attempt->Attempt_by()->name}}
                    </span> 
                    <small>{{$attempt->response}}</small>
                  </div>
                  @endforeach
                </p>
              </td>
              <td class="single-line">
                <p>
                  <i class="align-middle me-2 fas fa-fw fa-user-gear"></i> {{$order->Shipped_by()->name}}<br>
                  <i class="align-middle me-2 fas fa-fw fa-calendar"></i> {{$order->shipped_at}}
                </p>
              </td>
              <td class="single-line">
                <p>
                  <i class="align-middle me-2 fas fa-fw fa-user-gear"></i> {{$order->Validated_by()->name}}<br>
                  <i class="align-middle me-2 fas fa-fw fa-calendar"></i> {{$order->validated_at}}
                </p>
              </td>
              <td>
                @if($data['can_validate'] && $order->State() == "Shipped")
                <a href="{{route('webmaster_orders_validate', $order->id)}}" class="btn btn-primary" >
                  Validate
                </a>
                @endif
                @if($data['can_add_information'] && ($order->State() == "Shipped" || $order->State() == "Delivery"))
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addInformation{{$order->id}}">
                  Add an information
                </button>
                @endif
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
		</div>
  </div>
</div>
@if($data['can_add_information'])
  @foreach($data["orders"] as $order)
  <div class="modal fade" id="addInformation{{$order->id}}" tabindex="-1" role="dialog" aria-labelledby="addInformationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form action="{{route('webmaster_orders_add_information', $order->id)}}" method="POST">
          @csrf
          <input type="hidden" value="webmaster_orders_shipped_index" name="backto">
          <div class="modal-header">
            <h5 class="modal-title" id="addInformationModalLabel">Add information</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>Information for {{$order->name}}:</p>
            <ul>
              <li>Name: <b>{{$order->name}}</b></li>
              <li>Phone: <b><a href="tel:{{$order->phone}}">{{$order->phone}}</a></b></li>
              <li>Phone2: <b><a href="tel:{{$order->phone2}}">{{$order->phone2}}</a></b></li><br>
              <li>Address: <b>{{$order->address}}</b></li>
              <li>Commune: <b>{{$order->Commune()->name}}</b></li>
              <li>Wilaya: <b>{{$order->Wilaya()->name}}</b></li><br>
              <li>Campaign: <b>{{$order->Campaign()->name}}</b></li>
              <li>Product: <b>{{$order->Product()->name}}</b></li>
              <li>Quantity: <b>{{$order->quantity}}</b></li><br>
              <li>Total price: <b>{{$order->total_price}} DZD</b></li>
              <li>Delivery price: <b>{{$order->delivery_price}} DZD</b></li>
              <li>Clean price: <b>{{$order->clean_price}} DZD</b></li>
            </ul>
            <div>
            </div>
            <div class="mb-3">
              <label for="response-{{$order->id}}" class="form-label">Response</label>
              <textarea class="form-control" id="response-{{$order->id}}" name="response"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Add information</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  @endforeach
@endif
@endsection
@section("scripts")

<script src="{{asset('js/datatables.js')}}"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
	$("#orders_table").DataTable({
		responsive: true
	});
});
</script>
@endsection