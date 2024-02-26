@extends('layouts.webmaster')
@section('content')
    <div class="row">
        <div class="col-12 col-lg-12 col-xxl-12 d-flex">
            <div class="card flex-fill">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">{{$data["title"]}}</h5>
                <div>
                    <a href="{{route('webmaster_categories_index')}}" class="btn btn-secondary" > Back </a>
                    @if($data["can_delete"])
                    <a  class="btn btn-danger" > Delete </a>
                    @endif
                    @if($data["can_edit"])
                    <a href="{{route('webmaster_categories_edit', $data['category']->id)}}" class="btn btn-primary" > Edit </a>
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
                        <h3 id="id" class="mx-4">{{ $data['category']->id }}</h3>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Nom: </label>
                        <h3 id="name" class="mx-4">{{ $data['category']->name }}</h3>
                    </div>
                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug: </label>
                        <h3 id="slug" class="mx-4">{{ $data['category']->slug }}</h3>
                    </div>
                    <div class="mb-3">
                        <label for="is_active" class="form-label">Active: </label>
                        <h3 id="is_active" class="mx-4">{{ $data['category']->is_active?"True":"False" }}</h3>
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Products: </label>
                        <h3 id="products" class="mx-4">
                            @foreach($data["category"]->Products() as $product)
                            <a href="{{route('webmaster_products_show', $product->id)}}">
                                {{ $product->name }}
                            </a><br>
                            @endforeach
                        </h3>
                    </div>
                    <div class="mb-3">
                        <label for="created_by" class="form-label">Created by: </label>
                        <h3 id="created_by" class="mx-4">{{ $data['category']->Created_by()->name }} | {{ $data['category']->Created_by()->role }}</h3>
                    </div>
                    <div class="mb-3">
                        <label for="created_at" class="form-label">Created at: </label>
                        <h3 id="created_at" class="mx-4">{{ $data['category']->created_at }}</h3>
                    </div>
                    <div class="mb-3">
                        <label for="updated_at" class="form-label">Updated at: </label>
                        <h3 id="updated_at" class="mx-4">{{ $data['category']->updated_at }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
