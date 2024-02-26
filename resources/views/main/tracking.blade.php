@extends('layouts.main')
@section('content')
<section id="page-header" class="about-header">
    <h2>تتبع الطرود</h2>
    <p>{{$data['order']->intern_tracking}}</p>
</section>
<section id="productdetails" class="section-p1">
    <div class="single-pro-image">
        <h1>تتبع الطرود</h1> 
    </div>
    <div class="single-pro-details">
        <h2>حالة الطرد: {{$data['order']->intern_tracking}}</h2>
        <ul class="timeline">
            @foreach($data['order']->Transactions() as $date=>$transaction)
            <li class="timeline-item">
                <div class="date">{{$date}}</div>
                <div class="content">
                    <h3>{{$transaction}}</h3>
                </div>
            </li>
            @endforeach
        </ul>
        @foreach($data['categories'] as $category)
        @include('components.category')
        @endforeach

    </div>
</section>

@endsection