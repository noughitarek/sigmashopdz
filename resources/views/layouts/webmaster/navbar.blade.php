@php
$notifications = Auth::user()->Notifications();
@endphp

<nav class="navbar navbar-expand navbar-light navbar-bg">
  <a class="sidebar-toggle js-sidebar-toggle">
    <i class="hamburger align-self-center"></i>
  </a>
  <div class="navbar-collapse collapse">
    <ul class="navbar-nav navbar-align">
      <li class="nav-item dropdown">
        <a class="nav-icon dropdown-toggle" href="#" id="alertsDropdown" data-bs-toggle="dropdown">
          <div class="position-relative">
            <i class="align-middle" data-feather="bell"></i>
            @if($notifications != null)
            <span class="indicator">{{count($notifications)}}</span>
            @endif
          </div>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0" aria-labelledby="alertsDropdown">
          <div class="dropdown-menu-header"> {{$notifications != null?count($notifications):0}} New Notifications </div>
          <div class="list-group">
            @if($notifications != null)
            @foreach($notifications as $notification)
            <a href="{{$notification->link}}" class="list-group-item">
              <div class="row g-0 align-items-center">
                <div class="col-2">
                  <i class="text-{{$notification->icon_color}}" data-feather="{{$notification->icon}}"></i>
                </div>
                <div class="col-10">
                  <div class="text-dark">{{$notification->title}}</div>
                  <div class="text-muted small mt-1">{{$notification->content}}</div>
                  <div class="text-muted small mt-1">30m ago</div>
                </div>
              </div>
            </a>
            @endforeach
            @endif
          </div>
          <div class="dropdown-menu-footer">
            <a href="#" class="text-muted">Show all notifications</a>
          </div>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-icon dropdown-toggle" href="#" id="messagesDropdown" data-bs-toggle="dropdown">
          <div class="position-relative">
            <i class="align-middle" data-feather="message-square"></i>
          </div>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0" aria-labelledby="messagesDropdown">
          <div class="dropdown-menu-header">
            <div class="position-relative"> 4 New Messages </div>
          </div>
          <div class="list-group">
            <a href="#" class="list-group-item">
              <div class="row g-0 align-items-center">
                <div class="col-2">
                  <img src="{{asset('img/avatars/avatar-5.jpg')}}" class="avatar img-fluid rounded-circle" alt="Vanessa Tucker">
                </div>
                <div class="col-10 ps-2">
                  <div class="text-dark">Vanessa Tucker</div>
                  <div class="text-muted small mt-1">Nam pretium turpis et arcu. Duis arcu tortor.</div>
                  <div class="text-muted small mt-1">15m ago</div>
                </div>
              </div>
            </a>
            <a href="#" class="list-group-item">
              <div class="row g-0 align-items-center">
                <div class="col-2">
                  <img src="{{asset('img/avatars/avatar-2.jpg')}}" class="avatar img-fluid rounded-circle" alt="William Harris">
                </div>
                <div class="col-10 ps-2">
                  <div class="text-dark">William Harris</div>
                  <div class="text-muted small mt-1">Curabitur ligula sapien euismod vitae.</div>
                  <div class="text-muted small mt-1">2h ago</div>
                </div>
              </div>
            </a>
            <a href="#" class="list-group-item">
              <div class="row g-0 align-items-center">
                <div class="col-2">
                  <img src="{{asset('img/avatars/avatar-4.jpg')}}" class="avatar img-fluid rounded-circle" alt="Christina Mason">
                </div>
                <div class="col-10 ps-2">
                  <div class="text-dark">Christina Mason</div>
                  <div class="text-muted small mt-1">Pellentesque auctor neque nec urna.</div>
                  <div class="text-muted small mt-1">4h ago</div>
                </div>
              </div>
            </a>
            <a href="#" class="list-group-item">
              <div class="row g-0 align-items-center">
                <div class="col-2">
                  <img src="{{asset('img/avatars/avatar-3.jpg')}}" class="avatar img-fluid rounded-circle" alt="Sharon Lessman">
                </div>
                <div class="col-10 ps-2">
                  <div class="text-dark">Sharon Lessman</div>
                  <div class="text-muted small mt-1">Aenean tellus metus, bibendum sed, posuere ac, mattis non.</div>
                  <div class="text-muted small mt-1">5h ago</div>
                </div>
              </div>
            </a>
          </div>
          <div class="dropdown-menu-footer">
            <a href="#" class="text-muted">Show all messages</a>
          </div>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
          <i class="align-middle" data-feather="settings"></i>
        </a>
        <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
          <img src="{{Auth::user()->Profile_image()}}" class="avatar img-fluid rounded me-1" alt="{{Auth::user()["name"]}}" />
          <span class="text-dark">{{Auth::user()["name"]}}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-end">
          <span class="dropdown-item">
              {{Auth::user()["role"]}}
          </span>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="{{route('webmaster_profile_index')}}">
            <i class="align-middle me-1" data-feather="user"></i> Profile </a>
          <a class="dropdown-item" href="#">
            <i class="align-middle me-1" data-feather="pie-chart"></i> Analytics </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="index.html">
            <i class="align-middle me-1" data-feather="settings"></i> Settings & Privacy </a>
          <a class="dropdown-item" href="#">
            <i class="align-middle me-1" data-feather="help-circle"></i> Help Center </a>
          <div class="dropdown-divider"></div>
          <form method="POST" action="{{ route('webmaster_logout') }}">
            @csrf
            <a :href="route('webmaster_logout')" class="dropdown-item" onclick="event.preventDefault(); this.closest('form').submit();">
              Log out
            </a>
          </form>
        </div>
      </li>
    </ul>
  </div>
</nav>