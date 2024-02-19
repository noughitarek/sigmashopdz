@extends('layouts.base')
@section('head')
    @yield('subhead')
	<title>{{config('webmaster.title')}} | {{$data['title']}}</title>
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="{{asset('/img/icons/icon-48x48.png')}}" />
	<link href="{{asset('/css/app.css')}}" rel="stylesheet">
	<link href="{{asset('/css/custom.css')}}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
@endsection
@section('body')
    <div class="wrapper">
        @include('layouts.webmaster.sidebar')
        <div class="main">
            @include('layouts.webmaster.navbar')
            <main class="content">
                @yield('content')
            </main>
            @include('layouts.webmaster.footer')
        </div>
    </div>

@endsection
@section('main_scripts')
	<script src="{{asset('js/app.js')}}"></script>
	<!--<script src="{{asset('js/settings.js')}}"></script>-->
    @yield('scripts')
@endsection