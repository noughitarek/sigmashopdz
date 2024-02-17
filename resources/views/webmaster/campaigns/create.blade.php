@extends('layouts.webmaster')
@section('content')
<form action ="{{route('webmaster_campaigns_store')}}" method="POST"> 
    @csrf
    <div class="row">
        <div class="col-12 col-lg-12 col-xxl-12 d-flex">
            <div class="card flex-fill">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">{{$data["title"]}}</h5>
                <div>
                    <a href="{{route('webmaster_campaigns_index')}}" class="btn btn-danger" > Back </a>
                    <button type="submit" class="btn btn-primary" > Create </button>
                </div>
            </div>
            </div>
        </div>
        <div class="col-12 col-lg-12 col-xxl-12 d-flex">
            <div class="card flex-fill">
                <div class="card-header d-flex justify-content-between align-items-center row">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" id="name" required>
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" name="slug" class="form-control" id="slug" required>
                        @error('slug')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-12 col-xxl-12 d-flex">
            <div class="card flex-fill">
                <div class="card-header d-flex justify-content-between align-items-center row">
					<div class="mb-3 col-6">
						<label class="form-label">Start date *</label>
						<input type="text" name="start_date" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" required/>
						<span class="text-muted">e.g "DD/MM/YYYY"</span>
					</div>
					<div class="mb-3 col-6">
						<label class="form-label">End date </label>
						<input type="text" name="end_date" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" />
						<span class="text-muted">e.g "DD/MM/YYYY"</span>
					</div>
					<div class="mb-3 col-6">
						<label class="form-label">Daily budget</label>
						<input type="text" class="form-control" name="daily_budget"
							data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'" />
						<span class="text-muted">e.g "$ 9,95"</span>
					</div>
					<div class="mb-3 col-6">
						<label class="form-label">Total budget</label>
						<input type="text" class="form-control" name="total_budget"
							data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'" />
						<span class="text-muted">e.g "$ 9,95"</span>
					</div>
                    <div class="mb-3">
                        <label for="is_active" class="form-label">Active</label>
                        <select class="form-select mb-3" name="is_active">
                            <option value="1" selected>True</option>
                            <option value="0">False</option>
                        </select>
                        @error('is_active')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary" > Create </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
