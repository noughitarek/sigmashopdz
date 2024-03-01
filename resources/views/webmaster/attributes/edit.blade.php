@extends('layouts.webmaster')
@section('content')
<form action ="{{route('webmaster_pages_update', $data['page']->id)}}" method="POST"> 
    @csrf
    @method("PUT")
    <div class="row">
        <div class="col-12 col-lg-12 col-xxl-12 d-flex">
            <div class="card flex-fill">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">{{$data["title"]}}</h5>
                <div>
                    <a href="{{route('webmaster_pages_update', $data['page']->id)}}" class="btn btn-danger" > Back </a>
                    <button type="submit" class="btn btn-primary" > Update </button>
                </div>
            </div>
            </div>
        </div>
        <div class="col-12 col-lg-12 col-xxl-12 d-flex">
            <div class="card flex-fill">
                <div class="card-header d-flex justify-content-between align-items-center row">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" id="title" value="{{$data['page']->title}}" required>
                        @error('title')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" name="slug" class="form-control" id="slug" value="{{$data['page']->slug}}" required>
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
                    <div class="mb-3 col-6">
                        <label for="position" class="form-label">Position</label>
                        <select class="form-select mb-3" name="position">
                            <option {{$data['page']->position=='Header'?'selected':''}}>Header</option>
                            <option {{$data['page']->position=='Footer1'?'selected':''}}>Footer1</option>
                            <option {{$data['page']->position=='Footer2'?'selected':''}}>Footer2</option>
                        </select>
                        @error('position')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 col-6">
                        <label for="is_active" class="form-label">Active</label>
                        <select class="form-select mb-3" name="is_active">
                            <option value="1" {{$data['page']->is_active?'selected':''}}>True</option>
                            <option value="0" {{$data['page']->is_active?'':'selected'}}>False</option>
                        </select>
                        @error('is_active')
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
                        <label for="content" class="form-label">Content</label>
                        <textarea name="content" id="content" class="form-control">{{$data['page']->content}}</textarea>
                        @error('content')
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
