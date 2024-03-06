@extends('layouts.base')
@section('head')
    @yield('subhead')
	<title>{{config('settings.title')}} | {{$data['title']}}</title>
    
    <title>e-commerce website</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
    
	<link href="{{asset('/css/style.css')}}" rel="stylesheet">
    <!-- Meta Pixel Code -->
    <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '{{config('settings.metapixel')}}');
    fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id={{config('settings.metapixel')}}&ev=PageView&noscript=1"
    /></noscript>
    <!-- End Meta Pixel Code -->
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