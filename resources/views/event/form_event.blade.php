@extends('layouts.dashboard', ['title' => "Event form"])
@extends('layouts.app', ['title' => "event"])

@section('content')

<body style="background-color:#FFFFFF;">
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
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="body">
                        <form action="/event-form" method="POST">
                            @csrf
                            <label for="email_address">Date Of Event</label>
                            <div class="form-group">
                                <div class="form-line" id="bs_datepicker_container">
                                    <input autocomplete="off" type="text" class="form-control" name="date" placeholder="Please choose a date...">
                                </div>
                            </div>
                            
                            <label for="password">Title of Event</label>
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" rows="4" class="form-control no-resize" placeholder="Please type what you want..." name="title"></input>
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
                                            <textarea rows="4" class="form-control no-resize" placeholder="Please type what you want..." name="note"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="created_by" value="{{ Auth::user()->id }}">

                            <br>
                            <button type="submit" class="btn-medi medi-green" value="submit">SUBMIT</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>


@endsection