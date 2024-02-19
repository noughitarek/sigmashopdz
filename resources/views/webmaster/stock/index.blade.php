@extends('layouts.webmaster')
@section('content')
<div class="row">
  <div class="col-12 col-lg-12 col-xxl-12 d-flex">
    <div class="card flex-fill">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">{{$data["title"]}}</h5>
        @if($data["can_create"])
        <a href="{{route('webmaster_stock_create')}}" class="btn btn-primary" > Create a stock </a>
        @endif
      </div>
    </div>
  </div>
  <div class="col-12 col-lg-12 col-xxl-12 d-flex">
    <div class="card flex-fill">
      <div class="table-responsive">
        <table class="table table-hover my-0" id="datatables-stock">
          <thead>
            <tr>
              <th class="d-xl-table-cell">Product</th>
              <th class="d-xl-table-cell">Orders</th>
              <th class="d-xl-table-cell">Cost</th>
              <th class="d-xl-table-cell">Stock</th>
              <th class="d-xl-table-cell">Created</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($data["products"] as $product)
            <tr>
              <td class="d-xl-table-cell single-line">
                <p>
                  <i class="align-middle me-2 fas fa-fw fa-hashtag"></i> <a href="{{route('webmaster_products_show', $product->id)}}">{{$product->id}}</a><br>
                  <i class="align-middle me-2 fas fa-fw fa-box"></i> {{$product->name}}<br>
                  <i class="align-middle me-2 fas fa-fw fa-qrcode"></i> {{$product->slug}}
                </p>
              </td>
              
              <td class="d-xl-table-cell single-line">
                <i class="align-middle me-2 fas fa-fw fa-box"></i>
                <span class="text-primary">{{count($product->Delivery_orders())}}</span>
                |
                <span class="text-success">{{count($product->Delivered_orders())}}</span>
                |
                <span class="text-danger">{{count($product->Back_orders())}}</span>
                |
                <span>{{count($product->Orders())}}</span><br>
                <span class="text-primary">
                  <i class="align-middle me-2 fas fa-fw fa-dollar-sign"></i>{{$product->Delivery_orders_amount()}} DZD
                </span><br>
                <span class="text-success">
                  <i class="align-middle me-2 fas fa-fw fa-dollar-sign"></i>{{$product->Delivered_orders_amount()}} DZD
                </span><br>
                <span class="text-danger">
                  <i class="align-middle me-2 fas fa-fw fa-dollar-sign"></i>{{$product->Back_orders_amount()}} DZD
                </span><br>
                <span>
                  <i class="align-middle me-2 fas fa-fw fa-dollar-sign"></i>{{$product->Orders_amount()}} DZD
                </span>
              </td>
              
              <td class="d-xl-table-cell single-line">
                <span class="text-primary">
                  <i class="align-middle me-2 fas fa-fw fa-ad"></i>{{count($product->Delivery_orders())==0?"n/a":$product->Spend()/count($product->Delivery_orders())}} $
                </span><br>
                <span class="text-success">
                  <i class="align-middle me-2 fas fa-fw fa-ad"></i>{{count($product->Delivered_orders())==0?"n/a":$product->Spend()/count($product->Delivered_orders())}} $
                </span><br>
                <span class="text-danger">
                  <i class="align-middle me-2 fas fa-fw fa-ad"></i>{{count($product->Back_orders())==0?"n/a":$product->Spend()/count($product->Back_orders())}} $
                </span><br>
                <span>
                  <i class="align-middle me-2 fas fa-fw fa-ad"></i>{{count($product->Orders())==0?"n/a":$product->Spend()/count($product->Orders())}} $
                </span>
              </td>
              <td class="d-xl-table-cell single-line">
                <h2><b>{{$product->Stock()}}</b></h2>
              </td>
              <td class="d-xl-table-cell single-line">
                <i class="align-middle me-2 fas fa-fw fa-user"></i>{{$product->Created_by()->name}}<br>
                <i class="align-middle me-2 fas fa-fw fa-calendar"></i>{{$product->created_at}}
              </td>
              <td>
                
                @if($data["can_edit"])
                <a href="{{route('webmaster_products_edit', $product['id'])}}" class="btn btn-primary btn-icon rounded-pill" >
                  <i class="align-middle" data-feather="edit"></i>
                </a>
                @endif
                
                @if($data["can_delete"])
                <button type="button" class="btn btn-danger rounded-pill" data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal9">
                  <i class="align-middle" data-feather="trash"></i>
                </button>
                @endif
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
		</div>
    
  {{ $data["products"]->links('components.pagination') }}
  </div>
</div>

@endsection