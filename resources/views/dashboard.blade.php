@extends('layouts.dashboard', ['title' => "dashboard"])
@extends('layouts.app', ['title' => "dashboard"])
 
@section('content')
<body style="background-color: #fff;">
<div class="content">
	<div class="container-fluid">
		<div class="header" style="margin-bottom:20px">
			<h2>{{ greeting(Auth::user()->name) }}</h2>
			<p style="color:#555">Here's what's going on with your team in Medicalogy...</p>
		</div>

		<div class="row clearfix">
			<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
				<div class="card">
                    <div class="panel-body" >
                        {!! $calendar->calendar() !!}
                        {!! $calendar->script() !!}
                    </div>
                </div>
            </div>
			<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
				<div class="card">
					<div class="card-header">
						What's going on?
					</div>
					<hr style="margin:0px 20px 0px 20px;">
					<div class="body" style="height:510px;overflow:auto">
						@foreach($events as $key=>$e) 
							<?php 
								if ($key == 0) {
									echo '<div style="margin-bottom:5px;font-weight:bold"><i class="material-icons event-icon-size" style="color:#777;bottom:-4px;position:relative;margin:0px 5px">event</i>' . date("l, d F Y", strtotime($e->date)) . '</div>';
								} else {
									if ($e->date != $events[$key-1]->date) {
										echo '<div style="border-top:1px solid #eee;padding-top:15px;margin-top:15px;margin-bottom:5px;font-weight:bold"><i class="material-icons event-icon-size" style="color:#777;bottom:-4px;position:relative;margin:0px 5px">event</i>' . date("l, d F Y", strtotime($e->date)) . '</div>';
									}
								}
								echo $e->type == 'leave' ? (
										'<div style="padding-left:10px;margin-bottom:5px">- <i class="material-icons event-icon-size" style="color:#5cb85c;bottom:-6px;position:relative;margin:0px 5px">flight_takeoff</i>' . 
										(empty($e->users->avatar) ? ('<span class="avatar-material-letter" style="background-color:' . generate_rand_material_color() . '">' . ucwords(($e->users->name)[0]) . '</span>') : ('<img class="rounded-avatar" width="100px" title=" ' . $e->users->name . ' " src="' . asset('storage/public/' . $e->users->avatar) . '" />')) . 
										explode(" ", $e->users->name)[0] . "'s " . $e->title . ' - ' . $e->note . '('.$e->substitute->name.')</div>'
									)
									: (
										$e->type == 'birthday' ? ('<div style="padding-left:10px;margin-bottom:5px">- <i class="material-icons event-icon-size" style="color:#d9534f;bottom:-6px;position:relative;margin:0px 5px">cake</i>' . 
											(empty($e->users->avatar) ? ('<span class="avatar-material-letter" style="background-color:' . generate_rand_material_color() . '">' . ucwords(($e->users->name)[0]) . ' </span>') : ('<img class="rounded-avatar" width="100px" title=" ' . $e->users->name . ' " src="' . asset('storage/public/' . $e->users->avatar) . '" />')) .
											explode(" ", $e->users->name)[0] . "'s " . $e->title . ' - ' . $e->note . '</div>'
									)
									: (
										'<div style="padding-left:10px;margin-bottom:5px">- <i class="material-icons event-icon-size" style="color:#5bc0de;bottom:-6px;position:relative;margin:0px 5px">event_note</i>' . $e->title . " " . $e->users->name . ' - ' . $e->note . '</div>'
									)
								);
							?>
						@endforeach
					</div>
				</div>
			</div>
			<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
				<div class="card" style="height:398px;overflow:auto">
					<div class="card-header">
						Announcement
					</div>
					<hr style="margin:0px 20px 0px 20px;">
					@foreach ($announcement as $a)
						<div class="body">

							<p style="font-weight:bold;"><i class="fa fa-bullhorn" aria-hidden="true" style="margin-right:10px; color:#e7a511;"></i>{{ $a->title }} -  <?php echo date("d F Y , h:i:s", strtotime($a->created_at)) ?> </p>
							<p style="margin-left:25px;">{{ $a->note}}</p>
							<h6></h6>
						</div>
					@endforeach
				</div>
			</div>
			<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
				<div class="card">
					<div class="card-header">
						Attendance Summary
					</div>
					<hr style="margin:0px 20px 0px 20px;">
					<div class="body" style="height: 135px; padding: 15px;">
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="padding: 8px;">
							<div class="card">
								<div class="card-subheader">best streak</div>
								<hr style="margin:0px 0px 0px 0px; border: 1px solid green;">
								<p style="font-size: 38px; text-align: center;">{{ $best_streak }}</p>							
							</div>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="padding: 8px;">
							<div class="card">
								<div class="card-subheader">on time</div>
								<hr style="margin:0px 0px 0px 0px; border: 1px solid blue;">
								<p style="font-size: 38px; text-align: center;">{{ $on_time }}</p>							
							</div>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="padding: 8px;">
							<div class="card">
								<div class="card-subheader">late</div>
								<hr style="margin:0px 0px 0px 0px; border: 1px solid red;">
								<p style="font-size: 38px; text-align: center;">{{ $late }}</p>							
							</div>
						</div>
					</div>
				</div>
				<div class="card">
					<div class="card-header">
						Time Off Summary
					</div>
					<hr style="margin:0px 20px 0px 20px;">
					<div class="body" style="height: 135px; padding: 15px;">
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="padding: 8px;">
							<div class="card">
								<div class="card-subheader">balance</div>
								<hr style="margin:0px 0px 0px 0px; border: 1px solid green;">
								<p style="font-size: 42px; text-align: center;">{{ $quota-$used }}</p>
							</div>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="padding: 8px;">
							<div class="card">
								<div class="card-subheader">quota</div>
								<hr style="margin:0px 0px 0px 0px; border: 1px solid blue;">
								<p style="font-size: 42px; text-align: center;">{{ $quota }}</p>
							</div>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="padding: 8px;">
							<div class="card">
								<div class="card-subheader">used</div>
								<hr style="margin:0px 0px 0px 0px; border: 1px solid red;">
								<p style="font-size: 42px; text-align: center;">{{ $used }}</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
