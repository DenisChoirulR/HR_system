@extends('layouts.dashboard', ['title' => "Time Off List"])
@extends('layouts.app', ['title' => "Time Off"])

@section('content')


<body style="background-color:#FFFFFF;">
	<div class="content">
		@if(Session::has('message'))
	        <div class="alert alert-success alert-block">
				<button type="button" class="close" data-dismiss="alert">×</button>
				<p><strong>{{ Session::get('message') }}</strong></p>
			</div>
	    @endif
		<div class="row">
			<a href="/leave-type-add" class="btn-medi medi-green admin" style="margin:15px; float:right;"> Create Leave Type </a>
	    </div>
	    <div class="container-fluid">
			<div class="row">
	    		@foreach($leave_usages as $l)
					<div class="col-md-6">
						<div class="card" style="border-radius:5px;">
							<div class="header" style="background-color:#f3f3f3;">
				                <h2>
				                    <span style="text-transform:uppercase;">{{ $l->name }}</span>
				                </h2>
				            </div>
						
<!-- 							<div style="width:100%;text-align:center;margin-top:10%; margin-bottom:10%;color:#7d7d7d; font-size:18px;">
					        		<p>{{ $l->max_available - $l->used_count }} Balance
					        		</p>
					        		<p>{{ $l->max_available }} Quota
									</p>
									<p>{{ $l->used_count }} Used
									</p>
					    	</div> -->
					    	<div class="body" style="height: 135px; padding: 15px; width: 80%; margin: auto;" >
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" style="padding: 8px;">
									
										<div class="card-subheader">balance</div>
										<hr style="margin:0px auto; text-align: center; width: 50%; border: 1px solid #f3f3f3;">
										<p style="font-size: 42px; text-align: center;">{{ $l->max_available - $l->used_count }}</p>
									
								</div>
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" style="padding: 8px;">
									
										<div class="card-subheader">quota</div>
										<hr style="margin:0px auto; text-align: center; width: 50%; border: 1px solid #f3f3f3;">
										<p style="font-size: 42px; text-align: center;">{{ $l->max_available }}</p>
									
								</div>
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" style="padding: 8px;">
									
										<div class="card-subheader">used</div>
										<hr style="margin:0px auto; text-align: center; width: 50%; border: 1px solid #f3f3f3;">
										<p style="font-size: 42px; text-align: center;">{{ $l->used_count }}</p>
									
								</div>
							</div>

					        <center>
					        	<div class="row" style="width:100%; clear:both;">
									<a href="/leave-type-edit/{{ $l->id }}" class="btn-medi medi-yellow waves-effect admin"> <i class="fas fa-edit"></i> </a>
									<a href="/leave-form/{{$l->id}}" class="btn-req request waves-effect" style="margin-bottom:15px;"> REQUEST </a>
									<a href="leave-type-delete/{{ $l->id }}" class="btn-medi medi-red waves-effect admin"> <i class="fas fa-trash-alt"></i> </a>
								</div>
							</center>
							
						</div>
					</div>
				@endforeach
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="header" style="background-color:#f3f3f3;">
			                <h2>
			                    TIME OFF LIST
			                </h2>
			            </div>
						
						<div class="body table-responsive">
						<p style="font-style:italic;">* below contains a list of your leave</p>
					        <table class="table table-bordered">
					            <thead style="background-color:#f3f3f3;">
					                <tr>
					                    <th>#</th>
					                    <th>Start Date</th>
					                    <th>End Date</th>
										<th>Total days</th>
										<th>Status</th>
										<th>Action</th>
										<!-- <th>Action</th> -->
					                </tr>
					            </thead>
					            <tbody>
					            	<?php $n=1; ?>
					            	@if (count($leave_request) > 0)
						            	@foreach($leave_request as $key => $l) 
						                <tr>
						                    <th scope="row"><?php echo $n;?></th>
						                    <td><?php echo date('d F Y', strtotime($l->leave_dates->first()->requested_date)); ?></td>
											<td> <?php echo date('d F Y', strtotime($l->leave_dates->last()->requested_date)); ?></td>
											<td>{{ $l->leave_dates->count() }}</td>
											<td>{{ $l->status }}</td>
						                    <td>
												<a href="/leave-edit/{{ $l->id }}" class="btn-medi medi-yellow" style="margin-right:5px;"> <i class="fas fa-edit"></i> </a>
												<a href="/leave-cancel/{{ $l->id }}" class="btn-medi medi-red" style="margin-right:5px;"> Cancel </a>
												<a href="/leave-detail/{{ $l->id }}" class="btn-medi medi-blue" target="blank" style="margin-right:5px;"> View Detail </a>
											</td>
						                </tr>
						                <?php $n++;?>
						                @endforeach
						            @else 
						            	<tr>
						            		<td colspan="6" style="text-align:center;">No data available in table</td>
						            	</tr>
						            @endif
					            </tbody>
					        </table>
					    </div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="header" style="background-color:#f3f3f3;">
			                <h2>
			                    TIME OFF SUBSTITUTE LIST
			                </h2>
			            </div>
						
						<div class="body table-responsive">
							<p style="font-style:italic;">* below is a list of substitute leave requests that tagged you in</p>
					        <table class="table table-bordered">
					            <thead style="background-color:#f3f3f3;">
					                <tr>
					                    <th>#</th>
					                    <th>Start Date</th>
					                    <th>End Date</th>
										<th>status</th>
										<th>Action</th>
					                </tr>
					            </thead>
					            <tbody>
					            	<?php $n=1; ?>
					            	@if (count($substitute_leave) > 0)
						            	@foreach($substitute_leave as $l) 
						                <tr>
						                    <th scope="row"><?php echo $n;?></th>
						                    <td><?php echo date('d F Y', strtotime($l->leave_dates->first()->requested_date)); ?></a></td>
											<td><?php echo date('d F Y', strtotime($l->leave_dates->last()->requested_date)); ?></td>
											<td>{{ $l->status }}</td>
											<td>
												<a href="/leave-accept/{{ $l->id }}" class="btn-medi medi-green" style="margin-right:5px;"> Accept </a>
											    <a href="/leave-approve/{{ $l->id }}" class="btn-medi medi-green admin" style="margin-right:5px;"> Approve </a>
											    <a href="/leave-reject/{{ $l->id }}" class="btn-medi medi-red" style="margin-right:5px;"> Reject </a>
											    <a href="/leave-detail/{{ $l->id }}" class="btn-medi medi-blue" target="blank"> View Detail </a>
											</td>
						                </tr>
						                <?php $n++;?>
						                @endforeach
						            @else 
						            	<tr>
						            		<td colspan="5" style="text-align:center;">No data available in table</td>
						            	</tr>
						            @endif
					            </tbody>
					        </table>
					    </div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<input type="hidden" id="access" value="{{ Auth::user()->access_type }}">
</body>

<script type="text/javascript">
var access = document.getElementById("access").value;

$(document).ready(function(){
	if(access == "admin") {   
    	$(".admin").show();
    }
	else {
	    $(".admin").hide();
	}
});
</script>

@endsection