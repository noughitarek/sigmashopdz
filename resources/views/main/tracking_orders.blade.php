@extends('layouts.main')
@section('content')
<section id="page-header" class="about-header">
    <h2>تتبع الطرود</h2>
    <p>يرجى ملئ النموذج</p>
</section>
<section id="form-details">
    <form method="POST" action="{{route('main_pages_tracking_lookup')}}">
        @csrf
        <h2>يرجى ملئ النموذج </h2>
        
        <div class="container" style="width: 100%;">
            <div class="label-container">
                <label for="tracking" dir="rtl">رقم التتبع <span style="color: red;">*</span></label>
                <label for="tracking" dir="ltr">Numéro de suivi <span style="color: red;">*</span></label>
            </div>
            <input dir="ltr" type="text" id="tracking" placeholder="{{config('settings.id')}}..." name="tracking" required>
        </div>

        <button class="normal">تتبع</button>
    </form>
</section>
@endsection