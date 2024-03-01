@extends('layouts.webmaster')
@section('content')
<form action="{{route('webmaster_settings_edit')}}" method="POST" enctype="multipart/form-data">
@csrf
<div class="row">
  <div class="col-12 col-lg-12 col-xxl-12 d-flex">
    <div class="card flex-fill">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">{{$data["title"]}}</h5>
		@if($data["can_edit"])
		<button type="submit" class="btn btn-primary">Save changes</button>
		@endif
      </div>
    </div>
  </div>
    <div class="col-md-3 col-xl-2">
        <div class="card">
			<div class="card-header">
				<h5 class="card-title mb-0">Settings</h5>
			</div>
			<div class="list-group list-group-flush" role="tablist">
				<a class="list-group-item list-group-item-action active" data-bs-toggle="list" href="#general" role="tab">
					General
				</a>
				<a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#social" role="tab">
					Social media
				</a>
				<a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#footer" role="tab">
					Footer titles
				</a>
				<a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#images" role="tab">
					Images
				</a>
				<a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#api" role="tab">
					API && tags
				</a>
				<a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#metadata" role="tab">
					Meta Data
				</a>
				<a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#features" role="tab">
					Features
				</a>
				<a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#hero" role="tab">
					Hero
				</a>
				<a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#notifications" role="tab">
					Notifications
				</a>
			</div>
		</div>
	</div>
	<div class="col-md-9 col-xl-10">
		<div class="tab-content">
			<div class="tab-pane fade show active" id="general" role="tabpanel">
				<div class="card">
					<div class="card-header">
						<h5 class="card-title mb-0">General</h5>
					</div>
					<div class="card-body">
						<div class="row mb-2">
							<div class="col-md-12">
								<div class="mb-3">
									<label class="form-label" for="id">ID</label>
									<input type="text" class="form-control" name="id" id="id" value="{{config('settings.id')}}">
								</div>
								<div class="mb-3">
									<label class="form-label" for="title">Title</label>
									<input type="text" class="form-control" name="title" id="title" value="{{config('settings.title')}}">
								</div>
								<div class="mb-3">
									<label class="form-label" for="address">Address</label>
									<input type="text" class="form-control" name="contact[address]" id="address" value="{{config('settings.contact.address')}}">
								</div>
								<div class="mb-3">
									<label class="form-label" for="phone">Phone</label>
									<input type="text" class="form-control" name="contact[phone]" id="phone" value="{{config('settings.contact.phone')}}">
								</div>
								<div class="mb-3">
									<label class="form-label" for="email">Email</label>
									<input type="text" class="form-control" name="contact[email" id="email" value="{{config('settings.contact.email')}}">
								</div>
							</div>
						</div>
						@if($data["can_edit"])
						<button type="submit" class="btn btn-primary">Save changes</button>
						@endif
					</div>
				</div>
			</div>
			<div class="tab-pane fade" id="social" role="tabpanel">
				<div class="card">
					<div class="card-header">
						<h5 class="card-title mb-0">Social media</h5>
					</div>
					<div class="card-body">
						<div class="row mb-2">
							<div class="col-md-12">
								<div class="mb-3">
									<label class="form-label" for="facebook">Facebook</label>
									<input type="text" class="form-control" name="contact[facebook]" id="facebook" value="{{config('settings.contact.facebook')}}">
								</div>
								<div class="mb-3">
									<label class="form-label" for="twitter">Twitter</label>
									<input type="text" class="form-control" name="contact[twitter]" id="twitter" value="{{config('settings.contact.twitter')}}">
								</div>
								<div class="mb-3">
									<label class="form-label" for="instagram">Instagram</label>
									<input type="text" class="form-control" name="contact[instagram]" id="instagram" value="{{config('settings.contact.instagram')}}">
								</div>
							</div>
						</div>
						@if($data["can_edit"])
						<button type="submit" class="btn btn-primary">Save changes</button>
						@endif
					</div>
				</div>
			</div>
			<div class="tab-pane fade" id="footer" role="tabpanel">
				<div class="card">
					<div class="card-header">
						<h5 class="card-title mb-0">Footer titles</h5>
					</div>
					<div class="card-body">
						<div class="row mb-2">
							<div class="col-md-12">
								<div class="mb-3">
									<label class="form-label" for="side1">Side1</label>
									<input type="text" class="form-control" name="footer[side1]" id="side1" value="{{config('settings.footer.side1')}}">
								</div>
								<div class="mb-3">
									<label class="form-label" for="side2">Side2</label>
									<input type="text" class="form-control" name="footer[side2]" id="side2" value="{{config('settings.footer.side2')}}">
								</div>
								<div class="mb-3">
									<label class="form-label" for="side">Side3</label>
									<input type="text" class="form-control" name="footer[side3]" id="side3" value="{{config('settings.footer.side3')}}">
								</div>
								<div class="mb-3">
									<label class="form-label" for="side4">Side4</label>
									<input type="text" class="form-control" name="footer[side4]" id="side4" value="{{config('settings.footer.side4')}}">
								</div>
							</div>
						</div>
						@if($data["can_edit"])
						<button type="submit" class="btn btn-primary">Save changes</button>
						@endif
					</div>
				</div>
			</div>
			<div class="tab-pane fade" id="images" role="tabpanel">
				<div class="card">
					<div class="card-header">
						<h5 class="card-title mb-0">Images</h5>
					</div>
					<div class="card-body">
						<div class="row mb-2">
							<div class="col-md-4">
								<label for="logo">Logo</label>
								<div class="text-center">
									<img src="{{asset('img/'.config('settings.logo'))}}" class="rounded-circle img-responsive mt-2" width="128" height="128" />
									<div class="mt-2">
										<input type="file" name="logo" class="form-control" id="logo">
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<label for="logo_tall">Logo tall</label>
								<div class="text-center">
									<img src="{{asset('img/'.config('settings.logo_tall'))}}" class="rounded-circle img-responsive mt-2" width="128" height="128" />
									<div class="mt-2">
										<input type="file" name="logo_tall" class="form-control" id="logo_tall">
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<label for="icon">Icon</label>
								<div class="text-center">
									<img src="{{asset('img/'.config('settings.icon'))}}" class="rounded-circle img-responsive mt-2" width="128" height="128" />
									<div class="mt-2">
										<input type="file" name="icon" class="form-control" id="icon">
									</div>
								</div>
							</div>
						</div>
						@if($data["can_edit"])
						<button type="submit" class="btn btn-primary">Save changes</button>
						@endif
					</div>
				</div>
			</div>
			<div class="tab-pane fade" id="api" role="tabpanel">
				<div class="card">
					<div class="card-header">
						<h5 class="card-title mb-0">API && tags</h5>
					</div>
					<div class="card-body mb-2">
						<div class="mb-3">
							<label class="form-label" for="ecotrack_link">Ecotrack link</label>
							<input type="url" class="form-control" name="ecotrack_link" id="ecotrack_link" value="{{config('settings.ecotrack_link')}}">
						</div>
						<div class="mb-3">
							<label class="form-label" for="ecotrack_api">Ecotrack api</label>
							<input type="text" class="form-control" name="ecotrack_api" id="ecotrack_api" value="{{config('settings.ecotrack_api')}}">
						</div>
						<div class="mb-3">
							<label class="form-label" for="metapixel">Meta pixel</label>
							<input type="text" class="form-control" name="metapixel" id="metapixel" value="{{config('settings.metapixel')}}">
						</div>
						<div class="mb-3">
							<label class="form-label" for="googleanalytics">Google Analytics Tag</label>
							<input type="text" class="form-control" name="googleanalytics" id="googleanalytics" value="{{config('settings.googleanalytics')}}">
						</div>
						@if($data["can_edit"])
						<button type="submit" class="btn btn-primary">Save changes</button>
						@endif
					</div>
				</div>
			</div>
			<div class="tab-pane fade" id="metadata" role="tabpanel">
				<div class="card">
					<div class="card-header">
						<h5 class="card-title mb-0">Meta Data</h5>
					</div>
					<div class="card-body mb-2">
						@foreach(config('settings.metadata') as $key=>$value)
						<div class="mb-3">
							<label class="form-label" for="{{$key}}">{{$key}}</label>
							<input type="text" class="form-control" name="metadata[{{$key}}]" id="{{$key}}" value="{{$value}}">
						</div>
						@endforeach
						@if($data["can_edit"])
						<button type="submit" class="btn btn-primary">Save changes</button>
						@endif
					</div>
				</div>
			</div>
			<div class="tab-pane fade" id="features" role="tabpanel">
    			@for($i=1;$i<=6;$i++)
				<div class="card">
					<div class="card-header">
						<h5 class="card-title mb-0">Features</h5>
					</div>
					<div class="card-body mb-2">
						<div class="row mb-2 d-flex align-items-center">
							
							<label for="logo">Feature {{$i}}</label>
								
							<div class="col-md-8">
								<div class="mb-3">
									<input type="text" class="form-control" name="feature{{$i}}[content]" id="{{$i}}" value="{{config('settings.feature'.$i)['content']}}">
								</div>
							</div>
							<div class="col-md-4">
								<img src="{{asset('img/'.config('settings.feature'.$i)['picture'])}}" class="rounded-circle img-responsive mt-2" width="128" height="128" />
								<div class="mt-2">
									<input type="file" name="feature{{$i}}[picture]" class="form-control" id="logo">
								</div>
							</div><br>
						</div>
					</div>
				</div>

				@endfor
				@if($data["can_edit"])
				<button type="submit" class="btn btn-primary">Save changes</button>
				@endif
			</div>
			<div class="tab-pane fade" id="hero" role="tabpanel">
				<div class="card">
					<div class="card-header">
						<h5 class="card-title mb-0">Hero</h5>
					</div>
					<div class="card-body mb-2">
						<div class="row mb-2 d-flex align-items-center">
							
								
							<div class="col-md-8">
								<div class="mb-3">
									<label for="herotext1">Text 1</label>
									<input type="text" class="form-control" name="slider[text1]" id="herotext1" value="{{config('settings.slider')['text1']}}">
								</div>
								<div class="mb-3">
									<label for="herotext2">Text 2</label>
									<input type="text" class="form-control" name="slider[text2]" id="herotext2" value="{{config('settings.slider')['text2']}}">
								</div>
								<div class="mb-3">
									<label for="herotext3">Text 3</label>
									<input type="text" class="form-control" name="slider[text3]" id="herotext3" value="{{config('settings.slider')['text3']}}">
								</div>
								<div class="mb-3">
									<label for="herotext4">Text 4</label>
									<input type="text" class="form-control" name="slider[text4]" id="herotext4" value="{{config('settings.slider')['text4']}}">
								</div>
								<div class="mb-3">
									<label for="herotext4">Button</label>
									<input type="text" class="form-control" name="slider[button]" id="herobutton" value="{{config('settings.slider')['button']}}">
								</div>
							</div>
							<div class="col-md-4">
								<img src="{{asset('img/'.config('settings.slider')['picture'])}}" class="rounded-circle img-responsive mt-2" width="128" height="128" />
								<div class="mt-2">
									<input type="file" name="slider[picture]" class="form-control" id="logo">
								</div>
							</div><br>
						</div>
					</div>
				</div>
				@if($data["can_edit"])
				<button type="submit" class="btn btn-primary">Save changes</button>
				@endif
			</div>
			<div class="tab-pane fade" id="notifications" role="tabpanel">
				<div class="card">
					<div class="card-header">
						<h5 class="card-title mb-0">Notifications</h5>
					</div>
					<div class="card-body mb-2">
						<div class="row mb-2 d-flex align-items-center">
							<div class="col-md-12">
								<div class="mb-3">
									<label for="username">Username</label>
									<input type="text" class="form-control" name="notifications[username]" id="username" value="{{config('settings.notifications.username')}}">
								</div>
								<div class="mb-3">
									<label for="password">Password</label>
									<input type="text" class="form-control" name="notifications[password]" id="password" value="{{config('settings.notifications.password')}}">
								</div>
								<div class="mb-3">
									<label for="api_token">Api token</label>
									<input type="text" class="form-control" name="notifications[api_token]" id="api_token" value="{{config('settings.notifications.api_token')}}">
								</div>
								<div class="mb-3">
									<label for="package">Package</label>
									<input type="text" class="form-control" name="notifications[package]" id="package" value="{{config('settings.notifications.package')}}">
								</div>
							</div>
						</div>
					</div>
				</div>
				@if($data["can_edit"])
				<button type="submit" class="btn btn-primary">Save changes</button>
				@endif
			</div>
		</div>
	</div>
</form>
@endsection