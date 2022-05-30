@extends('layouts.dashboard', ['title' => "edit time off"])
@extends('layouts.app', ['title' => "time off"])

@section('content')

<body style="background-color:#FFFFFF;">
    <div class="content">
        <div class="container-fluid"> 
            <!-- Vertical Layout -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="body">
                            @foreach($leaves as $l)
                            <form action="/leave-update" method="POST">
                                @csrf
                                <input type="hidden" name="id" required="required" value="{{ $l->id }}">
                                <label for="password" style="font-size:20px;">What will be you up to? Let your employer know</label>
                                <div class="row clearfix">
                                    <div class="col-sm-6">
                                        <div class="textarea-medi">
                                            <div class="form-group">
                                                <div class="form">
                                                    <textarea rows="4" class="form-control no-resize" placeholder="Please type what you want..." name="leave_note">{{ $l->leave_note }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <label for="password" style="font-size:20px;">Any urgent / pending task that should be aware of?</label>
                                <div class="row clearfix">
                                    <div class="col-sm-6">
                                        <div class="textarea-medi">
                                            <div class="form-group">
                                                <div class="form">
                                                    <textarea rows="4" class="form-control no-resize" placeholder="Please type what you want..." name="work_note" >{{ $l->work_note}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <button type="submit" class="btn-medi medi-green">SUBMIT</button>
                            </form>
                            @endforeach

                        	
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>


@endsection