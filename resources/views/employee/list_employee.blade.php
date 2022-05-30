@extends('layouts.dashboard', ['title' => "employee list"])
@extends('layouts.app', ['title' => "employee"])

@section('content')

<!-- Sweetalert Css -->
    <link href="{{ asset('plugins/sweetalert/sweetalert.css') }}" rel="stylesheet" />

<body style="background-color:#FFFFFF;">
    <div class="container-fluid">
    	@if(Session::has('message'))
	        <div class="alert alert-success alert-block">
				<button type="button" class="close" data-dismiss="alert">×</button>
				<p><strong>{{ Session::get('message') }}</strong></p>
			</div>
	    @endif
	    @if(Session::has('error_message'))
	        <div class="alert alert-danger alert-block">
				<button type="button" class="close" data-dismiss="alert">×</button>
				<p><strong>{{ Session::get('error_message') }}</strong></p>
			</div>
	    @endif
		<div class="header">
        </div>
		
		<div class="body table-responsive">
	        <table class="table table-bordered">
	            <thead style="background-color:#f3f3f3;">
	                <tr>
	                    <th>#</th>
	                    <th>User Id</th>
	                    <th>Nama</th>
						<th>Email</th>
						<th>Access Type</th>
						<th>View</th>
						<th>Activated</th>
						<!-- <th>Action</th> -->
	                </tr>
	            </thead>
	            <tbody>
	            	<?php $n=1; ?>
	            	@if (count($employee) > 0)
		            	@foreach($employee as $l) 
		                <tr>
		                    <th scope="row"><?php echo $n;?></th>
		                    <td>{{ $l->id }}</td>
		                    <td>{{ $l->name }}</td>
							<td>{{ $l->email }}</td>
							<td>@if ( $l->access_type != "admin") user @else {{$l->access_type}} @endif</td>
							<td>
								<a href="/detail-employee/{{ $l->id }}" target="blank" class="btn-medi medi-blue" style="margin-right:5px;"> Detail </a>
								<a href="/employee-edit/{{ $l->id }}" class="btn-medi medi-yellow"> <i class="fas fa-edit"></i></a>
								<a href="/employee-delete/{{ $l->id }}" class="btn-medi medi-red"> <i class="fas fa-trash-alt"></i></a>
							</td>
							<td>
								<div class="col-sm-12">
									<center>
										<div class="js-sweetalert">
		                                    <div class="switch">
		                                        <label><input type="checkbox" onclick="change(event)" name="{{ $l->id }}" class="check" <?php if ($l->active==1){echo "checked";} ?>>
		                                        	<span class="lever switch-col-light-green" data-type="success"></span>
		                                        </label>
		                                    </div>
	                                	</div>
	                            	</center>
	                            </div>
							</td>
		                    <!-- <td>
								<a href="/admin/leave-type/edit/{{ $l->id }}" class="btn btn-warning waves-effect"> Edit </a>
								<a href="/admin/leave-type/delete/{{ $l->id }}" class="btn btn-danger waves-effect"> Delete </a>
							</td> -->
		                </tr>
		                <?php $n++;?>
		                @endforeach
		            @else 
		            	<tr>
		            		<td colspan="8" style="text-align:center;">No data available in table</td>
		            	</tr>
		            @endif
	            </tbody>
	        </table>

	        <form name="test" method="post" type="hidden">
			  <input type="hidden" name="savereport" value="0" />
			</form>

			
			<div class="js-sweetalert">

			<button style="visibility: hidden;" id="active" class="btn btn-primary waves-effect" data-type="active">CLICK ME</button>
			<button style="visibility: hidden;" id="deactive" class="btn btn-primary waves-effect" data-type="deactive">CLICK ME</button>
			</div>
			

		</div>
	</div>
</body>
<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
function change(e) {
	//console.log(e.target)
  	var change = e.target;
  	
  
  	if (change.checked==false) {
	    document.test.elements["savereport"].value="0";
	    document.getElementById("deactive").click();
	    $.ajax({
	       	type:'POST',
	       	url:'/update-status',
	       	data:{
	       	active: 0,
	       	id: change.name
	    },
	       	success:function(data) {
	       		console.log(data);
	          //$("#msg").html(data.msg);
	       }
	    });
  	} 

  	else if (change.checked==true) {
    	document.test.elements["savereport"].value="1";
    	document.getElementById("active").click();
    	$.ajax({
	       	type:'POST',
	       	url:'/update-status',
	       	data:{
		       	active: 1,
		       	id: change.name
	    	},
	       	success:function(data) {
	       		console.log(data);
	          //$("#msg").html(data.msg);
	       }
	    });
  }
}
</script>


<!-- SweetAlert Plugin Js -->
    <script src="{{ asset('plugins/sweetalert/sweetalert.min.js') }}"></script>


    <script src="{{ asset('js/pages/ui/dialogs.js') }}"></script>

@endsection