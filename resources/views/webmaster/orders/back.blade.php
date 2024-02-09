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
        <table class="table table-hover my-0">
          <thead>
            <tr>
              <th>#</th>
              <th class="d-xl-table-cell">State</th>
              <th class="d-xl-table-cell">Name</th>
              <th class="d-xl-table-cell">Phone</th>
              <th class="d-xl-table-cell">Phone2</th>
              <th class="d-xl-table-cell">Address</th>
              <th class="d-xl-table-cell">Date</th>
              <th class="d-xl-table-cell">Commune</th>
              <th class="d-xl-table-cell">Wilaya</th>
              <th class="d-xl-table-cell">Campaign</th>
              <th class="d-xl-table-cell">Produit</th>
              <th class="d-xl-table-cell">Quantity</th>
              <th class="d-xl-table-cell">Total</th>
              <th class="d-xl-table-cell">Delivery</th>
              <th class="d-xl-table-cell">Net</th>
              <th class="d-xl-table-cell">Tracking</th>
              <th class="d-xl-table-cell">IP</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($data["orders"] as $order)
            <tr>
              <td><a href="{{route('webmaster_orders_show', $order->id)}}">{{$order->id}}</a></td>
              <td>
              <select name="state" style="width: auto;text-align: center;" class="form-select state-select" data-row-id="{{$order->id}}">
                <option {{$order->State()=='Pending'?"selected":""}}>Pending</option>
                <option {{$order->State()=='Confirmed'?"selected":""}}>Confirmed</option>
                
                <option {{$order->State()=='Shipped'?"selected":""}}>Shipped</option>
                <option {{$order->State()=='Validated'?"selected":""}}>Validated</option>
                <option {{$order->State()=='Delivery'?"selected":""}}>Delivery</option>
                
                <option {{$order->State()=='Delivered'?"selected":""}}>Delivered</option>
                <option {{$order->State()=='Ready'?"selected":""}}>Ready</option>
                <option {{$order->State()=='Recovered'?"selected":""}}>Recovered</option>

                <option {{$order->State()=='Back'?"selected":""}}>Back</option>
                <option {{$order->State()=='Back ready'?"selected":""}}>Back ready</option>

                <option {{$order->State()=='Canceled'?"selected":""}}>Canceled</option>
                <option {{$order->State()=='Failure'?"selected":""}}>Failure</option>
                <option {{$order->State()=='Doubled'?"selected":""}}>Doubled</option>
                <option {{$order->State()=='Archived'?"selected":""}}>Archived</option>
              </select>
              </td>
              <td class="d-xl-table-cell">{{$order->name}}</td>
              <td class="d-xl-table-cell">{{$order->phone}}</td>
              <td class="d-xl-table-cell">{{$order->phone2}}</td>
              <td class="d-xl-table-cell">{{$order->address}}</td>
              <td class="d-xl-table-cell">{{$order->created_at}}</td>
              <td class="d-xl-table-cell">{{$order->commune}}</td>
              <td class="d-xl-table-cell">{{$order->wilaya}}</td>
              <td class="d-xl-table-cell">{{$order->campaign}}</td>
              <td class="d-xl-table-cell"><a href="{{route('webmaster_products_show', $order->product)}}">{{$order->Product()->name}}</td>
              <td class="d-xl-table-cell">{{$order->quantity}}</td>
              <td class="d-xl-table-cell">{{$order->total_price}} DZD</td>
              <td class="d-xl-table-cell">{{$order->delivery_price}} DZD</td>
              <td class="d-xl-table-cell">{{$order->clean_price}} DZD</td>
              <td class="d-xl-table-cell">{{$order->tracking}}</td>
              <td class="d-xl-table-cell">{{$order->ip}}</td>
              <td>
                <button type="button" class="btn btn-danger rounded-pill" data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal9">
                  <i class="align-middle" data-feather="trash"></i>
                </button>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div>
  {{ $data["orders"]->links('components.pagination') }}
  </div>
</div>
@endsection
