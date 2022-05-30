<div class="theme-light-green">
	<!-- Page Loader -->
	<div class="page-loader-wrapper">
		<div class="loader">
			<div class="preloader">
				<div class="spinner-layer pl-light-green">
					<div class="circle-clipper left">
						<div class="circle"></div>
					</div>
					<div class="circle-clipper right">
						<div class="circle"></div>
					</div>
				</div>
			</div>
			<p>Please wait...</p>
		</div>
	</div>
	<!-- #END# Page Loader -->
	<!-- Overlay For Sidebars -->
	<div class="overlay"></div>
	<!-- #END# Overlay For Sidebars -->
	<!-- Search Bar -->
	<div class="search-bar">
		<div class="search-icon">
			<i class="material-icons">search</i>
		</div>
		<input type="text" placeholder="START TYPING...">
		<div class="close-search">
			<i class="material-icons">close</i>
		</div>
	</div>
	<!-- #END# Search Bar -->
	<!-- Top Bar -->
	<nav class="navbar" style="background: #fff;">
		<div class="container-fluid">
			<div class="navbar-header">
				<a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
				<a href="javascript:void(0);" class="bars" style="color: #54bc00;"></a>
				<!-- <a class="navbar-brand" href="{{ url('/') }}">
					<img style="margin-top:-8px;" src="{{ asset('images/logo.png') }}" height="35" />
				</a> -->
			</div>
			<div class="collapse navbar-collapse" id="navbar-collapse">
				<ul class="nav navbar-nav navbar-left">
					<li><a class="navbar-title">{{ isset($title) ? $title : "" }}</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
							<i class="material-icons" style="color: #555555;">notifications</i>
							<span class="label-count">
								@if (notification_count() != 0 )
									{{ notification_count() }} 
								@endif
							</span>
						</a>
						<ul class="dropdown-menu">
							<li class="header">NOTIFICATIONS</li>
							<li class="body">
								<ul class="menu">
									@foreach (notification() as $n)
									<li>
										<!-- <a onclick="read(event)" name="{{ $n->id }}" href="{{ $n->target_link }}"> -->
										<a onclick="readnotif({{ $n->id }},'{{ $n->target_link }}')">	
											<div class="menu-info">										
												<h4>{{ $n->message }}</h4>
												<p>
													<i class="material-icons">access_time</i>
													<?php
														$now = new DateTime();
														$created_at = new DateTime ($n->created_at);
														$diff = $now->diff($created_at);
														echo $diff->format("%d days %h hours %i minutes");
													?>
												</p>
											</div>
										</a>
									</li>
									@endforeach							
								</ul>
							</li>
							<!-- <li class="footer">
								<a href="javascript:void(0);">View All Notifications</a>
							</li> -->
						</ul>
					</li>
					<li class="dropdown">
						<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">

						<?= empty(Auth::user()->avatar) ? 
							('<span class="avatar-material-letter profile-pic-navbar-size" style="background-color:' . generate_rand_material_color() . '">' . ucwords((Auth::user()->name)[0]) . '</span>') 
							: 
							('<img class="rounded-avatar" title=" ' . Auth::user()->name . ' " style="border-radius: 50%; margin-top: -7px;width:38px;height:38px" width="38" height="38" alt="User" src="' . asset('storage/public/' . Auth::user()->avatar) . '" />') 
						?>

							<!-- <div class="email">{{ Auth::user()->email }}<span>
								<i class="fa fa-chevron-down" aria-hidden="true"></i></span></div> -->
						</a>
						<ul class="dropdown-menu">
							<li class="header">{{ Auth::user()->name }}</li>
							<!-- <li><a href="/profile"><i class="material-icons">person</i>Profile</a></li> -->
							<!-- <li role="separator" class="divider"></li> -->
							<li>
							   <!--  <a href="javascript:void(0);"><i class="material-icons">input</i>Sign Out</a> -->  
								<a class="dropdown-item" href="{{ route('logout') }}"
								   onclick="event.preventDefault();
												 document.getElementById('logout-form').submit();">
									<i class="material-icons">input</i> {{ __('Logout') }}
								</a>

								<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
									@csrf
								</form>
							</li>
						</ul>
					</li>
					<!-- #END# Notifications -->
				</ul>
			</div>
		</div>
	</nav>
	<!-- #Top Bar -->
	<section>
		<!-- Left Sidebar -->
		<aside id="leftsidebar" class="sidebar">
			<!-- Menu -->
			<div class="menu">
				<ul class="list">
					<li>
						<a href="{{ url('/') }}">
							<img style="margin: 5px; margin-top: 15px;" src="{{ asset('images/logo.png') }}" height="35" />
						</a>
					</li>
					<li>
						<a href="/dashboard">
							<i class="material-icons">dashboard</i>
							<span>Dashboard</span>
						</a>
					</li>
					<li>
						<a href="/leave-list">
							<i class="material-icons">flight_takeoff</i>
							<span>Time Off</span>
						</a>
					</li>
					<li>
						<a href="/list-employee" class="admin">
							<i class="material-icons">perm_identity</i>
							<span>Employee</span>
						</a>
					</li>
					<li>
						<a href="/attendance">
							<i class="material-icons">update</i>
							<span>Attendance</span>
						</a>
					</li>
					<li>
						<a href="/event">
							<i class="material-icons">view_module</i>
							<span>Event</span>
						</a>
					</li>
					<li>
						<a href="/announcement" class="admin">
							<i class="material-icons">assignment</i>
							<span>Announcement</span>
						</a>
					</li>		
					<li>
						<a href="/profile">
							<i class="material-icons">face</i>
							<span>Profile</span>
						</a>
					</li>					
				</ul>
			</div>
			<!-- #Menu -->
		</aside>
		<!-- #END# Left Sidebar -->
	</section>

	<input type="hidden" id="access" value="{{ Auth::user()->access_type }}">

	<section class="content">
		
		@yield('content')
  
	</section>
</div>

<script src="{{ asset('plugins/bootstrap/js/bootstrap.js') }}"></script>

<script type="text/javascript">
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function readnotif(e,f) {
	//console.log(e.target)
  	//var read = e.target;
  	//alert(e);
    $.ajax({
       	type:'POST',
       	url:'/update-notification-status',
       	data:{
       	id: e
    	},
       	success:function(data) {
       		console.log(data);
       		window.location=f;
       		// alert(data);
            //$("#msg").html(data.msg);
        }
    });
}
</script>

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

