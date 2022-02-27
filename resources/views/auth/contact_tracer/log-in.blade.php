@extends('layouts.app')

@section('app')
<div class="c-app w-100 flex-row align-items-center" >
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card-group">
          <div class="card p-4">
            <div class="card-body">
              <h1>PinyaTrace Login</h1>
              <p class="text-muted">Sign In to your tracer account</p>
              <form method="POST" action="{{ route('tracer.login') }}">
                  @csrf
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                        <i class="cil-user"></i>
                        </span>
                    </div>
                    <input class="form-control" type="text" placeholder="{{ __('E-Mail Address') }}" name="email" value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  </div>
                  <div class="input-group mb-4">
                  <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="cil-lock-locked"></i>
                      </span>
                  </div>
                  <input class="form-control" type="password" placeholder="{{ __('Password') }}" name="password" required>
                  @error('password')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
                  </div>
                  <div class="row">
                  <div class="col-6">
                      <button class="btn btn-warning px-4 text-light" type="submit">{{ __('Login') }}</button>
                  </div>
                  </form>
                  <div class="col-6 text-right">
                      <a href="{{ route('password.request') }}" class="btn btn-link px-0" type="button">{{ __('Forgot Your Password?') }}</a>
                  </div>
                  </div>
            </div>
          </div>
          <div class="card text-white bg-warning py-5 d-md-down-none" style="width:44%">
            <div class="card-body text-center">
              <div>
                <h2>Sign up</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                @if (Route::has('password.request'))
                    <a href="{{ route('tracer.showRegister') }}" class="btn btn-lg btn-outline-light mt-3" type="button">Register Now!</a>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection