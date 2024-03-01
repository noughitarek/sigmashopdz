@extends('layouts.webmaster')
@section('content')
<div class="row">
  <div class="col-12 col-lg-12 col-xxl-12 d-flex">
    <div class="card flex-fill">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">{{$data["title"]}}</h5>
        @if($data["can_create"])
        <a href="{{route('webmaster_attributes_create')}}" class="btn btn-primary" > Create an attribute </a>
        @endif
      </div>
    </div>
  </div>
  <div class="col-12 col-lg-12 col-xxl-12 d-flex">
    <div class="card flex-fill">
      <div class="table-responsive">
        <table class="table table-hover my-0" id="datatables-attributes">
          <thead>
            <tr>
              <th class="d-xl-table-cell">Attribute</th>
              <th class="d-xl-table-cell">Values</th>
              <th class="d-xl-table-cell">Created</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($data["attributes"] as $attribute)
            <tr>
              <td class="d-xl-table-cell single-line">
                <p>
                  <i class="align-middle me-2 fas fa-fw fa-hashtag"></i> <a href="{{route('webmaster_attributes_show', $attribute->id)}}">{{$attribute->id}}</a><br>
                  <i class="align-middle me-2 fas fa-fw fa-user-tie"></i> {{$attribute->title}}<br>
                  <i class="align-middle me-2 fas fa-fw fa-phone"></i> {{$attribute->Product()->name}}
                </p>
              </td>
              <td class="d-xl-table-cell single-line">
                <i class="align-middle me-2 fas fa-fw fa-layouts"></i>{{$attribute->values}}
                <i class="align-middle me-2 fas fa-fw fa-layouts"></i>{{$attribute->values_ar}}
              </td>
              <td class="d-xl-table-cell single-line">
                <i class="align-middle me-2 fas fa-fw fa-user-gear"></i>{{$attribute->Created_by()->name}}<br>
                <i class="align-middle me-2 fas fa-fw fa-calendar"></i>{{$attribute->created_at}}
              </td>
              <td>
                
                @if($data["can_edit"])
                <a href="{{route('webmaster_attributes_edit', $attribute['id'])}}" class="btn btn-primary btn-icon rounded-pill" >
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

@endsection