@extends('layouts.blank')
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center" style="margin-top: 20px;">
        <div class="col-md-2">
            <!-- // -->
        </div>
        <div class="col-md-8">

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <div class="panel panel-default">
              <div class="panel-heading" style="font-weight:bold; font-size:16px;"> Reset Password </div>
              <div class="panel-body">
                <strong style="font-size:14px;">E-mail Address</strong>

                <form method="POST" action="{{ route('password.email') }}">
                   {{ csrf_field() }}

                   <input id="email" style="border-radius:10px;" type="email" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 white-badge @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    

                   <input type='submit' name='submit' value='Send Password Reset Link' style="font-size:12px;"class="btn-medi medi-green">
                 </form>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
