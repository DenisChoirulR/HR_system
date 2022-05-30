@extends('layouts.blank')
@extends('layouts.app')

@section('content')

<div style="background-color:#FFFFFF;overflow-x:hidden;">

    <div class="row">
        <div class="col-md-6" style="padding-right:0%;padding-bottom:0%;">
            <img src="images/b.png" width="100%;">
        </div>


        <div class="col-md-6" style="background-color:#FFFFFF;">
            <div class="login-page">
                <div class="login-box" style="padding-top:35%;">
                    
                        <div class="logo" style="padding-top:25px; color:#53bc00;">
                            <center><h1>Log In</h1></center>
                        </div>
                        <div class="body">
                            <form id="sign_in" method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons" style="margin-bottom:100%;">person</i>
                                    </span>
                                        <input id="email" type="email" name="email" class="form_login color-input @error('email') is-invalid @enderror" placeholder="Email Address" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons" style="margin-bottom:100%;">lock</i>
                                    </span>
                                        <input id="password" type="password" name="password" class="form_login color-input @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="current-password">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                </div>
                                <div class="input-group">
                                    <div class="col-xs-12">
                                        <button class="btn btn-lg btn-block waves-effect" style="background-color:#53bc00; color:#FFFFFF;border-radius:10px;" type="submit">SIGN IN</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6 col-md-6 col-lg-6 p-t-5">
                                        @if (Route::has('register'))
                                        <a href="{{ route('register') }}" style="color:#7b7b7b; font-size:12px;">Don't have an account?</a>
                                        @endif
                                    </div>
                                    <div class="col-xs-6 col-md-6 col-lg-6 p-t-5 align-right">
                                            @if (Route::has('password.request'))
                                            <a href="{{ route('password.request') }}" style="color:#7b7b7b; font-size:12px;">Forgot Password?</a>
                                            @endif
                                    </div>
                                </div>
                            </form>
                        </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection