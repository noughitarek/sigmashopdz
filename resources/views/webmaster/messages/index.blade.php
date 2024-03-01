@extends('layouts.webmaster')
@section('content')
<div class="row">
  <div class="col-12 col-lg-12 col-xxl-12 d-flex">
    <div class="card flex-fill">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">{{$data["title"]}}</h5>
      </div>
    </div>
  </div>
  <div class="col-12 col-lg-12 col-xxl-12 d-flex">
    <div class="card flex-fill">
      <div class="table-responsive">
        <table class="table table-hover my-0" id="datatables-messages">
          <thead>
            <tr>
              <th class="d-xl-table-cell">Sender</th>
              <th class="d-xl-table-cell">Subject</th>
              <th class="d-xl-table-cell">Message</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($data["messages"] as $message)
            <tr>
              <td class="d-xl-table-cell single-line">
                <p>
                  <i class="align-middle me-2 fas fa-fw fa-hashtag"></i> <a href="{{route('webmaster_messages_show', $message->id)}}">{{$message->id}}</a><br>
                  <i class="align-middle me-2 fas fa-fw fa-user-tie"></i> {{$message->name}}<br>
                  <i class="align-middle me-2 fas fa-fw fa-phone"></i> {{$message->phone}}<br>
                  <i class="align-middle me-2 fas fa-fw fa-calendar"></i> {{$message->created_at}}
                </p>
              </td>
              <td class="d-xl-table-cell single-line">
                <i class="align-middle me-2 fas fa-fw fa-arrows-alt-v"></i>{{$message->subject}}<br>
                <i class="align-middle me-2 fas fa-fw fa-globe"></i>{{ $message->ip }}<br>
                <i class="align-middle me-2 fas fa-fw fa-barcode"></i> 
                @if($message->tracking!=null)
                <a target="_blank" href="{{route('main_orders_tracking', $message->tracking)}}">{{$message->tracking}}</a>
                @endif
              </td>
              <td class="d-xl-table-cell">
                {{$message->message}}
              </td>
              <td>
                @if($data["can_delete"])
                <button type="button" class="btn btn-danger rounded-pill" data-bs-toggle="modal" data-bs-target="#messageDeleteModal{{$message->id}}">
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
@foreach($data["messages"] as $message)
<div class="modal fade" id="messageDeleteModal{{$message->id}}" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
        <h5 class="modal-title">Confirm Deletion</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body m-3">
        <p class="mb-0">Are you sure you want to delete this message?</p>
			</div>
			<div class="modal-footer">
        <form action="{{ route('webmaster_messages_destroy', $message->id) }}" method="POST">
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