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
              <th class="d-xl-table-cell">Admin</th>
              <th class="d-xl-table-cell">Contact</th>
              @if($data["can_make_payement"])
              <th class="d-xl-table-cell">Amount</th>
              @endif
              <th class="d-xl-table-cell">Permissions</th>
              <th class="d-xl-table-cell">Created</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($data["admins"] as $admin)
            <tr>
              
              <td class="d-xl-table-cell single-line">
                <p>
                  <i class="align-middle me-2 fas fa-fw fa-hashtag"></i>
                  <a href="{{route('webmaster_admins_show', $admin->id)}}">{{$admin->id}}</a><br>
                  <i class="align-middle me-2 fas fa-fw fa-user-tie"></i> {{$admin->name}}<br>
                  <i class="align-middle me-2 fas fa-fw fa-user-cog"></i> {{$admin->role}}<br>
                <i class="align-middle me-2 fas fa-fw fa-toggle-on"></i>{{ $admin->is_active?"Active":"Not active" }}<br>
                <i class="align-middle me-2 fas fa-fw fa-calendar"></i>{{$admin->last_login_at}}
                </p>
              </td>
              <td class="d-xl-table-cell single-line">
                  <i class="align-middle me-2 fas fa-fw fa-envelope-open-text"></i> <a href="mailto:{{$admin->email}}">{{$admin->email}}</a><br>
                  <i class="align-middle me-2 fas fa-fw fa-phone"></i> <a href="tel:{{$admin->phone}}">{{$admin->phone}}</a><br>
                  <i class="align-middle me-2 fas fa-fw"></i> <a href="tel:{{$admin->phone2}}">{{$admin->phone2}}</a>
                </p>
              </td>
              @if($data["can_make_payement"])
              <td class="d-xl-table-cell single-line">
                <h5><b>{{$admin->Amount()}}</b> DZD</h5>
              </td>
              @endif
                
              <td class="d-xl-table-cell">
                <p>
                  @foreach(config('webmaster.sidemenu') as $permission)
                    @if(is_array($permission))
                      @foreach(config('webmaster.permissions') as $key=>$sub_permissions)
                        @foreach($sub_permissions as $sub_permission)
                          @if($key == $permission[4] || ($key == explode('_', $permission[4])[0] && $permission[0]=='Orders'))
                            @if($admin->Has_Permission($sub_permission.'_'.$key))
                            <span title="{{$sub_permission.'_'.$key}}" data-bs-toggle="tooltip" data-bs-placement="left"> <i class="align-middle text-success" data-feather="{{$permission[2]}}"></i></span>
                            @else 
                            <span title="{{$sub_permission.'_'.$key}}" data-bs-toggle="tooltip" data-bs-placement="left"> <i class="align-middle text-danger" data-feather="{{$permission[2]}}"></i></span>
                            @endif
                          @endif
                          
                        @endforeach
                      @endforeach
                    @endif
                  @endforeach
                </p>
              </td>
              <td class="d-xl-table-cell single-line">
                <i class="align-middle me-2 fas fa-fw fa-user-gear"></i>{{ $admin->Created_by()->name }}<br>
                <i class="align-middle me-2 fas fa-fw fa-calendar"></i>{{$admin->created_at}}
              </td>
              <td>
                
                @if($data["can_make_payement"])
                <a href="{{route('webmaster_admins_payement', $admin->id)}}" type="button" class="btn btn-secondary rounded-pill">
                  <i class="align-middle" data-feather="dollar-sign"></i>
                </a>
                @endif

                @if($data["can_edit"])
                <a href="{{route('webmaster_admins_edit', $admin->id)}}" class="btn btn-primary btn-icon rounded-pill" >
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
