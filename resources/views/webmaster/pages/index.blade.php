@extends('layouts.webmaster')
@section('content')
<div class="row">
  <div class="col-12 col-lg-12 col-xxl-12 d-flex">
    <div class="card flex-fill">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">{{$data["title"]}}</h5>
        @if($data["can_create"])
        <a href="{{route('webmaster_pages_create')}}" class="btn btn-primary" > Create a page </a>
        @endif
      </div>
    </div>
  </div>
  <div class="col-12 col-lg-12 col-xxl-12 d-flex">
    <div class="card flex-fill">
      <div class="table-responsive">
        <table class="table table-hover my-0" id="datatables-pages">
          <thead>
            <tr>
              <th class="d-xl-table-cell">Page</th>
              <th class="d-xl-table-cell">Budget</th>
              <th class="d-xl-table-cell">Created</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($data["pages"] as $page)
            <tr>
              <td class="d-xl-table-cell single-line">
                <p>
                  <i class="align-middle me-2 fas fa-fw fa-hashtag"></i> <a href="{{route('webmaster_pages_show', $page->id)}}">{{$page->id}}</a><br>
                  <i class="align-middle me-2 fas fa-fw fa-user-tie"></i> {{$page->title}}<br>
                  <i class="align-middle me-2 fas fa-fw fa-phone"></i> {{$page->slug}}
                </p>
              </td>
              <td class="d-xl-table-cell single-line">
                <i class="align-middle me-2 fas fa-fw fa-arrows-alt-v"></i>{{$page->position}}<br>
                <i class="align-middle me-2 fas fa-fw fa-toggle-on"></i>{{ $page->is_active?"Active":"Not active" }}<br>
                <i class="align-middle me-2 fas fa-fw fa-calendar"></i>{{$page->created_at}}
              </td>

              <td class="d-xl-table-cell single-line">
                <i class="align-middle me-2 fas fa-fw fa-user"></i>{{$page->Created_by()->name}}<br>
                <i class="align-middle me-2 fas fa-fw fa-calendar"></i>{{$page->created_at}}
              </td>
              <td>
                
                @if($data["can_edit"])
                <a href="{{route('webmaster_pages_edit', $page['id'])}}" class="btn btn-primary btn-icon rounded-pill" >
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
    
  {{ $data["pages"]->links('components.pagination') }}
  </div>
</div>

@endsection