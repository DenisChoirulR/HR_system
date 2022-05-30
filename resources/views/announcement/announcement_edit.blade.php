@extends('layouts.dashboard', ['title' => "edit announcement"])
@extends('layouts.app', ['title' => "Announcement"])

@section('content')

<body style="background-color:#FFFFFF;">
	<div class="content">
		<div class="container-fluid">
			<!-- Vertical Layout -->
			<div class="row clearfix">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="card">
						<div class="body">
							@foreach($announcements as $a)
							<form action="/announcement-update" method="POST">
								@csrf
								<input type="hidden" name="id" required="required" value="{{ $a->id }}">
								<label for="email_address"> Title </label>
									<div class="form-group">
										<div class="form-line">
											<input type="text" id="code" class="form-control" name="title" required="required" value="{{ $a->title }}">
										</div>
									</div>
								<label for="password"> Note </label>
									<div class="form-group">
										<div class="form-line">
											<input type="text" id="name" class="form-control"  name="note" required="required" value="{{ $a->note }}">
										</div>
									</div>

								<input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

	                            <label for="email_address">Expired date of Announcement</label>
	                            <div class="form-group">
	                                <div class="form-line" id="bs_datepicker_container">
	                                    <input type="text" class="form-control" name="expired_at" placeholder="Please choose a date..." value="<?php echo date('d/m/Y', strtotime($a->expired_at))?>">
	                                </div>
	                            </div> 

								<br>
								<button type="submit" class="btn-medi medi-green">SUBMIT</button>
								<a href="/announcement" class="btn-medi medi-red" style="margin-left:5px;"> BATAL </a> 

							</form>
							@endforeach
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
@endsection