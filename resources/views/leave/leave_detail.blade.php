@extends('layouts.dashboard', ['title' => "time off detail"])
@extends('layouts.app', ['title' => "time off"])

@section('content')

<body style="background-color:#FFFFFF;">
    <div class="content">
        <div class="container-fluid">
            <div class="row clearfix">
            @if ($message = Session::get('alert'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $message }}</strong>
                </div>
            @endif
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="body">
                        <form>
                            @csrf
                            <div class="row" style="padding:0px;">
                            <div class="col-sm-6" style="padding:2.5%;">
                                <label for="email_address" style="font-size:18px;">Date of Leave</label>
                                <div class="row">
                                    <div class="form-group" style="margin:0px;">
                                    @foreach ($leave_detail->leave_dates as $l)
                                    <span class="label label-primary" style="margin-right:5px;margin-top:10px; margin-bottom:10px; padding: 5px 15px;border-radius:5px;background-color:#f3f3f3;color:#646262;box-shadow:1px 1px #e5e5e5;float:left;">
                                    {{ $l->requested_date}}
                                    </span>
                                    @endforeach
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

                                <div class="col-sm-6" style="padding:2.5%;">
                                <label style="font-size:18px;">Substitute Partner</label>
                                    <div class="row clearfix">
                                        <div class="textarea-medi" style="font-weight:bold;padding:10px;">
                                            {{ $leave_detail->substitute->name}}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row" style="padding:0px;">
                            <div class="col-sm-6" style="padding:0px 2.5%;">
                                <label for="password" style="font-size:18px;">Task will be you up to (Reason of leave)</label>
                                <div class="row clearfix">
                                    <div class="textarea-medi">
                                        <div class="form-group">
                                            <div class="form">
                                                <textarea rows="4" class="form-control no-resize" placeholder="Please type what you want..." readonly="true">{{ $leave_detail->leave_note}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6" style="padding:0px 2.5%;">
                                <label for="password" style="font-size:18px;">Work task should be aware of</label>
                                <div class="row clearfix">
                                    <div class="textarea-medi">
                                        <div class="form-group">
                                            <div class="form">
                                                <textarea rows="4" class="form-control no-resize" placeholder="Please type what you want..." name="work_note" readonly="true">{{ $leave_detail->work_note}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </form>

                        <ol class="progtrckr" data-progtrckr-steps="3">
                            @if ($leave_detail->status == "requested")
                                <li class="progtrckr-done">Requested</li>
                                <li class="progtrckr-todo">Accepted</li>
                                <li class="progtrckr-todo">Approved</li>
                            @elseif ($leave_detail->status == "cancelled")
                                <li class="progtrckr-reject">Requested</li>
                                <li class="progtrckr-todo">Accepted</li>
                                <li class="progtrckr-todo">Approved</li>
                            @elseif ($leave_detail->status == "accepted")
                                <li class="progtrckr-done">Requested</li>
                                <li class="progtrckr-done">Accepted</li>
                                <li class="progtrckr-todo">Approved</li>
                            @elseif ($leave_detail->status == "approved" && $leave_detail->accepted_by != null)
                                <li class="progtrckr-done">Requested</li>
                                <li class="progtrckr-done">Accepted</li>
                                <li class="progtrckr-done">Approved</li>
                            @elseif ($leave_detail->status == "approved" && $leave_detail->accepted_by == null)
                                <li class="progtrckr-done">Requested</li>
                                <li class="progtrckr-todo">Accepted</li>
                                <li class="progtrckr-done">Approved</li>
                            @elseif ($leave_detail->status == "rejected" && $leave_detail->accepted_by != null)
                                <li class="progtrckr-done">Requested</li>
                                <li class="progtrckr-done">Accepted</li>
                                <li class="progtrckr-reject">Approved</li>
                            @elseif ($leave_detail->status == "rejected" && $leave_detail->accepted_by == null)
                                <li class="progtrckr-done">Requested</li>
                                <li class="progtrckr-todo">Accepted</li>
                                <li class="progtrckr-reject">Approved</li>
                            @else
                                <li class="progtrckr-done">Requested</li>
                                <li class="progtrckr-reject">Accepted</li>
                                <li class="progtrckr-todo">Approved</li>
                            @endif
                            
                        </ol>
                    </div>
                </div>
            </div>
        </div>

    </div>
</body>

@endsection