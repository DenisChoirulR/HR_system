@extends('layouts.dashboard', ['title' => "event list"])
@extends('layouts.app', ['title' => "event"])

@section('content')

<body style="background-color:#FFFFFF;">
    <div class="container-fluid">
    	@if(Session::has('message'))
	        <div class="alert alert-success alert-block">
				<button type="button" class="close" data-dismiss="alert">×</button>
				<p><strong>{{ Session::get('message') }}</strong></p>
			</div>
	    @endif
    	<div class="row">
			<a href="/event-add" class="btn-medi medi-green" style="margin:15px; float:left; margin-bottom:30px;"> Add Event </a>	
    	</div>
    	<div class="container-fluid">
    		<div class="row">	
				<div class="body table-responsive" style="clear:both;">
			        <table class="table table-bordered">
			            <thead style="background-color:#f3f3f3;">
			                <tr>
			                    <th>#</th>
			                    <th>Date</th>
								<th>Type</th>
								<th>Title</th>
								<th>Note</th>
								<th width="150px">Created By</th>
								<th width="200px">Action</th>
			                </tr>
			            </thead>
			            <tbody>
			            	<?php $n=1; ?>
			            	@if (count($events) > 0)
				            	@foreach($events as $l) 
				                <tr>
				                	<input type="hidden" id="created" value="{{ $l->created_by }}">
				                    <th scope="row"><?php echo $n;?></th>
				                    <td><?php echo date('d F Y', strtotime($l->date)); ?></td>
									<td>{{ $l->type }}</td>
									<td>{{ $l->title }}</td>
									<td>{{ $l->note }}</td>
									<td>{{ $l->users->name }}</td>
				                    <td><?php
				                    	$access = Auth::user()->id;
				                    	$created = $l->created_by;
				                    	if ($access == $created) {
				                    		echo 
				                    		'<a href="/event-edit/'.$l->id.'" class="btn-medi medi-yellow" style="margin-right:5px;"> <i class="fas fa-edit"></i> </a>
											<a href="/event-delete/'.$l->id.'" class="btn-medi medi-red"> <i class="fas fa-trash-alt"></i> </a>';
				                    	}
									?>
									</td>
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
			    </div>
			</div>
		</div>
	</div>
	<input type="hidden" id="access" value="{{ Auth::user()->id }}">
</body>


@endsection