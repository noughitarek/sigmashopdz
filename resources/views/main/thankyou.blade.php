@extends('layouts.main')
@section('content')
<section id="page-header" class="about-header">
    <h2>تم تقديم الطلب بنجاح</h2>
    <p>{{$data['order']->intern_tracking}}</p>
</section>
<section id="productdetails" class="section-p1">
    <div class="single-pro-image">
        <h3>تم تقديم الطلب بنجاح</h3><br>
        <img src="{{asset('img/icons/correct.png')}}"/>
        <h1>شكراا</h1> 
        <h3>سيتم الإتصال بك قريبا لتأكيد الطلب</h3>
        <h4>يمكنك متابعة حالة الأنية للطرد عبر الموقع</h4>
    </div>
    <div class="single-pro-details">
        <h2>معلوماتك الشخصية</h2>
        <p>
            الإسم: {{$data['order']->name}}<br>
            رقم الهاتف: {{$data['order']->phone}}<br>
            العنوان: {{$data['order']->address.' '.$data['order']->Commune()->name_ar.' '.$data['order']->Wilaya()->name_ar}}
        </p>
        <br>
        <h2>معلومات حول الطرد</h2>
        <p>
            رمز التتبع: <a target="_blank" href="{{route('main_orders_tracking', $data['order']->intern_tracking)}}">{{$data['order']->intern_tracking}}</a><br>
            المنتج: {{$data['order']->Product()->name}}<br>
            الكمية: {{$data['order']->quantity}}<br>
            السعر الإجمالي: {{$data['order']->total_price}}دج
        </p>
        
        @foreach($data['categories'] as $category)
        @include('components.category')
        @endforeach

    </div>
</section>

@endsection