
<!-- Put a symlink from /public/storage to /storage/app/public folder -->
<!-- php artisan storage:link -->

@extends('layouts.dashboard', ['title' => "profile picture"])
@extends('layouts.app', ['title' => "profile"])

@section('content')
	<div class="container"> 
		<div class="row">
			
		</div>
		<div class="row justify-content-center">

			

		</div>
		<div class="row justify-content-center">
			
		</div>
	</div>

	<div class="container">
		<div class="row">
			@if ($message = Session::get('success'))
				<div class="alert alert-success alert-block">
					<button type="button" class="close" data-dismiss="alert">×</button>
					<strong>{{ $message }}</strong>
				</div>
			@endif

			@if (count($errors) > 0)
				<div class="alert alert-danger">
					<strong>Whoops!</strong> There were some problems with your input.<br><br>
					<ul>
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif

			<div class="col-md-5">
				<div class="panel panel-default">
				  <div class="panel-heading" style="font-weight:bold;">Upload Your Avatar </div>
				  <div class="panel-body">

				  	<div class="profile-header-container">
						<div class="profile-header-img">
							<img class="rounded-circle" width="100px" src="{{ asset('storage/public/' . Auth::user()->avatar) }}" />
							<!-- badge -->
							<div class="rank-label-container">
								<span class="label label-default rank-label">{{Auth::user()->name}}</span>
							</div>
						</div>
					</div>

				  	<strong style="font-size:12px;">Upload file .jpeg, .gif, .png, .jpg *</strong>

				     <form action="/ava-update" method="post" enctype="multipart/form-data">
						@csrf
						<div class="form-group">
							<input type="file" class="white-badge" name="avatar" aria-describedby="fileHelp">

							<small id="fileHelp" class="form-text text-muted">Please upload a valid image file. Size of image should not be more than 2MB.</small>
						</div>
						<input type='submit' name='submit' value='Upload' class="btn-medi medi-green">
					</form>

				  	</div>
				</div>

		     <!-- Form -->
		    </div>
		</div>
	</div>
@endsection