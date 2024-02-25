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
              <th>Action</th>
              <th class="d-xl-table-cell">Customer</th>
              <th class="d-xl-table-cell">Address</th>
              <th class="d-xl-table-cell">Product</th>
              <th class="d-xl-table-cell">Prices</th>
              <th>Confirmation attempts</th>
              <th>Confirmed</th>
            </tr>
          </thead>
          <tbody>
            @foreach($data["orders"] as $order)
            <tr>
              <td class="d-xl-table-cell single-line">
                <p>
                  <i class="align-middle me-2 fas fa-fw fa-hashtag"></i> <a href="{{route('webmaster_orders_show', $order->id)}}">{{$order->id}}</a><br>
                  <i class="align-middle me-2 fas fa-fw fa-calendar"></i> {{$order->created_at}}<br>
                  <i class="align-middle me-2 fas fa-fw fa-shopping-cart"></i>
                  <span title="{{$order->confirmed_by!=null?"Confirmed by ".$order->Confirmed_by()->name:""}}" class="badge bg-{{$order->State()=='Pending'?'danger':'success'}}">
                    {{$order->State()}} 
                  </span>
                  @if($order->stopdesk)
                  <span class="badge bg-primary">
                    Stopdesk  
                  </span>
                  @else
                  <span class="badge bg-secondary">
                    Home  
                  </span>
                  @endif
                </p>
              </td>
              <td >
                @if($data['can_confirm'] && $order->State() == "Pending")
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAttempt{{$order->id}}">
                  Add an attempt
                </button>
                @endif
                @if($data['can_shipp'] && $order->State() == "Confirmed")
                <a href="{{route('webmaster_orders_shipp', $order->id)}}" class="btn btn-primary" >
                  Add to ecotrack
                </a>
                @endif
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
                <i class="align-middle me-2 fas fa-fw fa-ad"></i> <a href="{{$order->campaign==null?"":route('webmaster_campaigns_show', $order->campaign)}}">{{$order->campaign==null?"":$order->Campaign()->name}}</a><br>
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
              <td class="d-xl-table-cell">
                <div class="border">
                  @foreach($order->Confirmation_attempts() as $attempt)
                  <div class="m-1 m-1" title="{{$attempt->created_at}}" data-bs-toggle="tooltip" data-bs-placement="left">
                    <span class="px-1 py-1 badge bg-primary w-full">
                      <img src="{{$attempt->Attempt_by()->Profile_image()}}" class="feather img-fluid rounded">
                      {{$attempt->Attempt_by()->name}}
                    </span> 
                    <small>{{$attempt->response}}</small>
                  </div>
                  @endforeach
                </div>
              </td>
              <td class="single-line">
                <p>
                  <i class="align-middle me-2 fas fa-fw fa-user-gear"></i> {{$order->Confirmed_by()->name}}<br>
                  <i class="align-middle me-2 fas fa-fw fa-calendar"></i> {{$order->confirmed_at}}
                </p>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
		</div>
    
  {{ $data["orders"]->links('components.pagination') }}
  </div>
</div>

