@extends('layouts.webmaster')
@section('content')
@csrf
<div class="row">
  <div class="col-12 col-lg-12 col-xxl-12 d-flex">
    <div class="card flex-fill">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">{{$data["title"]}}</h5>
      </div>
    </div>
  </div>
    <div class="col-md-3 col-xl-2">
        <div class="card">
			<div class="card-header">
				<h5 class="card-title mb-0">Profile</h5>
			</div>
			<div class="list-group list-group-flush" role="tablist">
				<a class="list-group-item list-group-item-action active" data-bs-toggle="list" href="#account" role="tab">
					Account
				</a>
				<a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#password" role="tab">
					Password
				</a>
			</div>
		</div>
	</div>
	<div class="col-md-9 col-xl-10">
		<div class="tab-content">
			<div class="tab-pane fade show active" id="account" role="tabpanel">
				<form action="{{route('webmaster_profile_edit')}}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="card">
						<div class="card-header">
							<h5 class="card-title mb-0">Public info</h5>
						</div>
						<div class="card-body">
								<div class="row">
									<div class="col-md-8">
										<div class="mb-3">
											<label class="form-label" for="name">Name</label>
											<input type="text" class="form-control" name="name" id="name" value="{{$data['user']->name}}">
										</div>
										<div class="mb-3">
											<label class="form-label" for="email">Email</label>
											<input type="email" class="form-control" name="email" id="email" value="{{$data['user']->email}}">
										</div>
										<div class="mb-3">
											<label class="form-label" for="phone">Phone</label>
											<input type="phone" class="form-control" name="phone" id="phone" value="{{$data['user']->phone}}">
										</div>
										<div class="mb-3">
											<label class="form-label" for="phone2">Phone2</label>
											<input type="phone" class="form-control" name="phone2" id="phone2" value="{{$data['user']->phone2}}">
										</div>
									</div>
									<div class="col-md-4">
										<div class="text-center">
											
											<img alt="{{$data['user']->name}}" src="{{$data['user']->Profile_image()}}" class="rounded-circle img-responsive mt-2"
												width="128" height="128" />
											<div class="mt-2">
												<input type="file" name="profile_image" class="form-control" id="profile_image">
											</div>
										</div>
									</div>
								</div>
								<button type="submit" class="btn btn-primary">Save changes</button>
						</div>
					</div>
				</form>
			</div>
			<div class="tab-pane fade" id="password" role="tabpanel">
				<form action="{{route('webmaster_profile_password_edit')}}" method="POST">
					@csrf
					@method('put')
					<div class="card">
						<div class="card-body">
							<h5 class="card-title">Password</h5>
							<div class="mb-3">
								<label class="form-label" for="inputPasswordCurrent">Current password</label>
								<input type="password" class="form-control" name="oldPassword" id="inputPasswordCurrent">
							</div>
							<div class="mb-3">
								<label class="form-label" for="inputPasswordNew">New password</label>
								<input type="password" class="form-control" name="newPassword" id="inputPasswordNew">
							</div>
							<div class="mb-3">
								<label class="form-label" for="inputPasswordNew2">Verify password</label>
								<input type="password" class="form-control" name="verifyPassword" id="inputPasswordNew2">
							</div>
							<button type="submit" class="btn btn-primary">Save changes</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
</form>
@endsection