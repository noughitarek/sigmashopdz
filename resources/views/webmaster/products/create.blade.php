@extends('layouts.webmaster')
@section('content')
<form action ="{{route('webmaster_products_store')}}" method="POST" enctype="multipart/form-data"> 
    @csrf
    <div class="row">
        <div class="col-12 col-lg-12 col-xxl-12 d-flex">
            <div class="card flex-fill">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">{{$data["title"]}}</h5>
                <div>
                    <a href="{{route('webmaster_products_index')}}" class="btn btn-danger" > Back </a>
                    <button type="submit" class="btn btn-primary" > Create </button>
                </div>
            </div>
            </div>
        </div>
        <div class="col-12 col-lg-12 col-xxl-12 d-flex">
            <div class="card flex-fill">
                <div class="card-header d-flex justify-content-between align-items-center row">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nom *</label>
                        <input type="text" name="name" class="form-control" id="name" required>
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug *</label>
                        <input type="text" name="slug" class="form-control" id="slug" required>
                        @error('slug')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="order" class="form-label">Order</label>
                        <input type="number" name="order" class="form-control" id="order">
                        @error('order')
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
                        <input type="number" name="price" class="form-control" id="price" required>
                        @error('price')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-6 mb-3">
                        <label for="old_price" class="form-label">Old price</label>
                        <input type="number" name="old_price" class="form-control" id="old_price">
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
                        <label for="photos" class="form-label">Photos *</label>
                        <input type="file" name="photos[]" class="form-control" id="photos" multiple>
                        @error('photos')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
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
						<div id="quill-toolbar">
						    <span class="ql-formats">
						    	<select class="ql-font"></select>
						    	<select class="ql-size"></select>
						    </span>
						    <span class="ql-formats">
						    	<button class="ql-bold"></button>
						    	<button class="ql-italic"></button>
						    	<button class="ql-underline"></button>
						    	<button class="ql-strike"></button>
						    </span>
						    <span class="ql-formats">
						    	<select class="ql-color"></select>
						    	<select class="ql-background"></select>
						    </span>
						    <span class="ql-formats">
						    	<button class="ql-script" value="sub"></button>
						    	<button class="ql-script" value="super"></button>
						    </span>
						    <span class="ql-formats">
						    	<button class="ql-header" value="1"></button>
						    	<button class="ql-header" value="2"></button>
						    	<button class="ql-blockquote"></button>
						    	<button class="ql-code-block"></button>
						    </span>
						    <span class="ql-formats">
						    	<button class="ql-list" value="ordered"></button>
						    	<button class="ql-list" value="bullet"></button>
						    	<button class="ql-indent" value="-1"></button>
						    	<button class="ql-indent" value="+1"></button>
						    </span>
						    <span class="ql-formats">
						    	<button class="ql-direction" value="rtl"></button>
						    	<select class="ql-align"></select>
						    </span>
						    <span class="ql-formats">
						    	<button class="ql-link"></button>
						    	<button class="ql-image"></button>
						    	<button class="ql-video"></button>
						    </span>
						    <span class="ql-formats">
						    	<button class="ql-clean"></button>
						    </span>
						<div>
						<div id="quill-editor"></div>
                        <textarea name="description" id="description" class="form-control"></textarea>
                        @error('description')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-6 mb-3">
                        <label for="category" class="form-label">Category *</label>
                        <select class="form-select mb-3" name="category" required>
                            <option value="0">Select a category</option>
                            @foreach($data["categories"] as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                        @error('category')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-6 mb-3">
                        <label for="is_active" class="form-label">Active *</label>
                        <select class="form-select mb-3" name="is_active">
                            <option value="1" selected>True</option>
                            <option value="0">False</option>
                        </select>
                        @error('is_active')
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
		document.addEventListener("DOMContentLoaded", function() {
			var editor = new Quill("#quill-editor", {
				modules: {
					toolbar: "#quill-toolbar"
				},
				placeholder: "Type something",
				theme: "snow"
			});
			var bubbleEditor = new Quill("#quill-bubble-editor", {
				placeholder: "Compose an epic...",
				modules: {
					toolbar: "#quill-bubble-toolbar"
				},
				theme: "bubble"
			});
		});
	</script>
@endsection