@extends('layouts.webmaster')
@section('content')
<div class="container-fluid p-0">
  <div class="mb-3">
    <h1>{{$data["title"]}} </h1>
  </div>
  <div class="card">
		<div class="card-header pb-0">
			<div class="card-actions float-end">
				<div class="dropdown position-relative">
					<a href="#" data-bs-toggle="dropdown" data-bs-display="static">
						<i class="align-middle" data-feather="more-horizontal"></i>
					</a>
					<div class="dropdown-menu dropdown-menu-end">
						<a class="dropdown-item" href="#">Action</a>
						<a class="dropdown-item" href="#">Another action</a>
						<a class="dropdown-item" href="#">Something else here</a>
					</div>
				</div>
			</div>
			<h5 class="card-title mb-0">Pending orders</h5>
		</div>
		<div class="card-body">
      
    <table class="table table-hover my-0" id="datatables-orders">
          <thead>
            <tr>
              <th class="d-xl-table-cell">Order</th>
              <th class="d-xl-table-cell">Customer</th>
              <th class="d-xl-table-cell">Address</th>
              <th class="d-xl-table-cell">Product</th>
              <th class="d-xl-table-cell">Prices</th>
              <th>Confirmation attempts</th>
              <th>Confirmed by</th>
              <th>State</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($data["orders"] as $order)
            <tr>
              <td class="d-xl-table-cell single-line">
                <p>
                  <i class="align-left" data-feather="hash"></i> <a href="{{route('webmaster_orders_show', $order->id)}}">{{$order->id}}</a><br>
                  <i class="align-left" data-feather="paperclip"></i> <a href="https://suivi.ecotrack.dz/suivi/{{$order->tracking}}" traget="_blank">{{$order->tracking}}</a><br>
                  <i class="align-left" data-feather="calendar"></i> {{$order->created_at}}
                </p>
              </td>
              <td class="d-xl-table-cell single-line">
                <p>
                  <i class="align-left" data-feather="user"></i> {{$order->name}}<br>
                  <i class="align-left" data-feather="phone"></i> <a href="tel:{{$order->phone}}">{{$order->phone}}</a><br>
                  <i class="align-left" data-feather="phone"></i> <a href="tel:{{$order->phone}}">{{$order->phone2}}</a>
                </p>
              </td>
              <td class="d-xl-table-cell single-line">
                <p>
                  <i class="align-left" data-feather="map-pin"></i> {{$order->address}}<br>
                  <i class="align-left" data-feather="map"></i> {{$order->Commune()->name}} - {{$order->Wilaya()->name}}<br>
                  <i class="align-left" data-feather="globe"></i> {{$order->ip}}
                </p>
              </td>
              <td class="d-xl-table-cell single-line">
                <p>
                  <i class="align-left" data-feather="volume-2"></i> <a href="{{route('webmaster_campaigns_show', $order->campaign)}}">{{$order->Campaign()->name}}</a><br>
                  <i class="align-left" data-feather="package"></i> <a href="{{route('webmaster_products_show', $order->product)}}">{{$order->Product()->name}}</a><br>
                  <i class="align-left" data-feather="list"></i> {{$order->quantity}}
                </p>
              </td>
              <td class="d-xl-table-cell single-line">
                <p>
                <i class="align-left" data-feather="dollar-sign"></i> {{$order->total_price}} DZD<br>
                <i class="align-left" data-feather="truck"></i>  {{$order->delivery_price}} DZD<br>
                <i class="align-left" data-feather="dollar-sign"></i>  {{$order->clean_price}} DZD
                </p>
              </td>
              <td>
                <p>
                  @foreach($order->Confirmation_attempts() as $attempt)
                  <span class="badge bg-{{$attempt->state=='confirmed'?'success':($attempt->state=='not confirmed'?'warning':'danger')}}">
                    <span class="badge bg-primary rounded-pill">{{$attempt->Attempt_by()->name}}</span>
                    {{$attempt->response}}
                  </span><br>
                  @endforeach
                </p>
              </td>
              <td>
                <p>
                  Confirmed by: <b>{{$order->Confirmed_by()->name}}</b><br>
                  Confirmed at: <b>{{$order->confirmed_at}}</b>
                </p>
              </td>
              <td>
              {{$order->State()}}
              </td>
              <td>
                @if($data['can_confirm'] && $order->State() == "Pending")
                <button type="button" class="btn btn-secondary rounded-pill" data-bs-toggle="modal" data-bs-target="#addAttempt{{$order->id}}">
                  Add an attempt
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

@if($data['can_confirm'])
  @foreach($data["orders"] as $order)
  <div class="modal fade" id="addAttempt{{$order->id}}" tabindex="-1" role="dialog" aria-labelledby="orderConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form action="{{route('webmaster_orders_confirm', $order->id)}}" method="POST">
          @csrf
          <div class="modal-header">
            <h5 class="modal-title" id="orderConfirmationModalLabel">Order Confirmation</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>Confirmation attempt for {{$order->name}}:</p>
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
            <div class="col-6 mb-3">
              <label for="response" class="form-label">Response</label>
              <label class="form-check">
                <input class="form-check-input" type="radio" name="response" value="Pas de réponse">
                <span class="form-check-label">Ne repond pas</span>
              </label>
              <label class="form-check">
                <input class="form-check-input" type="radio" name="response" value="Injoingnable">
                <span class="form-check-label">Injoingnable</span>
              </label>
              <label class="form-check">
                <input class="form-check-input" type="radio" name="response" value="Code">
                <span class="form-check-label">Code</span>
              </label>
              <label class="form-check">
                <input class="form-check-input" type="radio" name="response" value="Annulé par le client">
                <span class="form-check-label">Annulé par le client</span>
              </label>
              <label class="form-check">
                <input class="form-check-input" type="radio" name="response" value="Reçeption du bureau">
                <span class="form-check-label">Reçeption du bureau</span>
              </label>
            </div>
            <div class="col-6 mb-3">
              <label for="state" class="form-label">State</label>
              <label class="form-check">
                <input class="form-check-input" type="radio" name="state" value="not confirmed" checked>
                <span class="form-check-label">Not confirmed</span>
              </label>
              <label class="form-check">
                <input class="form-check-input" type="radio" name="state" value="confirmed">
                <span class="form-check-label">Confirmed</span>
              </label>
              <label class="form-check">
                <input class="form-check-input" type="radio" name="state" value="canceled">
                <span class="form-check-label">Canceled</span>
              </label>
            </div>
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
<script src="{{asset('js/datatables.js')}}"></script>

	<script>
		document.addEventListener("DOMContentLoaded", function() {
        $("#datatables-orders").DataTable({
            responsive: true
        });
      });
	</script>
@endsection