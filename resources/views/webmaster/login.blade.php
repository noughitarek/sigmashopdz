@extends('layouts.base')
@section('head')
    @yield('subhead')
	<title>{{config('main.title')}} | Login</title>
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="{{asset('/img/icons/icon-48x48.png')}}" />
	<link href="{{asset('/css/app.css')}}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
@endsection
@section('body')
<main class="d-flex w-100">
  <div class="container d-flex flex-column">
    <div class="row vh-100">
      <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
        <div class="d-table-cell align-middle">
          <div class="text-center mt-4">
            <h1 class="h2">Welcome back!</h1>
            <p class="lead"> Sign in to your account to continue </p>
          </div>
          <div class="card">
            <div class="card-body">
              <div class="m-sm-3">
                <form method="POST" action="{{ route('webmaster_login') }}">
                @csrf
                  <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input class="form-control form-control-lg" type="email" name="email" placeholder="Enter your email" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input class="form-control form-control-lg" type="password" name="password" placeholder="Enter your password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                  </div>
                  <div>
                    <div class="form-check align-items-center">
                      <input id="customControlInline" type="checkbox" class="form-check-input" name="remember" checked>
                      <label class="form-check-label text-small" for="customControlInline">Remember me</label>
                    </div>
                  </div>
                  <div class="d-grid gap-2 mt-3">
                    <button type="submit" class="btn btn-lg btn-primary">Sign in</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection
@section('main_scripts')
	<script src="{{asset('js/app.js')}}"></script>
    @yield('scripts')
@endsection