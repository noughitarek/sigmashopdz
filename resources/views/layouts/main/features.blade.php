<section id="feature" class="section-p1">
    @for($i=1;$i<=6;$i++)
    <div class="fe-box">
        <img src="{{asset('/img/'.config('settings.feature'.$i)['picture'])}}" alt="{{config('settings.feature'.$i)['content']}}">
        <h6>{{config('settings.feature'.$i)['content']}}</h6>
    </div>
    @endfor
</section>