<section id="feature" class="section-p1">
    @foreach(config('settings.features') as $feature)
    <div class="fe-box">
        <img src="{{asset('/img/'.$feature['picture'])}}" alt="{{$feature['content']}}">
        <h6>{{$feature['content']}}</h6>
    </div>
    @endforeach
</section>