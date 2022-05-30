@extends('layouts.dashboard', ['title' => "calendar"])
@extends('layouts.app', ['title' => "calendar"])

@section('content')

    
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="panel-body" >
                        {!! $calendar->calendar() !!}
                        {!! $calendar->script() !!}
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="panel-body" >
                        <div>
                            <center>
                                <h3>What's On September</h3>
                            </center>
                        </div>
                    </div>
                </div>


                @foreach($event as $a) 
                <div class="card">
                    <div class="panel-body" style="margin-bottom:-20px;">
                        <div>
                            <div class="row" style="padding:0% 5% 0% 5%;">
                                <div style="width:60%; float:left;">
                                    <strong>
                                        <p>
                                            <?= ($a->type == "birthday"
                                                ? '<span class="label label bg-pink" style="border-radius:5px;">'.$a->type.'</span>'
                                                    : ($a->type == "leave"
                                                    ?'<span class="label label-primary" style="border-radius:5px;">'.$a->type.'</span>'
                                                        :($a->leave_type_id == 3
                                                        ?'<span class="label label-primary" style="border-radius:5px;">'.$a->name.'</span>'
                                                            :($a->leave_type_id == 4
                                                            ?'<span class="label label-primary" style="border-radius:5px;">'.$a->name.'</span>'
                                                                    :'<span class="label label-primary" style="border-radius:5px;">'.$a->type.'</span>'
                                                            )
                                                        )
                                                    )
                                                )
                                                
                                            ?>
                                        </p>
                                    </strong>
                                </div>
                                <div style="width:40%;text-align:right; float:left;">
                                    <p>{{ $a->date }}</p>
                                </div>
                            </div>
                            <div class="row" style=" padding:0% 5% 0% 5%;"><p>{{ $a->note }}</p></div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>


@endsection