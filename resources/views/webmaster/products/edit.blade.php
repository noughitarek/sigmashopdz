@extends('layouts.webmaster')
@section('content')
<form action ="{{route('webmaster_products_update', $data['product']->id)}}" method="POST" enctype="multipart/form-data"> 
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-12 col-lg-12 col-xxl-12 d-flex">
            <div class="card flex-fill">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">{{$data["title"]}}</h5>
                <div>
                    <a href="{{route('webmaster_products_index')}}" class="btn btn-danger" > Back </a>
                    <button type="submit" class="btn btn-primary" > Update </button>
                </div>
            </div>
            </div>
        </div>
        <div class="col-12 col-lg-12 col-xxl-12 d-flex">
            <div class="card flex-fill">
                <div class="card-header d-flex justify-content-between align-items-center row">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nom *</label>
                        <input type="text" name="name" class="form-control" id="name" value="{{$data['product']->name}}" required>
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug *</label>
                        <input type="text" name="slug" class="form-control" id="slug" value="{{$data['product']->slug}}" required>
                        @error('slug')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-12 col-xxl-12 d-flex">
            <div class="card flex-fill">
                <div class="card-header d-flex justify-content-between align-items-center row">
                    <div class="col-6 mb-3">
                        <label for="price" class="form-label">Price *</label>
                        <input type="number" name="price" class="form-control" id="price" value="{{$data['product']->price}}" required>
                        @error('price')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-6 mb-3">
                        <label for="old_price" class="form-label">Old price</label>
                        <input type="number" name="old_price" class="form-control" id="old_price" value="{{$data['product']->old_price}}">
                        @error('old_price')
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
                        <label class="form-label">Old photos</label>
                        @foreach(explode(',',$data["product"]->photos) as $photo)
                        <label class="form-check">
                            <input class="form-check-input" type="checkbox" value="{{$photo}}" name="old_photos[]" checked>
                            <span class="form-check-label">{{$photo}}</span>
                        </label>
                        @endforeach
                    </div>
                    <div class="mb-3">
                        <label for="photos" class="form-label">Photos</label>
                        <input type="file" name="photos[]" class="form-control" id="photos" multiple>
                        @error('photos')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <label class="form-label">Old videos</label>
                    @foreach(explode(',', $data['product']->videos) as $video)
                    <div class="col-12">
                        @if($video != "")
                        <label class="form-check">
                            <input class="form-check-input" type="checkbox" value="{{$video}}" name="old_videos[]" checked>
                            <span class="form-check-label">{{$video}}</span>
                        </label>
                        @endif
                    </div>
                    @endforeach
                    <br>
                    @for($i=1;$i<=5;$i++)
                    <div class="col-6">
                        
                        <label for="videos{{$i}}" class="form-label">Videos {{$i}}</label>
                        <input type="url" name="videos[]" class="form-control" id="videos{{$i}}">
                        @error('videos')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    @endfor
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-12 col-xxl-12 d-flex">
            <div class="card flex-fill">
                <div class="card-header d-flex justify-content-between align-items-center row">
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control">{{$data['product']->description}}</textarea>
                        @error('description')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-6 mb-3">
                        <label for="category" class="form-label">Category *</label>
                        <select class="form-select mb-3" name="category" required>
                            <option value="0">Select a category</option>
                            @foreach($data["categories"] as $category)
                            <option {{$data['product']->category == $category->id?"selected":""}} value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                        @error('category')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-6 mb-3">
                        <label for="is_active" class="form-label">Active *</label>
                        <select class="form-select mb-3" name="is_active">
                            <option value="1" {{$data['product']->is_active?"selected":""}}>True</option>
                            <option value="0" {{$data['product']->is_active?"":"selected"}}>False</option>
                        </select>
                        @error('is_active')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary" > Update </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
