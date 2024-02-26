<footer class="section-p1 row">
    <div class="col">
        <h4>{{config('settings.footer.side1')}}</h4>
        <img src="{{asset('img/'.config('settings.logo'))}}" class="logo" alt="{{config('settings.title')}}">
        <p><strong>العنوان:</strong> {{config('settings.contact')["address"]}}</p>
        <p><strong>رقم الهاتف:</strong> <span dir="ltr">{{config('settings.contact')["phone"]}}</span></p>
        <p><strong>البريد الإلكتروني:</strong> <span dir="ltr">{{config('settings.contact')["email"]}}</span></p>
        <p>
            <a href="{{config('settings.contact')["facebook"]}}"><i class="fab fa-facebook-f"></i></a> &nbsp;
            <a href="{{config('settings.contact')["twitter"]}}"><i class="fab fa-twitter"></i></a> &nbsp;
            <a href="{{config('settings.contact')["instagram"]}}"><i class="fab fa-instagram"></i></a> &nbsp;
        </p>
    </div>
    <div class="col">
        <h4>{{config('settings.footer.side2')}}</h4>
        @foreach($data["footer_pages1"] as $page)
        <a href="{{route('main_pages_show', $page->slug)}}">{{$page->title}}</a>
        @endforeach
        <a href="{{route('main_echange')}}">طلب تغيير منتج</a>
        <a href="{{route('main_contact')}}">إتصل بنا</a>
    </div>
    <div class="col">
        <h4>{{config('settings.footer.side3')}}</h4>
        @foreach($data["footer_pages2"] as $page)
        <a href="{{route('main_pages_show', $page->slug)}}">{{$page->title}}</a>
        @endforeach
        <a href="{{route('main_tracking')}}">تتبع الطرود</a>
    </div>
    <div class="col install">
        <h4>{{config('settings.footer.side4')}}</h4>
        <p>من أب ستور أو جوجل بلاي</p>
        <div class="row">
            <img src="{{asset('img/website/pay/app.jpg')}}" alt="">
            <img src="{{asset('img/website/pay/play.jpg')}}" alt="">
        </div>
        <p>طرق الدفع المتوفرة</p>
        <div id="paymentMethods" class="row">
            <img class="paymentMethods" src="{{asset('img/website/pay/baridimob.png')}}" alt="الدفع عبر الإنترنت">
            <img class="paymentMethods" src="{{asset('img/website/pay/ccp.png')}}" alt="الدفع عبر بريد الجزائر">
            <img class="paymentMethods" src="{{asset('img/website/pay/cod.png')}}" alt="الدفع عند الإستلام">
        </div>
    </div>
    <div class="copyright">
        <p>تصميم و إستضافة <span>ITCentre</span> | كل الحقوق محفوضة | &#169; 2023</p>
    </div>
</footer>