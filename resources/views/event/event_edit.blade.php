@extends('layouts.dashboard', ['title' => "Event form"])
@extends('layouts.app', ['title' => "event"])

@section('content')

<body style="background-color:#FFFFFF;">
    <div class="content">
        <div class="container-fluid">
            <!-- Vertical Layout -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="body">
                            @foreach($events as $e)
                            <form action="/event-update" method="POST">
                                @csrf
                                <input type="hidden" name="id" required="required" value="{{ $e->id }}">
                                <label for="email_address">Date Of Event</label>
                                    <div class="form-group">
                                        <div class="form-line" id="bs_datepicker_container">
                                            <input type="text" class="form-control" name="date" placeholder="Please choose a date..." value="<?php echo date('d/m/Y', strtotime($e->date)); ?>">
                                        </div>
                                    </div>

                                <label for="password">Title of Event</label>
                                <div class="row clearfix">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" rows="4" class="form-control no-resize" placeholder="Please type what you want..." name="title" value="{{ $e->title }}"></input>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" name="type" value="others">

                                <label for="password">Note Of Event</label>
                                <div class="row clearfix">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <textarea rows="4" class="form-control no-resize" placeholder="Please type what you want..." name="note">{{ $e->note}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                                <br>
                                <button type="submit" class="btn-medi medi-green">SUBMIT</button>
                                <a href="/event" class="btn-medi medi-red" style="margin-left:5px;"> BATAL </a>

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