@extends('layouts.dashboard', ['title' => "detail employee"])
@extends('layouts.app', ['title' => "employee"])

@section('content')

<body style="background-color:#FFFFFF;">
    <div class="container-fluid">
        <div class="header">
        </div>
        
        <div class="row">
            <div class="col-md-8">
                <div class="body table-responsive">
                    <table class="table" style="color:#555555;">
                        	<tbody>
                            @foreach($detail_employee as $l) 
                            <tr>
                                <td width="10%"><i class="material-icons" style="margin-top:-3.5px; margin-bottom:0px;">perm_identity</i></td>
                                <td style="font-weight:bold;" width="40%;">Name</td>
                                <td>{{ $l->name }}</td>
                            </tr>
                            <tr>
                                <td><i class="material-icons" style="margin-top:-3.5px; margin-bottom:0px;">email</i></td>
                                <td style="font-weight:bold;">Email</td>
                                <td>{{ $l->email }}</td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-venus-mars material-icons"></i></td>
                                <td style="font-weight:bold;">Gender</td>
                                <td>{{ $l->gender }}</td>
                            </tr>
                            <tr>
                                <td><i class="material-icons" style="margin-top:-3.5px; margin-bottom:0px;">cake</i></td>
                                <td style="font-weight:bold;">Birthdate</td>
                                <td>{{ $l->birth_date }}</td>
                            </tr>
                            <tr>
                                <td><i class="material-icons">phone</i></td>
                                <td style="font-weight:bold;">Phone</td>
                                <td>{{ $l->phone }}</td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-universal-access material-icons"></i></td>
                                <td style="font-weight:bold;">Religion</td>
                                <td>{{ $l->religion }}</td>
                            </tr>
                            <tr>
                                <td><i class="material-icons" style="margin-top:-3.5px; margin-bottom:0px;">work</i></td>
                                <td style="font-weight:bold;">Job Title</td>
                                <td>{{ $l->job_title }}</td>
                            </tr>
                            <tr>
                                <td><i class="material-icons" style="margin-top:-3.5px; margin-bottom:0px;">access_time</i></td>
                                <td style="font-weight:bold;">Employee Type</td>
                                <td>{{ $l->employee_type }}</td>
                            </tr>
                            <tr>
                                <td><i class="material-icons" style="margin-top:-3.5px; margin-bottom:0px;">business</i></td>
                                <td style="font-weight:bold;">Placement Location</td>
                                <td>{{ $l->placement_location }}</td>
                            </tr>
                            <tr>
                                <td><i class="material-icons" style="margin-top:-3.5px; margin-bottom:0px;">date_range</i></td>
                                <td style="font-weight:bold;">Start Date</td>
                                <td>{{ $l->start_date }}</td>
                            </tr>
                            <tr>
                                <td><i class="material-icons" style="margin-top:-3.5px; margin-bottom:0px;">home</i></td>
                                <td style="font-weight:bold;">Address</td>
                                <td>{{ $l->address }}</td>
                            </tr>
                            <tr>
                                <td><i class="material-icons" style="margin-top:-3.5px; margin-bottom:0px;">favorite</i></td>
                                <td style="font-weight:bold;">Marital Status</td>
                                <td>{{ $l->marital_status }}</td>
                            </tr>
                            <tr>
                                <td><i class="material-icons" style="margin-top:-3.5px; margin-bottom:0px;">credit_card</i></td>
                                <td style="font-weight:bold;">Identity Card No</td>
                                <td>{{ $l->identity_card_no }}</td>
                            </tr>
                            <tr>
                                <td><i class="material-icons" style="margin-top:-3.5px; margin-bottom:0px;">accessibility</i></td>
                                <td style="font-weight:bold;">Access Type</td>
                                <td>@if ( $l->access_type != "admin") user @else {{$l->access_type}} @endif</td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-check material-icons"></i></td>
                                <td style="font-weight:bold;">Status</td>
                                <td><?=($l->active==1
                                    ? 'activated'
                                    : 'not activated' 
                                    )?></td>
                            </tr>
                                <!-- <td>
                                    <a href="/admin/leave-type/edit/{{ $l->id }}" class="btn btn-warning waves-effect"> Edit </a>
                                    <a href="/admin/leave-type/delete/{{ $l->id }}" class="btn btn-danger waves-effect"> Delete </a>
                                </td> -->
                            </tr>
                            
                            </tbody>
                    </table>
                </div>
            </div>

            <div class="col-md-4">
                <?= empty($l->avatar) ? 
                    ('<span class="pict-employee" style="background-color:' . generate_rand_material_color() . '">' . ucwords(($l->name)[0]) . '</span>') 
                    : 
                    ('<img class="rounded-pict-employee" title=" ' . $l->name . ' " alt="User" src="' . asset('storage/public/' . $l->avatar) . '" />') 
                ?>
            </div>
            @endforeach
        </div>
    </div>
</body>




@endsection