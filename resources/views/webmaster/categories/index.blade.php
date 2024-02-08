@extends('layouts.webmaster')
@section('content')
<div class="row">
  <div class="col-12 col-lg-12 col-xxl-12 d-flex">
    <div class="card flex-fill">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">{{$data["title"]}}</h5>
        <a href="{{route('webmaster_categories_create')}}" class="btn btn-primary" > Create a category </a>
      </div>
    </div>
  </div>
  <div class="col-12 col-lg-12 col-xxl-12 d-flex">
    <div class="card flex-fill">
      <div class="table-responsive">
        <table class="table table-hover my-0">
          <thead>
            <tr>
              <th>#</th>
              <th class="d-xl-table-cell">Name</th>
              <th class="d-xl-table-cell">Label</th>
              <th class="d-xl-table-cell">Order</th>
              <th class="d-xl-table-cell">Active</th>
              <th class="d-none d-xl-table-cell">Date</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($data["categories"] as $category)
            <tr>
              <td><a href="{{route('webmaster_categories_show', $category['id'])}}">{{$category["id"]}}</a></td>
              <td class="d-xl-table-cell">{{$category["name"]}}</td>
              <td class="d-xl-table-cell">{{$category["slug"]}}</td>
              <td class="d-xl-table-cell">{{$category["order"]}}</td>
              <td class="d-xl-table-cell">{{ $category->is_active?"True":"False" }}</td>
              <td class="d-none d-xl-table-cell">{{$category["created_at"]}}</td>
              <td>
                <a href="{{route('webmaster_categories_edit', $category['id'])}}" class="btn btn-primary btn-icon rounded-pill" >
                  <i class="align-middle" data-feather="edit"></i>
                </a>
                <button type="button" class="btn btn-danger rounded-pill" data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal9">
                  <i class="align-middle" data-feather="trash"></i>
                </button>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div>
  {{ $data["categories"]->links('components.pagination') }}
  </div>
</div>
@endsection
