@extends('layouts.webmaster')
@section('content')

<div class="row">
  <div class="col-12 col-lg-12 col-xxl-12 d-flex">
    <div class="card flex-fill">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">{{$data["title"]}}</h5>
        @if($data["can_create"])
        <a href="{{route('webmaster_categories_create')}}" class="btn btn-primary" > Create a category </a>
        @endif
      </div>
    </div>
  </div>
  <div class="col-12 col-lg-12 col-xxl-12 d-flex">
    <div class="card flex-fill">
      <div class="card-header"></div>
      <div class="card-body">
        <table class="table table-hover my-0" id="categories_table">
          <thead>
            <tr>
              <th>Category</th>
              <th class="d-xl-table-cell">Information</th>
              <th class="d-xl-table-cell">Products</th>
              <th class="d-xl-table-cell">Orders</th>
              <th class="d-xl-table-cell">Created</th>
              <th class="d-xl-table-cell">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($data["categories"] as $category)
            <tr>
              <td class="d-xl-table-cell single-line">
                <i class="align-middle me-2 fas fa-fw fa-hashtag"></i> <a href="{{route('webmaster_categories_show', $category['id'])}}">{{$category["id"]}}</a><br>
                <i class="align-middle me-2 fas fa-fw fa-list-alt"></i> {{$category->name}}<br>
                <i class="align-middle me-2 fas fa-fw fa-qrcode"></i> {{$category->slug}}
              </td>
              <td class="d-xl-table-cell single-line">
                <i class="align-middle me-2 fas fa-fw fa-toggle-on"></i>{{ $category->is_active?"Active":"Not active" }}<br>
                <i class="align-middle me-2 fas fa-fw fa-calendar"></i>{{$category->created_at}}
              </td>
              <td class="d-xl-table-cell single-line">
                @for($i=0;$i<count($category->Products());$i++)
                  @if($i>=2)
                  Showing {{$i}} of {{count($category->Products())}} products
                  @break
                  @endif
                  @if($i==0)
                  <i class="align-middle me-2 fas fa-fw fa-box"></i>
                  @else
                  <i class="align-middle me-2 fas fa-fw"></i>
                  @endif
                  <a href="{{route('webmaster_products_show', $category->Products()[$i]->id)}}">{{$category->Products()[$i]->name}}</a><br>
                @endfor
              </td>
              <td class="d-xl-table-cell single-line">
                <i class="align-middle me-2 fas fa-fw fa-box"></i>
                <span class="text-primary">{{$category->Total_delivery_orders_number()}}</span>
                |
                <span class="text-success">{{$category->Total_delivered_orders_number()}}</span>
                |
                <span class="text-danger">{{$category->Total_back_orders_number()}}</span>
                |
                <span>{{$category->Total_orders_number()}}</span><br>
                <span class="text-primary">
                  <i class="align-middle me-2 fas fa-fw fa-dollar-sign"></i>{{$category->Total_delivery_orders_amount()}} DZD
                </span><br>
                <span class="text-success">
                  <i class="align-middle me-2 fas fa-fw fa-dollar-sign"></i>{{$category->Total_delivered_orders_number()}} DZD
                </span><br>
                <span class="text-danger">
                  <i class="align-middle me-2 fas fa-fw fa-dollar-sign"></i>{{$category->Total_back_orders_amount()}} DZD
                </span><br>
                <span>
                  <i class="align-middle me-2 fas fa-fw fa-dollar-sign"></i>{{$category->Total_orders_amount()}} DZD
                </span>
              </td>
              <td class="d-xl-table-cell single-line">
                <i class="align-middle me-2 fas fa-fw fa-user-gear"></i>{{$category->Created_by()->name}}<br>
                <i class="align-middle me-2 fas fa-fw fa-calendar"></i>{{$category->created_at}}
              </td>
              <td>
                
                @if($data["can_edit"])
                <a href="{{route('webmaster_categories_edit', $category['id'])}}" class="btn btn-primary btn-icon rounded-pill" >
                  <i class="align-middle" data-feather="edit"></i>
                </a>
                @endif
                
                @if($data["can_delete"])
                <button type="button" class="btn btn-danger rounded-pill" data-bs-toggle="modal" data-bs-target="#categoryDeleteModal{{$category->id}}">
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
</div>


@foreach($data["categories"] as $category)
<div class="modal fade" id="categoryDeleteModal{{$category->id}}" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
        <h5 class="modal-title">Confirm Deletion</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body m-3">
        <p class="mb-0">Are you sure you want to delete this category?</p>
			</div>
			<div class="modal-footer">
        <form action="{{ route('webmaster_categories_destroy', $category->id) }}" method="POST">
          @csrf
          @method('DELETE')
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger">Delete</button>
        </form>
			</div>
		</div>
	</div>
</div>
@endforeach
@endsection
@section('scripts')
<script src="{{asset('js/datatables.js')}}"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
	$("#categories_table").DataTable({
		responsive: true
	});
});
</script>
@if(session('success'))
<script>
	document.addEventListener("DOMContentLoaded", function() {
			var message = '{{ session('success') }}';
			var type = "success";
			var duration = 5000;
			var ripple = false;
			var dismissible = true;
			var positionX = "right";
			var positionY = "top";
			window.notyf.open({type, message, duration, ripple, dismissible, position:{x: positionX, y: positionY}});
	});
</script>
@endif
@endsection