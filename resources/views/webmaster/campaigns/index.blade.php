@extends('layouts.webmaster')
@section('content')
<div class="row">
  <div class="col-12 col-lg-12 col-xxl-12 d-flex">
    <div class="card flex-fill">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">{{$data["title"]}}</h5>
        @if($data["can_create"])
        <a href="{{route('webmaster_campaigns_create')}}" class="btn btn-primary" > Create a campaign </a>
        @endif
      </div>
    </div>
  </div>
  <div class="col-12 col-lg-12 col-xxl-12 d-flex">
    <div class="card flex-fill">
      <div class="table-responsive">
        <table class="table table-hover my-0" id="datatables-campaigns">
          <thead>
            <tr>
              <th class="d-xl-table-cell">Campaign</th>
              <th class="d-xl-table-cell">Budget</th>
              <th class="d-xl-table-cell">Start/end date</th>
              <th class="d-xl-table-cell">Orders</th>
              <th class="d-xl-table-cell">Created</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @foreach($data["campaigns"] as $campaign)
            <tr>
              <td class="d-xl-table-cell single-line">
                <p>
                  <i class="align-middle me-2 fas fa-fw fa-hashtag"></i> <a href="{{route('webmaster_campaigns_show', $campaign->id)}}">{{$campaign->id}}</a><br>
                  <i class="align-middle me-2 fas fa-fw fa-user-tie"></i> {{$campaign->name}}<br>
                  <i class="align-middle me-2 fas fa-fw fa-phone"></i> {{$campaign->slug}}
                  
                </p>
              </td>
              <td class="d-xl-table-cell single-line">
                <p>
                  <i class="align-middle me-2 fas fa-fw fa-dollar-sign"></i> {{$campaign->daily_budget}}$/day<br>
                  <i class="align-middle me-2 fas fa-fw fa-box"></i> {{$campaign->total_budget}}$<br>
                  <i class="align-middle me-2 fas fa-fw fa-calendar"></i> {{$campaign->created_at}}
                </p>
              </td>
              <td class="d-xl-table-cell single-line">
                <p>
                <i class="align-middle me-2 fas fa-fw fa-sort-amount-down"></i> {{$campaign->started_at}}<br>
                <i class="align-middle me-2 fas fa-fw fa-sort-amount-up"></i> {{$campaign->ended_at}}<br>
                </p>
              </td>
              <td class="d-xl-table-cell single-line">
                <i class="align-middle me-2 fas fa-fw fa-box"></i>
                <span class="text-primary">{{$campaign->Total_delivery_orders_number()}}</span>
                |
                <span class="text-success">{{$campaign->Total_delivered_orders_number()}}</span>
                |
                <span class="text-danger">{{$campaign->Total_back_orders_number()}}</span>
                |
                <span>{{$campaign->Total_orders_number()}}</span><br>
                <span class="text-primary">
                  <i class="align-middle me-2 fas fa-fw fa-dollar-sign"></i>{{$campaign->Total_delivery_orders_amount()}} DZD
                </span><br>
                <span class="text-success">
                  <i class="align-middle me-2 fas fa-fw fa-dollar-sign"></i>{{$campaign->Total_delivered_orders_number()}} DZD
                </span><br>
                <span class="text-danger">
                  <i class="align-middle me-2 fas fa-fw fa-dollar-sign"></i>{{$campaign->Total_back_orders_amount()}} DZD
                </span><br>
                <span>
                  <i class="align-middle me-2 fas fa-fw fa-dollar-sign"></i>{{$campaign->Total_orders_amount()}} DZD
                </span>
              </td>
              
              <td class="d-xl-table-cell single-line">
                <i class="align-middle me-2 fas fa-fw fa-user-gear"></i>{{$campaign->Created_by()->name}}<br>
                <i class="align-middle me-2 fas fa-fw fa-calendar"></i>{{$campaign->created_at}}
              </td>
              <td>
                
                @if($data["can_edit"])
                <a href="{{route('webmaster_campaigns_edit', $campaign['id'])}}" class="btn btn-primary btn-icon rounded-pill" >
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
    
  {{ $data["campaigns"]->links('components.pagination') }}
  </div>
</div>

@endsection