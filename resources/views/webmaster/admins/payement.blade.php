@extends('layouts.webmaster')
@section('content')
<form action ="{{route('webmaster_admins_payement_store', $data['admin']->id)}}" method="POST" enctype="multipart/form-data"> 
    @csrf
    <div class="row">
        <div class="col-12 col-lg-12 col-xxl-12 d-flex">
            <div class="card flex-fill">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">{{$data["title"]}}</h5>
                <div>
                    <a href="{{route('webmaster_admins_index')}}" class="btn btn-danger" > Back </a>
                    <button type="submit" class="btn btn-primary" > Create payement </button>
                </div>
            </div>
            </div>
        </div>
        <div class="col-12 col-lg-12 col-xxl-12 d-flex">
            <div class="card flex-fill">
                <div class="card-header d-flex justify-content-between align-items-center row">
                    <div class="mb-3">
                        <label for="payed_to" class="form-label">Payed to</label>
                        <select class="form-select mb-3" name="payed_to">
                            @foreach($data["admins"] as $admin)
                            @if($admin->id == $data["admin"]->id)
                                @continue
                            @endif
                            <option value="{{$admin->id}}" >{{$admin->name}}</option>
                            @endforeach
                            <option value="" >N/A</option>
                        </select>
                        @error('payed_to')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount</label>
                        <input type="number" name="amount" class="form-control" id="amount" required>
                        @error('amount')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" class="form-control" id="description"></textarea>
                        @error('description')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary" > Create payement </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection