@extends('layouts.main')
@section('content')
<section id="page-header" class="about-header">
    <h2>طلب تغيير منتج</h2>
    <p>يرجى ملئ النموذج</p>
</section>
<section id="form-details">
    <form method="POST" action="{{route('main_echange_store')}}">
        @csrf
        <span>بعد وصول المنتج ب24ساعة لا يأخذ الطلب بعين الإعتبار</span>
        <h2>يرجى ملئ النموذج </h2>

        <div class="container" style="width: 100%;">
            <div class="label-container">
                <label for="name" dir="rtl">الإسم الكامل <span style="color: red;ba">*</span></label>
                <label for="name" dir="ltr">Nom complet <span style="color: red;">*</span></label>
            </div>
            <input type="text" id="name" name="name" required>
        </div>
        
        <div class="container" style="width: 100%;">
            <div class="label-container">
                <label for="phone" dir="rtl">رقم الهاتف <span style="color: red;ba">*</span></label>
                <label for="phone" dir="ltr">Numéro de téléphone <span style="color: red;">*</span></label>
            </div>
            <input type="text" id="phone" name="phone" required>
        </div>
        
        <div class="container" style="width: 100%;">
            <div class="label-container">
                <label for="product" dir="rtl">المنتج <span style="color: red;">*</span></label>
                <label for="product" dir="ltr">Produit <span style="color: red;">*</span></label>
            </div>
            <select id="product" name="product" required>
			    <option value="" selected disabled>اختر المنتج</option>
                @foreach($data['products'] as $product)
                <option value="{{$product->id}}">{{$product->name}}</option>
                @endforeach
            </select>
        </div>
        
        <div class="container" style="width: 100%;">
            <div class="label-container">
                <label for="tracking" dir="rtl">رقم التتبع <span style="color: red;">*</span></label>
                <label for="tracking" dir="ltr">Numéro de suivi <span style="color: red;">*</span></label>
            </div>
            <input dir="ltr" type="text" id="tracking" placeholder="{{config('settings.id')}}..." name="tracking" required>
        </div>
        
        <div class="container" style="width: 100%;">
            <div class="label-container">
                <label for="motif" dir="rtl">سبب الطلب<span style="color: red;">*</span></label>
                <label for="motif" dir="ltr">Motif de la demande <span style="color: red;">*</span></label>
            </div>
            <textarea id="motif" name="motif" required></textarea>
        </div>
        <button class="normal">إرسال الطلب</button>
    </form>
</section>
@endsection