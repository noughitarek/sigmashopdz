@extends('layouts.webmaster')
@section('content')
<form action ="{{route('webmaster_delivery_update')}}" method="POST" enctype="multipart/form-data"> 
    @csrf
    @method("PUT")
    <div class="row">
        <div class="col-12 col-lg-12 col-xxl-12 d-flex">
            <div class="card flex-fill">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">{{$data["title"]}}</h5>
                @if($data["can_edit"])
                <div>
                    <a href="{{route('webmaster_delivery_api')}}" class="btn btn-secondary" > Update by API </a>
                    <button type="submit" class="btn btn-primary" > Update </button>
                </div>
                @endif
            </div>
            </div>
        </div>
        @foreach($data['wilayas'] as $wilaya)
        <div class="col-6 col-lg-4 col-xxl-4 d-flex">
            <div class="card flex-fill">
                <div class="card-header">
                <h3 for="wilaya{{$wilaya->name}}" class="form-label">{{$wilaya->name}}</h3>
                <div class="d-flex justify-content-between align-items-center row" id="wilaya{{$wilaya->name}}">
                    <div class="mb-3 col-6">
                        <label for="real_price_{{$wilaya->id}}" class="form-label">Real price</label>
                        <input type="number" name="real_price_{{$wilaya->id}}" class="form-control" id="real_price_{{$wilaya->id}}" value="{{$wilaya->real_price}}">
                        @error('real_price')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 col-6">
                        <label for="shown_price_{{$wilaya->id}}" class="form-label">Showen price</label>
                        <input type="number" name="shown_price_{{$wilaya->id}}" class="form-control" id="shown_price_{{$wilaya->id}}" value="{{$wilaya->shown_price}}">
                        @error('shown_price')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            </div>
        </div>
        @endforeach
        <div class="col-12 col-lg-12 col-xxl-12 d-flex">
            <div class="card flex-fill">
                <div class="card-header d-flex justify-content-between align-items-center row">
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary" > Update </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection