
<!-- Put a symlink from /public/storage to /storage/app/public folder -->
<!-- php artisan storage:link -->

@extends('layouts.dashboard', ['title' => "attendance"])
@extends('layouts.app', ['title' => "attendance"])


@section('content')

{{-- menampilkan error validasi --}}
        @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif 

	<div class="container">
		<div class="row">
			@if(Session::has('message'))
		        <p >{{ Session::get('message') }}</p>
		     @endif
			<div class="col-md-5">
				<div class="panel panel-default">
				  <div class="panel-heading" style="font-weight:bold;">Input Data Masuk ( Upload CSV ) </div>
				  <div class="panel-body">
				  	<strong style="font-size:12px;">Upload file CSV *</strong>

				     <form method='post' action='/uploadFile' enctype='multipart/form-data' >
				       {{ csrf_field() }}

				       <input type='file' accept=".csv" name='file' class="white-badge">

				       <small  class="form-text text-muted">Please upload a valid file. Size of file should not be more than 2MB.</small> <br>

				       <input type='submit' name='submit' value='Import' class="btn-medi medi-green">
				     </form>
				  	</div>
				</div>

		     <!-- Form -->
		    </div>

		    <div class="col-md-6">
				<div class="panel panel-default">
				  <div class="panel-heading" style="font-weight:bold;"> Keterangan </div>
				  <div class="panel-body">
				  	<p>Kolom dengan tanda</p>
				  	<p>*) Wajib diisi</p>
				  	<br>
				  	<p>Setiap kali akan melaporkan via CSV silahkan download format CSV di bawah ini</p>
				  	<a href="{{ asset('uploads/example.csv') }}"> <i class="material-icons" style="font-size:14px;">file_download</i> <span>Klik disini</span></a> untuk download format CSV 
				  </div>
				</div>

		     <!-- Form -->
		    </div>

		</div>
	</div>
@endsection