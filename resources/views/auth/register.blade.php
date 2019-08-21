@extends('layouts.auth')

@section('title')
<title>SILBan Registration Page</title>
@endsection

@section('contents')
<div class="col-md-6">
        <div class="card mx-4">
            <div class="card-body p-4">
                <form method="POST" action="{{route('register')}}">
                    @csrf
                    <h1>Register</h1>
                    <p class="text-muted">Create your account</p>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="icon-user"></i>
                            </span>
                        </div>
                        <input id="name" class="form-control{{$errors->has('name') ? ' is-invalid' : '' }}" name="name" type="text" placeholder="Name" value="{{old('name')}}" required autofocus>
                        @if ($errors->has('name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{$errors->first('name')}}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="icon-user"></i>
                            </span>
                        </div>
                        <input id="username" type="text" name="username" class="form-control{{ $errors->has('username')? ' is-invalid': ''}}" value="{{old('username')}}" placeholder="Username" required autofocus>
                        
                        @if ($errors->has('username'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('username') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">@</span>
                        </div>
                        <input id="email" type="email" name="email" class="form-control{{ $errors->has('email')? ' is-invalid' : ''}}" placeholder="Email" value="{{old('email')}}" required>
                        
                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="icon-lock"></i>
                            </span>
                        </div>
                        <input id="password" type="password" name="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Password" required>
                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="icon-lock"></i>
                            </span>
                        </div>
                        <input id="password-confirm" type="password"name="password_confirmation" class="form-control" placeholder="Repeat password">
                    </div>
                    <button class="btn btn-block btn-success" type="submit">Create Account</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
      $('#password-confirm').on('keyup', function () {
          if ($('#password').val() == $('#password-confirm').val()){
              $('#password,#password-confirm').css('background-color', '#e6ffe6');
          } else 
              $('#password,#password-confirm').css('background-color', '#ffcccc');
      });
</script>
    
@endsection