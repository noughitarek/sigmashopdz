@extends('layouts.webmaster')
@section('content')
<div class="row">
  <div class="col-12 col-lg-12 col-xxl-12 d-flex">
    <div class="card flex-fill">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">{{$data["title"]}}</h5>
        @if($data["can_create"])
        <a href="{{route('webmaster_admins_create')}}" class="btn btn-primary" > Create an admin </a>
        @endif
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
              <th class="d-xl-table-cell">Email</th>
              <th class="d-xl-table-cell">Role</th>
              <th class="d-xl-table-cell">Active</th>
              <th class="d-none d-xl-table-cell">Date</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($data["admins"] as $admin)
            <tr>
              <td><a href="{{route('webmaster_admins_show', $admin->id)}}">{{$admin->id}}</a></td>
              <td class="d-xl-table-cell">{{$admin->name}}</td>
              <td class="d-xl-table-cell">{{$admin->email}}</td>
              <td class="d-xl-table-cell">{{$admin->role}}</td>
              <td class="d-xl-table-cell">{{ $admin->is_active?"True":"False" }}</td>
              <td class="d-none d-xl-table-cell">{{$admin->last_login_at}}</td>
              <td>
                
                @if($data["can_edit"])
                <a href="{{route('webmaster_admins_edit', $admin['id'])}}" class="btn btn-primary btn-icon rounded-pill" >
                  <i class="align-middle" data-feather="edit"></i>
                </a>
                @endif
                
                @if($data["can_delete"])
                <button type="button" class="btn btn-danger rounded-pill" data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal9">
                  <i class="align-middle" data-feather="trash"></i>
                </button>
                @endif
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div>
  {{ $data["admins"]->links('components.pagination') }}
  </div>
</div>
@endsection
