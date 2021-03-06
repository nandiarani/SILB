@extends('layouts.auth')
@section('title')
    <title>SILBan Login</title>
@endsection
@section('contents')
<div class="col-md-8">
        <div class="card-group">
            <div class="card p-4">
                <div class="card-body">
                    <form method="POST" action="{{route('login')}}">
                        @csrf
                        <h1>Login</h1>
                        <p class="text-muted">Sign In to your account</p>
                        <div class="input-group mb-3">
                            <input id="email" class="form-control{{$errors->has('email') ? ' is-invalid' : ''}}"
                                type="text" name="email" value="{{old('email')}}" placeholder="Email/Username"
                                required autofocus>
                            @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{$errors->first('email')}}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="input-group mb-3" id="TogglePassword">
                            <input id="password"
                                class="form-control{{$errors->has('password') ? ' is-invalid' : ''}}"
                                type="password" name="password" placeholder="Password" required>
                            @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{$errors->first('password')}}</strong>
                            </span>
                            @endif
                            <div class="input-group-prepend">
                                <span class="input-group-text" >
                                    <img id="IconTogglePassword" src="{{asset('assets/icon/opened_eye.png')}}" width="18px" height="18px">
                                </span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <button class="btn btn-primary px-4" type="submit">Login</button>
                            </div>
                            <div class="col-6 text-right">
                                    @if (Route::has('password.request'))
                                    <a class="btn btn-link px-0" href="{{ route('password.request') }}">
                                        {{ __('Forgot Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card text-white bg-primary py-5 d-md-down-none" style="width:44%">
                <div class="card-body text-center">
                    <div>
                        <h2>Sign up</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                            incididunt ut labore et dolore magna aliqua.</p>
                        <a class="btn btn-primary active mt-3"
                            href="{{ route('register') }}">{{ __('Register') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    
<script type="text/javascript">
    $("#IconTogglePassword").click(function() {
        var x = document.getElementById("password");
        if (x.type === "password") {
        x.type = "text";
        $('#IconTogglePassword').attr("src","{{asset('assets/icon/closed_eye.png')}}");
        } else {
        x.type = "password";
        $('#IconTogglePassword').attr("src","{{asset('assets/icon/opened_eye.png')}}");
        }
    });
</script>
@endsection