@if($data['can_confirm'])
  @foreach($data["orders"] as $order)
  <div class="modal fade" id="addAttempt{{$order->id}}" tabindex="-1" role="dialog" aria-labelledby="orderConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form action="{{route('webmaster_orders_confirm', $order->id)}}" method="POST">
          @csrf
          <div class="modal-header">
            <h5 class="modal-title" id="orderConfirmationModalLabel">Order Confirmation</h5>
            <div>
            <button type="submit" class="btn btn-primary">Add attempt</button>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            </div>
          </div>
          <div class="modal-body">
            <p>Confirmation attempt for {{$order->name}}:</p>
            <div class="col-6 mb-3">
              <label for="state" class="form-label"><h2>State</h2></label>
              <label class="form-check">
                <input class="form-check-input order-state-{{$order->id}}" type="radio" name="state" value="not confirmed" checked>
                <span class="form-check-label">Not confirmed</span>
              </label>
              <label class="form-check">
                <input class="form-check-input order-state-{{$order->id}}" type="radio" name="state" value="confirmed">
                <span class="form-check-label">Confirmed</span>
              </label>
              <label class="form-check">
                <input class="form-check-input order-state-{{$order->id}}" type="radio" name="state" value="canceled">
                <span class="form-check-label">Canceled</span>
              </label>
            </div>
            <div class="mb-3" style="display: none;" id="confirmed-order-{{$order->id}}">
              <label class="form-label"><h2>Confirmed</h2></label>
              <label class="form-check">
                <input class="form-check-input confirmed-order-{{$order->id}}" type="checkbox" name="stopdesk" disabled>
                <span class="form-check-label">Stopdesk</span>
              </label>
              @if($data['can_shipp'])
              <label class="form-check">
                <input class="form-check-input confirmed-order-{{$order->id}}" type="checkbox" name="shipp" checked disabled>
                <span class="form-check-label">Shipp to ecotrack</span>
              </label>
              <textarea class="form-control confirmed-order-{{$order->id}}" name="remarque" disabled></textarea>
              
              @if($data['can_validate'])
              <label class="form-check">
                <input class="form-check-input confirmed-order-{{$order->id}}" type="checkbox" name="validate" checked disabled>
                <span class="form-check-label">Validate shipping</span>
              </label>
              @endif
              @endif
            </div>
            <div class="mb-3" id="not-confirmed-order-{{$order->id}}">
              <label for="response" class="form-label"><h2>Not confirmed</h2></label>
              <label class="form-check">
                <input class="form-check-input not-confirmed-order-{{$order->id}}" type="radio" name="response" value="Ne repond pas" checked>
                <span class="form-check-label">Ne repond pas</span>
              </label>
              <label class="form-check">
                <input class="form-check-input not-confirmed-order-{{$order->id}}" type="radio" name="response" value="Injoingnable">
                <span class="form-check-label">Injoingnable</span>
              </label>
              <label class="form-check">
                <input class="form-check-input not-confirmed-order-{{$order->id}}" type="radio" name="response" value="Faux numéro">
                <span class="form-check-label">Faux numéro</span>
              </label>
              <label class="form-check">
                <input class="form-check-input not-confirmed-order-{{$order->id}}" type="radio" name="response" value="Autre">
                <span class="form-check-label">Autre</span>
              </label>
              <textarea class="form-control" id="not-confirmed-other-{{$order->id}}" name="response" disabled></textarea>
            </div>
            <div class="mb-3" id="canceled-order-{{$order->id}}" style="display: none;">
              <label for="response" class="form-label"><h2>Canceled</h2></label>
              <label class="form-check">
                <input class="form-check-input canceled-order-{{$order->id}}" type="radio" name="response" value="Annulée par le client" checked>
                <span class="form-check-label">Annulée par le client</span>
              </label>
              <label class="form-check">
                <input class="form-check-input canceled-order-{{$order->id}}" type="radio" name="response" value="Client pas sérieux">
                <span class="form-check-label">Client pas sérieux</span>
              </label>
              <label class="form-check">
                <input class="form-check-input canceled-order-{{$order->id}}" type="radio" name="response" value="Autre">
                <span class="form-check-label">Autre</span>
              </label>
              <textarea class="form-control" id="canceled-other-{{$order->id}}" name="response" disabled></textarea>
            </div>
            <h1>Order informations</h1>
            <ul>
              <li>Name: <b>{{$order->name}}</b></li>
              <li>Phone: <b><a href="tel:{{$order->phone}}">{{$order->phone}}</a></b></li>
              <li>Phone2: <b><a href="tel:{{$order->phone2}}">{{$order->phone2}}</a></b></li><br>
              <li>Address: <b>{{$order->address}}</b></li>
              <li>Commune: <b>{{$order->Commune()->name}}</b></li>
              <li>Wilaya: <b>{{$order->Wilaya()->name}}</b></li><br>
              <li>Campaign: <b>{{$order->campaign==null?"":$order->Campaign()->name}}</b></li>
              <li>Product: <b>{{$order->Product()->name}}</b></li>
              <li>Quantity: <b>{{$order->quantity}}</b></li><br>
              <li>Total price: <b>{{$order->total_price}} DZD</b></li>
              <li>Delivery price: <b>{{$order->delivery_price}} DZD</b></li>
              <li>Clean price: <b>{{$order->clean_price}} DZD</b></li>
            </ul>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Add attempt</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  @endforeach
@endif
@endsection
@section("scripts")
<script>
  @foreach($data['orders'] as $order)
  document.querySelectorAll('input[name="response"].not-confirmed-order-{{$order->id}}').forEach(function(radioButton) {
    radioButton.addEventListener('change', function() {
        var textInput = document.getElementById('not-confirmed-other-{{$order->id}}');
        var autreRadioButton = document.querySelector('input[name="response"][value="Autre"].not-confirmed-order-{{$order->id}}');
        textInput.disabled = !autreRadioButton.checked;
    });
  });
  document.querySelectorAll('input[name="response"].canceled-order-{{$order->id}}').forEach(function(radioButton) {
    radioButton.addEventListener('change', function() {
        var textInput = document.getElementById('canceled-other-{{$order->id}}');
        var autreRadioButton = document.querySelector('input[name="response"][value="Autre"].canceled-order-{{$order->id}}');
        textInput.disabled = !autreRadioButton.checked;
    });
  });
  document.querySelectorAll('input[name="state"].order-state-{{$order->id}}').forEach(function(radioButton) {
    radioButton.addEventListener('change', function() {
        var confirmedInput = document.querySelector('input[name="state"][value="confirmed"].order-state-{{$order->id}}');
        var notConfirmedInput = document.querySelector('input[name="state"][value="not confirmed"].order-state-{{$order->id}}');
        var canceledInput = document.querySelector('input[name="state"][value="canceled"].order-state-{{$order->id}}');
        
        var confirmedOrders = document.querySelectorAll('.confirmed-order-{{$order->id}}');
        confirmedOrders.forEach((confirmedOrder)=>{
          confirmedOrder.disabled = !confirmedInput.checked;
        })
        var confirmedOrders = document.getElementById('confirmed-order-{{$order->id}}');
        confirmedOrders.style.display = confirmedInput.checked?"block":"none";

        var notConfirmedOrders = document.querySelectorAll('.not-confirmed-order-{{$order->id}}');
        notConfirmedOrders.forEach((notConfirmedOrder)=>{
          notConfirmedOrder.disabled = !notConfirmedInput.checked;
        })
        var notConfirmedOrders = document.getElementById('not-confirmed-order-{{$order->id}}');
        notConfirmedOrders.style.display = notConfirmedInput.checked?"block":"none";

        var canceledOrders = document.querySelectorAll('.canceled-order-{{$order->id}}');
        canceledOrders.forEach((canceledOrder)=>{
          canceledOrder.disabled = !canceledInput.checked;
        })
        var canceledOrders = document.getElementById('canceled-order-{{$order->id}}');
        canceledOrders.style.display = canceledInput.checked?"block":"none";
    });
  });
  @endforeach
</script>
@endsection