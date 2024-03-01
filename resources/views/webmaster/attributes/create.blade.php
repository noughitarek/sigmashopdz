@extends('layouts.webmaster')
@section('content')
<form action ="{{route('webmaster_attributes_store')}}" method="POST"> 
    @csrf
    <div class="row">
        <div class="col-12 col-lg-12 col-xxl-12 d-flex">
            <div class="card flex-fill">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">{{$data["title"]}}</h5>
                <div>
                    <a href="{{route('webmaster_attributes_index')}}" class="btn btn-danger" > Back </a>
                    <button type="submit" class="btn btn-primary" > Create </button>
                </div>
            </div>
            </div>
        </div>
        <div class="col-12 col-lg-12 col-xxl-12 d-flex">
            <div class="card flex-fill">
                <div class="card-header d-flex justify-content-between align-items-center row">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" id="title" required>
                        @error('title')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="title_ar" class="form-label">Title ar</label>
                        <input type="text" name="title_ar" class="form-control" id="title_ar" required>
                        @error('title_ar')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="values" class="form-label">Values</label>
                        <input type="text" name="values" class="form-control" id="values" required>
                        @error('values')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="values" class="form-label">Values ar</label>
                        <input type="text" name="values_ar" class="form-control" id="values_ar" required>
                        @error('values')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
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
                        <button type="submit" class="btn btn-primary" > Create </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
@section("scripts")
<script>
    var textRemove = new Choices(
          document.getElementById('values'),
          {
            allowHTML: true,
            delimiter: ',',
            editItems: true,
            removeItemButton: true,
          }
        );
    var textRemove = new Choices(
          document.getElementById('values_ar'),
          {
            allowHTML: true,
            delimiter: ',',
            editItems: true,
            removeItemButton: true,
          }
        );
</script>
@endsection