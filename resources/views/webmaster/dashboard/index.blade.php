@extends('layouts.webmaster')
@section('content')
<div class="container-fluid p-0">
    <div class="row mb-2 mb-xl-3">
        <div class="col-auto d-none d-sm-block">
            <h3><strong>{{config('settings.title')}}</strong> Dashboard</h3>
        </div>
    </div>
    <div class="row">
        @include('webmaster.dashboard.revenue')
        @include('webmaster.dashboard.income')
        @include('webmaster.dashboard.orders')
        @include('webmaster.dashboard.monthlyRevenue')
        @include('webmaster.dashboard.monthlyIncome')
        @include('webmaster.dashboard.monthlyOrders')
        @include('webmaster.dashboard.deliveryRate')
        @include('webmaster.dashboard.products')
    </div>
</div>
@endsection