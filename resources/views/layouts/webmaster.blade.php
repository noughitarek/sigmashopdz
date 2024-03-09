@extends('layouts.base')
@section('head')
    @yield('subhead')
	<title>{{config('settings.title')}} | {{$data['title']}}</title>
	<link rel="preconnect" href="https://fonts.gstatic.com">
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
        document.documentElement.style.setProperty('--main-color', '#{{config("settings.webmasterColor")}}');

    </script>
    @endif
	<!--<script src="{{asset('js/settings.js')}}"></script>-->
    @yield('scripts')
@endsection