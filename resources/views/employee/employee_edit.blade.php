@extends('layouts.dashboard', ['title' => "edit employee"])
@extends('layouts.app', ['title' => "employee"])

@section('content')

<body style="background-color:#FFFFFF;">
<div class="content">
	<div class="container-fluid">
		<!-- Vertical Layout -->
		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card" style="border-radius:10px;">
					<div class="body">
						<form action="/employee-update" method="post">
							{{ csrf_field() }}						
							<div class="row">
					            <div class="col-md-12">
					                <div class="body table-responsive">
					                    <table class="table" style="color:#555555;">
				                        	<tbody> 
				                            <input type="hidden" name="id" value="{{ $employee->id }}"> 
				                            <tr>
				                                <td width="10%"><i class="material-icons" style="margin-top:-3.5px; margin-bottom:0px;">perm_identity</i></td>
				                                <td style="font-weight:bold;" width="40%;">Name</td>
				                                <td>
				                                	<div class="form-group">
					                                	<div class="form-line">
															<input type="text" id="name" name="name" class="form-control" placeholder="Enter your Name" value="{{ $employee->name }}">
														</div>
													</div>
												</td>
				                            </tr>
				                            <tr>
				                                <td><i class="material-icons" style="margin-top:-3.5px; margin-bottom:0px;">email</i></td>
				                                <td style="font-weight:bold;">Email</td>
				                                <td>
					                                <div class="form-group">
														<div class="form-line">
															<input type="mail" id="email" name="email" class="form-control" placeholder="Enter your Name" value="{{ $employee->email }}">
														</div>
													</div>
												</td>
				                            </tr>
				                            <tr>
				                                <td><i class="fas fa-venus-mars material-icons"></i></td>
				                                <td style="font-weight:bold;">Gender</td>
				                                <td>
				                                	<div class="textarea-medi">
				                                        <select class="form-control show-tick" id="gender" name="gender">
															<option <?php if ( $employee->gender  == "male" ) echo 'selected' ; ?> value="male">Male</option>
															<option <?php if ( $employee->gender  == "female" ) echo 'selected' ; ?> value="female">Female</option>
									    
														</select>
				                                    </div>
				                                </td>
				                            </tr>
				                            <tr>
				                                <td><i class="material-icons" style="margin-top:-3.5px; margin-bottom:0px;">cake</i></td>
				                                <td style="font-weight:bold;">Birthdate</td>
				                                <td>
				                                	<div class="form-group">
						                                <div class="form-line" id="bs_datepicker_container">
						                                    <input type="text" class="form-control" name="date" placeholder="Please choose a date..." value="<?php echo date('d/m/Y', strtotime($employee->birth_date)); ?>">
						                                </div>
					                            	</div>
				                                </td>
				                            </tr>
				                            <tr>
				                                <td><i class="material-icons">phone</i></td>
				                                <td style="font-weight:bold;">Phone</td>
				                                <td>
				                                	<div class="form-group">
														<div class="form-line">
															<input type="text" id="phone" name="phone" class="form-control" placeholder="Enter your Name" value="{{ $employee->phone }}">
														</div>
													</div>
				                                </td>
				                            </tr>
				                            <tr>
				                                <td><i class="fas fa-universal-access material-icons"></i></td>
				                                <td style="font-weight:bold;">Religion</td>
				                                <td>
				                                	<div class="textarea-medi">
				                                        <select class="form-control show-tick" id="religion" name="religion">
															<option <?php if ( $employee->religion  == "islam" ) echo 'selected' ; ?> value="islam">Islam</option>
															<option <?php if ( $employee->religion  == "kristen" ) echo 'selected' ; ?> value="kristen">Kristen</option>
															<option <?php if ( $employee->religion  == "hindhu" ) echo 'selected' ; ?> value="hindhu">Hindhu</option>
															<option <?php if ( $employee->religion  == "budha" ) echo 'selected' ; ?> value="budha">Budha</option>
															<option <?php if ( $employee->religion  == "kong hu cu" ) echo 'selected' ; ?> value="kong hu cu">Kong Hu Cu</option>
															<option <?php if ( $employee->religion  == "others" ) echo 'selected' ; ?> value="others">Others</option>
														</select>
				                                    </div>
				                                </td>
				                            </tr>
				                            <tr>
				                                <td><i class="material-icons" style="margin-top:-3.5px; margin-bottom:0px;">work</i></td>
				                                <td style="font-weight:bold;">Job Title</td>
				                                <td>
				                                	<div class="form-group">
														<div class="form-line">
															<input type="text" id="job_title" name="job_title" class="form-control" placeholder="Write Job Title" value="{{ $employee->job_title }}">
														</div>
													</div>
				                                </td>
				                            </tr>
				                            <tr>
				                                <td><i class="material-icons" style="margin-top:-3.5px; margin-bottom:0px;">access_time</i></td>
				                                <td style="font-weight:bold;">Employee Type</td>
				                                <td>
				                                	<div class="textarea-medi">
				                                        <select class="form-control show-tick" id="employee_type" name="employee_type">
															<option <?php if ( $employee->employee_type  == "Full Time" ) echo 'selected' ; ?> value="Full Time">Full Time</option>
															<option <?php if ( $employee->employee_type  == "Part Time" ) echo 'selected' ; ?> value="Part Time">Part Time</option>
															<option <?php if ( $employee->employee_type  == "Freelance" ) echo 'selected' ; ?> value="Freelance">Freelance</option>
															<option <?php if ( $employee->employee_type  == "Internship" ) echo 'selected' ; ?> value="Internship">Internship</option>														
														</select>
				                                    </div>
				                                </td>
				                            </tr>
				                            <tr>
				                                <td><i class="material-icons" style="margin-top:-3.5px; margin-bottom:0px;">business</i></td>
				                                <td style="font-weight:bold;">Placement Location</td>
				                                <td>
				                                	<div class="form-group">
														<div class="form-line">
															<input type="text" id="placement_location" name="placement_location" class="form-control" placeholder="Write placement location" value="{{ $employee->placement_location }}">
														</div>
													</div>
				                                </td>
				                            </tr>
				                            <tr>
				                                <td><i class="material-icons" style="margin-top:-3.5px; margin-bottom:0px;">home</i></td>
				                                <td style="font-weight:bold;">Address</td>
				                                <td>
				                                	<div class="form-group">
														<div class="form-line">
															<textarea type="text" id="address" name="address" class="form-control" placeholder="Enter your Name" value="{{ $employee->address }}"> {{ $employee->address }} </textarea>
														</div>
													</div>
				                                </td>
				                            </tr>
				                            <tr>
				                                <td><i class="material-icons" style="margin-top:-3.5px; margin-bottom:0px;">favorite</i></td>
				                                <td style="font-weight:bold;">Marital Status</td>
				                                <td>
				                                	<div class="textarea-medi">
				                                        <select class="form-control show-tick" id="marital_status" name="marital_status">
															<option <?php if ( $employee->marital_status  == "single" ) echo 'selected' ; ?> value="single">Single</option>
															<option <?php if ( $employee->marital_status  == "married" ) echo 'selected' ; ?> value="married">Married</option>
														</select>
				                                    </div>
				                                </td>
				                            </tr>
				                            <tr>
				                                <td><i class="material-icons" style="margin-top:-3.5px; margin-bottom:0px;">credit_card</i></td>
				                                <td style="font-weight:bold;">Identity Card No</td>
				                                <td>
				                                	<div class="form-group">
														<div class="form-line">
															<input type="text" id="identity_card_no" name="identity_card_no" class="form-control" placeholder="Enter your Name" value="{{ $employee->identity_card_no }}">
														</div>
													</div>
												</td>
				                            </tr>
				                            <tr>
				                                <td><i class="material-icons" style="margin-top:-3.5px; margin-bottom:0px;">accessibility</i></td>
				                                <td style="font-weight:bold;">Access Type</td>
				                                <td>
				                                	<div class="textarea-medi">
				                                        <select class="form-control show-tick" id="access_type" name="access_type">
															<option <?php if ( $employee->access_type  != "admin" ) echo 'selected' ; ?> value="">User</option>
															<option <?php if ( $employee->access_type  == "admin" ) echo 'selected' ; ?> value="admin">admin</option>
														</select>
				                                    </div>
				                                </td>
				                            </tr>
				                            
				                            
				                            </tbody>
					                    </table>
					                    <button type="submit" class="btn-medi medi-green">SUBMIT</button>
					                </div>
					            </div>
					        </div>


							
							
						</form>


						<!-- <form action="/employee-update" method="post">
							{{ csrf_field() }}
							<input type="hidden" name="id" value="{{ $employee->id }}">
							
							<label for="name">Name</label>
							<div class="form-group">
								<div class="form-line">
									<input type="text" id="name" name="name" class="form-control" placeholder="Enter your Name" value="{{ $employee->name }}">
								</div>
							</div>

							<label for="email">Email</label>
							<div class="form-group">
								<div class="form-line">
									<input type="mail" id="email" name="email" class="form-control" placeholder="Enter your Name" value="{{ $employee->email }}">
								</div>
							</div>

							<label for="gender">Gender</label>
							<div class="row clearfix" id="gender" name="gender">
								<div class="col-sm-6">
									<select class="form-control show-tick" id="gender" name="gender">
										<option <?php if ( $employee->gender  == "male" ) echo 'selected' ; ?> value="male">Male</option>
										<option <?php if ( $employee->gender  == "female" ) echo 'selected' ; ?> value="female">Female</option>
					    
									</select>
								</div>
							</div>

							<label for="phone">Phone</label>
							<div class="form-group">
								<div class="form-line">
									<input type="text" id="phone" name="phone" class="form-control" placeholder="Enter your Name" value="{{ $employee->phone }}">
								</div>
							</div>

							<label for="address">Address</label>
							<div class="form-group">
								<div class="form-line">
									<input type="text" id="address" name="address" class="form-control" placeholder="Enter your Name" value="{{ $employee->address }}">
								</div>
							</div>

							<label for="job_title">Job Title</label>
							<div class="form-group">
								<div class="form-line">
									<input type="text" id="job_title" name="job_title" class="form-control" placeholder="Enter Job Title" value="{{ $employee->job_title }}">
								</div>
							</div>

							<label for="employee_type">Employee Type</label>
							<div class="row clearfix" id="employee_type" name="employee_type">
								<div class="col-sm-6">
									<select class="form-control show-tick" id="employee_type" name="employee_type">
										<option <?php if ( $employee->employee_type  == "Full Time" ) echo 'selected' ; ?> value="Full Time">Full Time</option>
										<option <?php if ( $employee->employee_type  == "Part Time" ) echo 'selected' ; ?> value="Part Time">Part Time</option>
					   					<option <?php if ( $employee->employee_type  == "Freelance" ) echo 'selected' ; ?> value="Freelance">Freelance</option>
					   					<option <?php if ( $employee->employee_type  == "Internship" ) echo 'selected' ; ?> value="Internship">Internship</option>
									</select>
								</div>
							</div>

							<label for="marital_status">Marital Status</label>
							<div class="form-group">
								<div class="form-line">
									<input type="text" id="marital_status" name="marital_status" class="form-control" placeholder="Enter your Name" value="{{ $employee->marital_status }}">
								</div>
							</div>

							<label for="identity_card_no">Identity Card No</label>
							<div class="form-group">
								<div class="form-line">
									<input type="text" id="identity_card_no" name="identity_card_no" class="form-control" placeholder="Enter your Name" value="{{ $employee->identity_card_no }}">
								</div>
							</div>
							<br>
							<button type="submit" class="btn-medi medi-green">SUBMIT</button>
							<a href="/list_employee" class="btn-medi medi-red">BATAL</a>
						</form> -->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</body>

@endsection