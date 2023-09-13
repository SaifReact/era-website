@extends('layouts.admin.auth.auth')
@section('title')
    Forgot Password
@endsection
@section('content')
    <div class="row h-100">
        <div class="col-lg-5 col-12">
            <div id="auth-left">
                <div class="auth-logo">
                    <img src="{{ asset('images/admin/logo/logo.png') }}" alt="Logo">
                </div>
                <h1 class="auth-title">Reset Password</h1>
                <form method="post" action="{{route('password.update')}}">
                    {{ csrf_field() }}
                    <input type="hidden" name="token" value="{{ $token }}" />
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="email" name="email" class="form-control form-control-xl" placeholder="Email"  value="{{ $email }}" autocomplete="off" />
                        <div class="form-control-icon">
                            <i class="bi bi-envelope"></i>
                        </div>
                        @if($errors->has('email'))
                            <div class="form-control-feedback" style="color: red;">{{ $errors->first('email') }}</div>
                        @endif
                    </div>
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="password" name="password" class="form-control form-control-xl" placeholder="Password" autocomplete="off" />
                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                        @if($errors->has('password'))
                            <div class="form-control-feedback" style="color: red;">{{ $errors->first('password') }}</div>
                        @endif
                    </div>
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="password" name="password_confirmation" class="form-control form-control-xl" placeholder="Confirm Password" autocomplete="off" />
                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                        @if($errors->has('password_confirmation'))
                            <div class="form-control-feedback" style="color: red;">{{ $errors->first('password_confirmation') }}</div>
                        @endif
                    </div>

                    <button class="btn btn-primary btn-block btn-lg shadow-lg mt-1">Reset Password</button>
                </form>
                <div class="text-center mt-5 text-lg fs-4">
                    <p>Go to <a href="/admin#/auth/login" class="font-bold">Login</a>.</p>
                </div>
            </div>
        </div>
        <div class="col-lg-7 d-none d-lg-block">
            <div id="auth-right"></div>
        </div>
    </div>
@endsection
