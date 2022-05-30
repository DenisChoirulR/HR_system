@extends('layouts.dashboard', ['title' => "attendance"])
@extends('layouts.app', ['title' => "attendance"])

@section('content')
<body style="background-color:#FFFFFF;">
	<div class="container-fluid">
		<div class="row">
			@if (count($errors) > 0)
		        <div class="alert alert-danger">
		            <ul>
		                @foreach ($errors->all() as $error)
		                    <li>{{ $error }}</li>
		                @endforeach
		            </ul>
		        </div>
	        @endif
	        @if(Session::has('message'))
		        <div class="alert-medi alert-success alert-block">
					<button type="button" class="close" data-dismiss="alert">×</button>
					<p><strong>{{ Session::get('message') }}</strong></p>
				</div>
		    @endif
		    @if(Session::has('added'))
				<div class="alert alert-success alert-block">
					<button type="button" class="close" data-dismiss="alert">×</button>
					<p style="font-weight:bold; font-size:18px;"> Congratulations</p>
					<p>Your data has been uploaded successfully. (<strong>{{ Session::get('added') }} - {{ Session::get('updated') }} - {{ Session::get('failed') }}</strong>)</p>
			
				</div>
			@endif
			<a href="/attendance-import" class="btn-medi medi-green admin" style="margin:15px; margin-left:3%; float:left;"> Import Attendance </a>
    	</div>
		<div class="row clearfix">
			<form action="/attendance" method="GET">
				<div class="col-sm-3">
					<div class="select-medi">
						<select class="form-control show-tick" name="month">
							<option value="">- - All Months - -</option>
							<option value="1" <?php if($month == 1){echo 'selected';}?> >January</option>
							<option value="2" <?php if($month == 2){echo 'selected';}?>>February</option>
							<option value="3" <?php if($month == 3){echo 'selected';}?>>March</option>
							<option value="4" <?php if($month == 4){echo 'selected';}?>>April</option>
							<option value="5" <?php if($month == 5){echo 'selected';}?>>May</option>
							<option value="6" <?php if($month == 6){echo 'selected';}?>>June</option>
							<option value="7" <?php if($month == 7){echo 'selected';}?>>July</option>
							<option value="8" <?php if($month == 8){echo 'selected';}?>>August</option>
							<option value="9" <?php if($month == 9){echo 'selected';}?>>September</option>
							<option value="10" <?php if($month == 10){echo 'selected';}?>>October</option>
							<option value="11" <?php if($month == 11){echo 'selected';}?>>November</option>
							<option value="12" <?php if($month == 12){echo 'selected';}?>>December</option>
						</select>
					</div>
				</div>
				<div class="col-sm-2">
					<div class="select-medi">
						<select class="form-control show-tick" name="year">
							<option value="">- - All Years - -</option>
							@foreach($year_select as $key => $y)
							<?php 
							if ($key == 0) {
								echo
								'<option value="'.date('Y', strtotime($y->date)).'"';
								if(date('Y', strtotime($y->date)) == $year){echo 'selected';}
								echo '>'.date('Y', strtotime($y->date)).'</option>';
							} else {
							if (date('Y', strtotime($y->date)) != date('Y', strtotime($year_select[$key-1]->date))) {
							echo
								'<option value="'.date('Y', strtotime($y->date)).'"';
								if(date('Y', strtotime($y->date)) == $year){echo 'selected';}
								echo '>'.date('Y', strtotime($y->date)).'</option>';}} ?>
							@endforeach
							<!-- <option value="2019">2019</option> -->
						</select>
					</div>
				</div>
				<div class="col-sm-2" style="padding:0px;">
					<button type="submit" class="btn-medi medi-green" style="margin-top:5px;margin-left:3%;" value="submit">SUBMIT</button>
				</div>
			</form>
		</div>
		<div class="row">
		    <div class="container-fluid">			
				<div class="body table-responsive">
			        <table class="table table-bordered">
			            <thead style="background-color:#f3f3f3;">
			                <tr>
			                    <th>#</th>
			                    <th>Date</th>
								<th>User Id</th>
								<th>Check In</th>
								<th>Check Out</th>
								<th>Status</th>
								<!-- <th>Action</th> -->
			                </tr>
			            </thead>
			            <tbody>
			            	<?php $n=1; ?>
			            	@if (count($attendance) > 0)
				            	@foreach($attendance as $l) 
				                <tr>
				                    <th scope="row"><?php echo $n;?></th>
				                    <td><?php echo date('d F Y', strtotime($l->date)); ?></td>
									<td>{{ $l->users->name }}</td> 
									<td>{{ $l->check_in }}</td>
									<td>{{ $l->check_out }}</td>
				                    <td>
				                    	<?php
				                    		$check_in=strtotime($l->check_in);
				                    		if ($check_in > strtotime('8:00')){
				                    			echo '<span style="color:red;">LATE</span>';
				                    		}
				                    		else {
				                    			echo '<span style="color:#54bc00;">OK</span>';
				                    		}

				                    	?>

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