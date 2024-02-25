@extends('layouts.base')
@section('head')
    @yield('subhead')
	<title>{{config('settings.title')}} | {{$data['title']}}</title>
    
    <title>e-commerce website</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
    
	<link href="{{asset('/css/style.css')}}" rel="stylesheet">
@endsection
@section('body')
<div dir="rtl">
    @include('layouts.main.header')
    @yield('content')
    @include('layouts.main.newsletter')
    @include('layouts.main.footer')
</div>
@endsection
@section('main_scripts')
	<script src="{{asset('js/all.js')}}"></script>
	<!--<script src="{{asset('js/settings.js')}}"></script>-->
    @yield('scripts')
@endsection