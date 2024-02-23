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
				<a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#images" role="tab">
					Images
				</a>
				<a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#api" role="tab">
					API && tags
				</a>
				<a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#metadata" role="tab">
					Meta Data
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
		</div>
	</div>
</form>
@endsection