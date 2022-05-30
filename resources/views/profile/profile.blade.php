@extends('layouts.dashboard', ['title' => "Profile"])
@extends('layouts.app', ['title' => "Profile"])

@section('content')

<body style="background-color:#FFFFFF;">
	<div class="content">
		<div class="container-fluid">
			<!-- Vertical Layout -->
			<div class="row clearfix">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="card" style="border-radius:10px;">
						<div class="body">					
						<p style="font-style:italic; margin-bottom:30px;">*Some info may be visible to other</p>
						
								<label for="name">Photos</label>
								<div class="form-group">
									<div class="form-line">
										<table width="100%" cellpadding="0" cellspacing="0">
											<tr>
												<a class="button-ava" href="/ava-edit" style="display:block;">A photo helps personalize your account
													<br>


												<div style="float:right;margin-right:3%;"> 
												<?= empty(Auth::user()->avatar) ? 
													('<span class="avatar-material-letter-preview profile-pic-navbar-size-preview" style="background-color:' . generate_rand_material_color() . '">' . ucwords((Auth::user()->name)[0]) . '</span>') 
													: 
													('<img class="rounded-avatar-preview" title=" ' . Auth::user()->name . ' " style="border-radius: 50%; margin-top: -7px;width:70px;height:70px" width="70" height="70" alt="User" src="' . asset('storage/public/' . Auth::user()->avatar) . '" />') 
												?>
												</div>								
												<p style="font-style:italic; font-size:12px; margin-top:20px;">click here to edit</p>	
												</a>
											</tr>
										</table>			
									</div>
								</div>

							
		

								<form action="/user-update" method="post">
									{{ csrf_field() }}						
									<div class="row">
							            <div class="col-md-12">
							                <div class="body table-responsive">
							                    <table class="table" style="color:#555555;">
							                        	<tbody> 
							                            <input type="hidden" name="id" value="{{ $user->id }}"> 
							                            <tr>
							                                <td width="10%"><i class="material-icons" style="margin-top:-3.5px; margin-bottom:0px;">perm_identity</i></td>
							                                <td style="font-weight:bold;" width="40%;">Name</td>
							                                <td>
							                                	<div class="form-group">
								                                	<div class="form-line">
																		<input type="text" id="name" name="name" class="form-control" placeholder="Enter your Name" value="{{ $user->name }}">
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
																		<input type="mail" id="email" name="email" class="form-control" placeholder="Enter your Name" value="{{ $user->email }}">
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
																		<option <?php if ( $user->gender  == "male" ) echo 'selected' ; ?> value="male">Male</option>
																		<option <?php if ( $user->gender  == "female" ) echo 'selected' ; ?> value="female">Female</option>
												    
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
									                                    <input type="text" class="form-control" name="date" placeholder="Please choose a date..." value="<?php echo date('d/m/Y', strtotime($user->birth_date)); ?>">
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
																		<input type="text" id="phone" name="phone" class="form-control" placeholder="Enter your Name" value="{{ $user->phone }}">
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
																		<option <?php if ( $user->religion  == "islam" ) echo 'selected' ; ?> value="islam">Islam</option>
																		<option <?php if ( $user->religion  == "kristen" ) echo 'selected' ; ?> value="kristen">Kristen</option>
																		<option <?php if ( $user->religion  == "hindhu" ) echo 'selected' ; ?> value="hindhu">Hindhu</option>
																		<option <?php if ( $user->religion  == "budha" ) echo 'selected' ; ?> value="budha">Budha</option>
																		<option <?php if ( $user->religion  == "kong hu cu" ) echo 'selected' ; ?> value="kong hu cu">Kong Hu Cu</option>
																		<option <?php if ( $user->religion  == "others" ) echo 'selected' ; ?> value="others">Others</option>
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
																		<input type="text" id="placement_location" name="placement_location" class="form-control" placeholder="Write placement location" value="{{ $user->placement_location }}">
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
																		<textarea type="text" id="address" name="address" class="form-control" placeholder="Enter your Name" value="{{ $user->address }}"> {{ $user->address }} </textarea>
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
																		<option <?php if ( $user->marital_status  == "single" ) echo 'selected' ; ?> value="single">Single</option>
																		<option <?php if ( $user->marital_status  == "married" ) echo 'selected' ; ?> value="married">Married</option>
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
																		<input type="text" id="identity_card_no" name="identity_card_no" class="form-control" placeholder="Enter your Name" value="{{ $user->identity_card_no }}">
																	</div>
																</div>
															</td>
							                            </tr>
							                            
							                            
							                            </tbody>
							                    </table>
							                </div>
							            </div>
							        </div>


								<br>
								<button type="submit" class="btn-medi medi-green">SUBMIT</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>

@endsection