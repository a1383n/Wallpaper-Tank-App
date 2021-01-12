@extends('front.layout')

@section('title','Login')

@section('content')
    <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="content-box">
                <h4 class="h4 text-center">Login</h4>
                <form role="form" action="{{route('login')}}" method="post">
                    @csrf

                    <div class="form-group">
                        <label for="login-form-username-input">Email</label>
                        <input type="text" name="email" id="login-form-username-input" class="form-control @error('email') is-invalid @enderror"
                               value="{{old('email')}}" required>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                       <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="login-form-password-input">Password</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                               required>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                       <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="login-form-remember-check"
                               name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="login-form-remember-check">Remember Me</label>
                    </div>
                    <div class="form-group">
                        <button type="submit" id="login-form-submit-btn"
                                class="btn btn-lg btn-primary btn-block text-uppercase mt-3">Login
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
