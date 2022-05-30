@extends('layouts.dashboard',['title' => "leave type form"])
@extends('layouts.app', ['title' => "leave type"])

@section('content')

<body style="background-color:#fFFFFF;">
<div class="content">
    <div class="container-fluid">
        <!-- Vertical Layout -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="body">
                        <form action="/leave-type-create" method="POST">
                            @csrf
                            <label for="email_address"> Code </label>
	                            <div class="form-group">
	                                <div class="form-line">    
	                                    <input type="text" id="code" class="form-control" placeholder="leave type code... " name="code" required="required">
                                    </div>
	                            </div>
                            
                            <label for="password">Name</label>
	                            <div class="form-group">
	                                <div class="form-line">
	                                    <input type="text" id="name" class="form-control" placeholder="leave type name..." name="name" required="required">
	                                </div>
	                            </div>
	                        <label for="password">Max Available</label>
	                        	<div class="form-group">
	                                <div class="form-line">
	                                    <input type="number" id="max_available" class="form-control" placeholder="Max Available for this Type" name="max_available" required="required">
	                                </div>
	                            </div>

                            <label for="password">Privacy Policy</label>
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea rows="4" class="form-control no-resize" name="policy_note" id="ckeditor"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <br>
                            <button type="submit" class="btn-medi medi-green">SUBMIT</button>
                            <a href="/leave-list" class="btn-medi medi-red" style="margin-left:5px;"> BATAL </a>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>

    <!-- Ckeditor -->
    <script src="{{ asset('plugins/ckeditor/ckeditor.js') }}"></script>

    <!-- Custom Js -->
    <script src="{{ asset('js/pages/forms/editors.js') }}"></script>

@endsection 