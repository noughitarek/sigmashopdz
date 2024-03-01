@extends('layouts.webmaster')
@section('content')
<form action ="{{route('webmaster_stock_store')}}" method="POST"> 
    @csrf
    <div class="row">
        <div class="col-12 col-lg-12 col-xxl-12 d-flex">
            <div class="card flex-fill">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">{{$data["title"]}}</h5>
                <div>
                    <a href="{{route('webmaster_stock_index')}}" class="btn btn-danger" > Back </a>
                    <button type="submit" class="btn btn-primary" > Create </button>
                </div>
            </div>
            </div>
        </div>
        <div class="col-12 col-lg-12 col-xxl-12 d-flex">
            <div class="card flex-fill">
                <div class="card-header d-flex justify-content-between align-items-center row">
                    <div class="mb-3">
                        <label for="total_price" class="form-label">Total price</label>
                        <input type="number" name="total_price" class="form-control" id="total_price" required>
                        @error('total_price')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" name="quantity" class="form-control" id="quantity" required>
                        @error('quantity')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-12 col-xxl-12 d-flex">
            <div class="card flex-fill">
                <div class="card-header d-flex justify-content-between align-items-center row">
                    <div class="mb-3">
                        <label for="product" class="form-label">Product</label>
                        <select class="form-select mb-3" name="product">
                            @foreach($data["products"] as $product)
                            <option value="{{$product->id}}" >{{$product->name}}</option>
                            @endforeach
                        </select>
                        @error('product')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="payed_by" class="form-label">Payed by</label>
                        <select class="form-select mb-3" name="payed_by">
                            @foreach($data["admins"] as $admin)
                            <option value="{{$admin->id}}" >{{$admin->name}}</option>
                            @endforeach
                        </select>
                        @error('payed_by')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary" > Create </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
