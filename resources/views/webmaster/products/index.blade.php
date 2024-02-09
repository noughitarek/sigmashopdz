@extends('layouts.webmaster')
@section('content')
<div class="row">
  <div class="col-12 col-lg-12 col-xxl-12 d-flex">
    <div class="card flex-fill">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">{{$data["title"]}}</h5>
        @if($data["can_create"])
        <a href="{{route('webmaster_products_create')}}" class="btn btn-primary" > Create a product </a>
        @endif
      </div>
    </div>
  </div>
  @foreach($data["products"] as $product)
  <div class="col-12 col-lg-4 col-xxl-3 d-flex">
    <div class="card flex-fill">
      <a href="{{route('webmaster_products_show', $product->id)}}">
        <img style="height: 300px;object-fit: cover;" class="card-img-top" src="{{asset('/img/products/'.explode(',', $product->photos)[0])}}" alt="{{$product->name}}">
      </a>
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0"><a href="{{route('webmaster_products_show', $product->id)}}">{{$product->name}}</a></h5>
        <h5>{{$product->price}} DZD</h5>
      </div>
    </div>
  </div>
  @endforeach
  <div>
  {{ $data["products"]->links('components.pagination') }}
  </div>
</div>
@endsection
