@extends('layouts.dashboard', ['title' => "time off form"])
@extends('layouts.app', ['title' => "time off"])

@section('content')

<body style="background-color:#FFFFFF;">
<div class="content">
    <div class="container-fluid">
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
        <!-- Vertical Layout -->
        <div class="row clearfix">
            @if ($message = Session::get('alert'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $message }}</strong>
                </div>
            @endif
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header" style="background-color:#f3f3f3;">
                        <h2 style="font-size:20px; font-weight:bold;">
                            Privacy Policy
                        </h2>
                    </div>

                    <div class="body">
                        @foreach($leave_types as $p)
                            <?php echo $p->policy_note ?>
                        @endforeach
                    </div>
                </div>
                <div class="card">
                    <div class="body">
                        <form action="/leave-create" method="POST">
                            @csrf
                            <label for="email_address" style="font-size:20px;">When will you be away?</label>
                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <div class="form-group" style="padding-top:20px;">
                                        <div class="form-line" id="bs_datepicker_container_timeoff_form" style="padding-bottom:20px;padding-left:10%;">
                                        </div>
                                        <div id="chosen_date_container" style="padding-left:10%;"></div>
                                        <input type="hidden" name="leave_dates" id="leave_dates">
                                        </div>
                                </div>
                            </div>

                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

                            <input type="hidden" name="leave_type_id" value="{{ $leave_types[0]->id}}">

                            <label style="font-size:20px;" >Who will cover you?</label>
                                <div class="row clearfix">
                                    <div class="col-sm-3">
                                        <div class="textarea-medi">
                                            <select class="form-control show-tick" name="substitute_user_id">
                                                <option value="">-- Please Choose One --</option>
                                                @foreach($employee as $e)
                                                <option value="{{$e->id}}">{{ $e->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            <label for="password" style="font-size:20px;">What will be you up to? Let your employer know</label>
                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="textarea-medi">
                                        <div class="form-group">
                                            <div class="form">
                                                <textarea rows="4" class="form-control no-resize" placeholder="Please type what you want..." name="leave_note"></textarea>
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
                                                <textarea rows="4" class="form-control no-resize" placeholder="Please type what you want..." name="work_note"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <br>
                            <center style="margin-bottom:5%;">
                                <button type="submit" class="btn-medi medi-green" value="submit" style="margin-right:2%;">Send</button>
                                <a type="submit" href="/leave-list" class="btn-medi medi-red" value="submit">Cancel</a>
                            </center>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>

@endsection