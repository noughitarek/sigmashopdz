@extends('layouts.main')
@section('content')
<section id="page-header" class="about-header">
    <h2>إتصل بنا</h2>
    <p>يرجى ملئ النموذج</p>
</section>
<section id="form-details">
    <form method="POST" action="{{route('main_contact_store')}}">
        @csrf
        <h2>يرجى ملئ النموذج </h2>

        <div class="container" style="width: 100%;">
            <div class="label-container">
                <label for="name" dir="rtl">الإسم الكامل <span style="color: red;">*</span></label>
                <label for="name" dir="ltr">Nom complet <span style="color: red;">*</span></label>
            </div>
            <input type="text" id="name" name="name" required>
        </div>
        
        <div class="container" style="width: 100%;">
            <div class="label-container">
                <label for="phone" dir="rtl">رقم الهاتف <span style="color: red;">*</span></label>
                <label for="phone" dir="ltr">Numéro de téléphone <span style="color: red;">*</span></label>
            </div>
            <input type="text" id="phone" name="phone" required>
        </div>
        
        <div class="container" style="width: 100%;">
            <div class="label-container">
                <label for="subject" dir="rtl">الموضوع <span style="color: red;">*</span></label>
                <label for="subject" dir="ltr">Sujet <span style="color: red;">*</span></label>
            </div>
            <input type="text" id="subject" name="subject" required>
        </div>
        
        <div class="container" style="width: 100%;">
            <div class="label-container">
                <label for="message" dir="rtl">الرسالة<span style="color: red;">*</span></label>
                <label for="message" dir="ltr">Message <span style="color: red;">*</span></label>
            </div>
            <textarea id="message" name="message" required></textarea>
        </div>
        <button class="normal">إرسال</button>
    </form>
</section>
@endsection