<nav id="sidebar" class="sidebar js-sidebar">
  <div class="sidebar-content js-simplebar">
    <a class="sidebar-brand" href="index.html">
      <span class="align-middle">{{config("app.name")}}</span>
    </a>
    <ul class="sidebar-nav">
      @foreach(config("webmaster") as $link)
        @if(is_string($link))
          <li class="sidebar-header"> {{$link}} </li>
        @elseif(is_array($link))
          @if(Auth::user()->Has_Permission($link[3]))
            @if(substr(explode("webmaster_", Route::currentRouteName())[1], 0, strlen($link[4])) === $link[4])
              <li class="sidebar-item active">
            @else
              <li class="sidebar-item">
            @endif
              <a class="sidebar-link" href="{{route($link[1])}}">
                <i class="align-middle" data-feather="{{$link[2]}}"></i>
                <span class="align-middle">{{$link[0]}}</span>
              </a>
            </li>
          @endif
        @endif
      @endforeach
    </ul>
  </div>
</nav>