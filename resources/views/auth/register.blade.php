@extends('layouts.blank')
@extends('layouts.app')

@section('content')

<link href="{{ asset('plugins/sweetalert/sweetalert.css') }}" rel="stylesheet" />

<div style="background-color:#FFFFFF;overflow-x:hidden;">
	<div class="row">
		<div class="col-md-6" style="padding-right:0%;padding-bottom:0%;">
			<img src="images/team.png" width="100%;">
		</div>

		<div class="col-md-6" style="background-color:#FFFFFF;">
			<div class="login-page" style="max-width:500px">
				<div class="login-box">
					
					<div class="logo" style="margin-bottom:35px;color:#53bc00;">
						<center><h1>Register</h1></center>
					</div>
					<div class="body" style="height:480px;overflow-y:auto">
						<form method="POST" action="{{ route('register') }}">
							@csrf

							<div class="input-group">
								<label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

								<div class="col-md-8">
									<input id="name" type="text" class="form_login form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Name">

									@error('name')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>
							</div>

							<div class="input-group">
								<label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email Address') }}</label>

								<div class="col-md-8">
									<input id="email" type="email" class="form_login form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="E-mail">

									@error('email')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>
							</div>

							<div class="input-group">
								<label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

								<div class="col-md-8">
									<input id="password" type="password" class="form_login form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Password">

									@error('password')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>
							</div>

							<div class="input-group">
								<label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

								<div class="col-md-8">
									<input id="password-confirm" type="password" class="form_login form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm">
								</div>
							</div>

							<div class="input-group">
								<label for="identity_card_no" class="col-md-4 col-form-label text-md-right">{{ __('Gender') }}</label>

								<div class="col-md-8">
									<div class="form-regist">
										<select name="gender" id="gender">
											<option>- -Select Gender-  -</option>
											<option value="male">Male</option>
											<option value="female">Female</option>
										</select>
									</div>
								</div>
							</div>

							<div class="input-group">
								<label for="email_address" class="col-md-4 col-form-label text-md-right">Birth Date</label>
	                            <div class="col-md-8">
	                                <div class="form-line" id="bs_datepicker_container">
	                                    <input autocomplete="off" type="text" class="form-control" name="birth_date" placeholder="Please choose a date..." value="{{date('d/m').'/1990'}}">
	                                </div>
	                        	</div>
							</div>

							<div class="input-group">
								<label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Phone') }}</label>

								<div class="col-md-8">
									<input id="phone" type="text" class="form_login form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone" autofocus placeholder="Phone Number">

									@error('phone')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>
							</div>

							<div class="input-group">
								<label for="religion" class="col-md-4 col-form-label text-md-right">{{ __('Religion') }}</label>
									

								<div class="col-md-8">
									<div class="form-regist">
									<select name="religion" id="religion">
										<option>-  -Select Religion-  -</option>
										<option value="islam">Islam</option>
										<option value="katolik">Katolik</option>
										<option value="kristen">Kristen</option>
										<option value="hindhu">Hindhu</option>
										<option value="budha">Budha</option>
										<option value="kong hu cu">Kong Hu Cu</option>
										<option value="others">Others</option>
									</select>
									</div>
								</div>


									@error('religion')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
							</div>

							<div class="input-group">
								<label for="job_title" class="col-md-4 col-form-label text-md-right">{{ __('Job Title') }}</label>

								<div class="col-md-8">
									<input id="job_title" type="text" class="form_login form-control @error('job_title') is-invalid @enderror" name="job_title" value="{{ old('job_title') }}" required autocomplete="job_title" autofocus placeholder="Job Title">

									@error('job_title')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>
							</div>

							<div class="input-group">
								<label for="employee_type" class="col-md-4 col-form-label text-md-right">{{ __('Employee Type') }}</label>

								<div class="col-md-8">
									<div class="form-regist">
									<select name="employee_type" id="employee_type">
										<option>--Select Employee Type--</option>
										<option value="Full Time">Full Time</option>
										<option value="Part Time">Part Time</option>
										<option value="Freelance">Freelance</option>
										<option value="Internship">Internship</option>
									</select>
									</div>

									@error('employee_type')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>
							</div>

							<div class="input-group">
								<label for="placement_location" class="col-md-4 col-form-label text-md-right">{{ __('Placement Location') }}</label>

								<div class="col-md-8">
									<input id="placement_location" type="text" class="form_login form-control @error('placement_location') is-invalid @enderror" name="placement_location" value="{{ old('placement_location') }}" required autocomplete="placement_location" autofocus placeholder="Placement Location">

									@error('placement_location')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>
							</div>

							<div class="input-group">
								<label for="email_address" class="col-md-4 col-form-label text-md-right">Start Date</label>
	                            <div class="col-md-8">
	                                <div class="form-line" id="bs_datepicker_container">
	                                    <input autocomplete="off" type="text" class="form-control" name="start_date" placeholder="Please choose a date...">
	                                </div>
	                        	</div>
							</div>

							<div class="input-group">
								<label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>

								<div class="col-md-8">
									<input id="address" type="text" class="form_login form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}" required autocomplete="address" autofocus placeholder="Address">

									@error('address')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>
							</div>

							<div class="input-group">
								<label for="identity_card_no" class="col-md-4 col-form-label text-md-right">{{ __('Marital Status') }}</label>

								<div class="col-md-8">
									<div class="form-regist">
									<select name="marital_status" id="marital_status">
										<option>-  - Select Marital Status-  -</option>
										<option value="single">Single</option>
										<option value="married">Married</option>
									</select>
									</div>
								</div>
							</div>

							<div class="input-group">
								<label for="identity_card_no" class="col-md-4 col-form-label text-md-right">{{ __('Identity Card No') }}</label>

								<div class="col-md-8">
									<input id="identity_card_no" type="text" class="form_login form-control @error('identity_card_no') is-invalid @enderror" name="identity_card_no" value="{{ old('identity_card_no') }}" required autocomplete="identity_card_no" autofocus placeholder="Identity Card No">

									@error('identity_card_no')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>
							</div>

							<div class="input-group">
								<div class="col-xs-6" style="margin-bottom:5%;">
									<button class="btn btn-block waves-effect" style="background-color:#53bc00; color:#FFFFFF;border-radius:10px;" type="submit">REGISTER</button>
								</div>
							</div>
						</form>

						<div class="js-sweetalert">
							<button style="visibility: hidden;" id="info" class="btn btn-primary waves-effect" data-type="info">CLICK ME</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$( "#selector" ).datepicker({
	  dateFormat: "dd/mm/yyyy"
	});
</script>

<script type="text/javascript">
window.onload =  function() {
// use var to check if a link has been clicked
var clickedOnce = false;
document.getElementById('job_title').onclick = function() {
	// will only alert when clickedOnce is false
	if(!clickedOnce) {
		clickedOnce = true;
		// alert('you clicked me');
		document.getElementById("info").click();
	}
}
}
</script>

<script src="{{ asset('plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('js/pages/ui/dialogs.js') }}"></script>

@endsection