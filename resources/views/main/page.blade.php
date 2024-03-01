@extends('layouts.main')
@section('content')
<section id="page-header" class="about-header">
    <h2>{{$data['page']->title}}</h2>
</section>
<section id="productdetails" class="section-p1">
    {!!$data['page']->content!!}
</section>
@endsection