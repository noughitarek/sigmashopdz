@extends('layouts.webmaster')
@section('content')
<div class="row">
    <div class="col-12 col-lg-12 col-xxl-12 d-flex">
        <div class="card flex-fill">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">{{$data["title"]}}</h5>
            <div>
                <a href="{{route('webmaster_products_index')}}" class="btn btn-secondary" > Back </a>
                
                @if($data["can_delete"])
                    <a  class="btn btn-danger" > Delete </a>
                    @endif
                @if($data["can_edit"])
                <a href="{{route('webmaster_products_edit', $data['product']->id)}}" class="btn btn-primary" > Edit </a>
                @endif
            </div>
        </div>
        </div>
    </div>
    <div class="col-12 col-lg-12 col-xxl-12 d-flex">
        <div class="card flex-fill">
            <div class="card-header d-flex justify-content-between align-items-center row">
                
                <div class="mb-3">
                    <label for="id" class="form-label">ID: </label>
                    <h3 id="id" class="mx-4">{{ $data['product']->id }}</h3>
                </div><br>
                <div class="mb-3">
                    <label for="name" class="form-label">Nom: </label>
                    <h3 id="name" class="mx-4">{{ $data['product']->name }}</h3>
                </div>
                <div class="mb-3">
                    <label for="slug" class="form-label">Slug: </label>
                    <h3 id="slug" class="mx-4">{{ $data['product']->slug }}</h3>
                </div>
                <div class="mb-3">
                    <label for="order" class="form-label">Order: </label>
                    <h3 id="order" class="mx-4">{{ $data['product']->order }}</h3>
                </div><br>

                <div class="mb-3">
                    <label for="price" class="form-label">Price: </label>
                    <h3 id="price" class="mx-4">{{ $data['product']->price }} DZD</h3>
                </div>
                <div class="mb-3">
                    <label for="old_price" class="form-label">Old price: </label>
                    <h3 id="old_price" class="mx-4">{{ $data['product']->old_price }} DZD</h3>
                </div><br>

                <div class="mb-3">
                    <label for="old_price" class="form-label">Photos: </label>
                    @foreach(explode(",", $data['product']->photos) as $photo)
                    <h3 class="mx-4"><img src="{{asset('/img/products/'.$photo)}}" alt=""></h3>
                    @endforeach
                </div>
                <div class="mb-3">
                    <label for="old_price" class="form-label">Videos: </label>
                    <h3 class="mx-4">
                        @foreach(explode(",", $data['product']->videos) as $video)
                            @if($video!="")
                            <a href="{{$video}}">{{$video}}</a><br>
                            @endif
                        @endforeach
                    </h3>
                </div>

                <div class="mb-3">
                    <label for="category" class="form-label">Category: </label>
                    <h3 id="order" class="mx-4"><a href="{{route('webmaster_categories_show', $data['product']->category)}}">{{ $data['product']->Category()->name }}</a></h3>
                </div>
                <div class="mb-3">
                    <label for="order" class="form-label">Active: </label>
                    <h3 id="order" class="mx-4">{{ $data['product']->is_active?"True":"False" }}</h3>
                </div>
                <div class="mb-3">
                    <label for="order" class="form-label">Created by: </label>
                    <h3 id="order" class="mx-4">{{ $data['product']->Created_by()->name }} | {{ $data['product']->Created_by()->role }}</h3>
                </div>
                <div class="mb-3">
                    <label for="created_at" class="form-label">Created at: </label>
                    <h3 id="created_at" class="mx-4">{{ $data['product']->created_at }}</h3>
                </div>
                <div class="mb-3">
                    <label for="updated_at" class="form-label">Updated at: </label>
                    <h3 id="updated_at" class="mx-4">{{ $data['product']->updated_at }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
