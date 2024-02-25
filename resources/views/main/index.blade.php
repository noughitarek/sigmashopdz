@extends('layouts.main')
@section('content')
    @include('layouts.main.slider')
    @include('layouts.main.features')
    @foreach($data['categories'] as $category)
    @include('components.category')
    @endforeach
@endsection