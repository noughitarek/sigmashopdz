@extends('layouts.webmaster')
@section('content')
<form action ="{{route('webmaster_admins_update', $data['admin']->id)}}" method="POST" enctype="multipart/form-data"> 
    @csrf
    @method("PUT")
    <div class="row">
        <div class="col-12 col-lg-12 col-xxl-12 d-flex">
            <div class="card flex-fill">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">{{$data["title"]}}</h5>
                <div>
                    <a href="{{route('webmaster_admins_index')}}" class="btn btn-danger" > Back </a>
                    <button type="submit" class="btn btn-primary" > Update </button>
                </div>
            </div>
            </div>
        </div>
        <div class="col-12 col-lg-12 col-xxl-12 d-flex">
            <div class="card flex-fill">
                <div class="card-header d-flex justify-content-between align-items-center row">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" id="name" value="{{$data['admin']->name}}" required>
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <input type="text" name="role" class="form-control" id="role" value="{{$data['admin']->role}}" required>
                        @error('role')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="email" value="{{$data['admin']->email}}" required>
                        @error('email')
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
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" id="phone" value="{{$data['admin']->phone}}">
                        @error('phone')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 col-6">
                        <label for="phone2" class="form-label">Phone2</label>
                        <input type="phone2" name="phone2" class="form-control" id="phone2" value="{{$data['admin']->phone2}}">
                        @error('phone2')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        @if($data["can_edit_role"])
        @foreach(config('webmaster.sidemenu') as $permission)
          @if(is_array($permission))
            @foreach(config('webmaster.permissions') as $key=>$sub_permissions)
                @if($key == $permission[4] || ($key == explode('_', $permission[4])[0] && $permission[0]=='Orders'))
                    <div class="col-lg-4 col-xxl-3 d-flex">
                        <div class="card flex-fill">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div class="mb-3">
                                    <h3> {{$permission[0]}} </h3>
                                    @foreach($sub_permissions as $sub_permission)
                                    <label class="form-check">
                                        <input class="form-check-input" type="checkbox" value="{{$sub_permission.'_'.$key}}" name="permissions[]" {{$data['admin']->Has_Permission($sub_permission.'_'.$key)?'checked':''}}>
                                        <span class="form-check-label">{{$sub_permission}}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
          @endif
        @endforeach
        @endif
        <div class="col-12 col-lg-12 col-xxl-12 d-flex">
            <div class="card flex-fill">
                <div class="card-header d-flex justify-content-between align-items-center row">
                    <div class="mb-3 col-6">
                        <label for="photo" class="form-label">Photo de profile</label>
                        <input type="file" name="photo" class="form-control" id="photo" multiple>
                        @error('photo')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 col-6">
                        <label for="is_active" class="form-label">Active</label>
                        <select class="form-select" name="is_active">
                            <option value="1" {{$data['admin']->is_active?'selected':''}}>True</option>
                            <option value="0" {{$data['admin']->is_active?'':'selected'}}>False</option>
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