@extends('layouts.dashboard', ['title' => "announcement list"])
@extends('layouts.app', ['title' => "Announcement"])

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
            <a href="/announcement-add" class="btn-medi medi-green" style="margin:15px; float:left; margin-bottom:30px;"> Add Announcement </a>
        </div>
		<div class="container-fluid">
    		<div class="row">
				<div class="body table-responsive" style="clear:both;">
			        <table class="table table-bordered">
			            <thead style="background-color:#f3f3f3;">
			                <tr>
			                    <th>#</th>
			                    <th width="150px">Name</th>
								<th>Title</th>
								<th>Note</th>
								<th>Expired at</th>
								<th width="200px">Action</th>
			                </tr>
			            </thead>
			            <tbody>
			            	<?php $n=1; ?>
			            	@if (count($announcements) > 0)
				            	@foreach($announcements as $l) 
				                <tr>
				                    <th scope="row"><?php echo $n;?></th>
									<td>{{ $l->users->name }}</td>
									<td>{{ $l->title }}</td>
									<td>{{ $l->note }}</td>
									<td><?php echo date('d F Y', strtotime($l->expired_at)); ?></td>
				                    <td><?php
				                    	$access = Auth::user()->id;
				                    	$created = $l->user_id;
				                    	if ($access == $created) {
				                    		echo 
										'<a href="/announcement-edit/'.$l->id.'" class="btn-medi medi-yellow" style="margin-right:5px;"> <i class="fas fa-edit"></i> </a>
										<a href="/announcement-delete/'.$l->id.'" class="btn-medi medi-red"> <i class="fas fa-trash-alt"></i> </a>';
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
</body>


@endsection