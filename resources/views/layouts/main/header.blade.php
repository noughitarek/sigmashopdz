<section id="header">
    <a href="{{route('main_index')}}">
        <img src="{{asset('img/'.config('settings.logo_tall'))}}" class="logo" alt="{{config('settings.title')}}">
    </a>
    <div>
        <ul id="navbar">
            <li>
                <a class="{{$data['current_page']=='home'?'active':''}}" href="{{route('main_index')}}">الصفحة الرئيسية</a>
            </li>
            @foreach($data["header_pages"] as $page)
            <li>
                <a class="{{$data['current_page']==$page->slug?'active':''}}" href="{{route('main_pages_show', $page->slug)}}">{{$page->title}}</a>
            </li>
            @endforeach
            <li>
                <a class="{{$data['current_page']=='echange'?'active':''}}" href="{{route('main_echange')}}">طلب تغيير منتج</a>
            </li>
            <li>
                <a class="{{$data['current_page']=='contact'?'active':''}}" href="{{route('main_contact')}}">إتصل بنا</a>
            </li>
            <li id="lg-bag"><a href="cart.html"><i class="far fa-shopping-bag"></i></a></li>
            <a href="#" id="close"><i class="far fa-times"></i></a>
        </ul>
    </div>
    <div id="mobile">
        <a href="cart.html"><i class="far fa-shopping-bag"></i></a>
        <i id="bar" class="fas fa-outdent"></i>
    </div>
</section>