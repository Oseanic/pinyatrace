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
              <p class="text-muted">Sign In to your establishment account</p>
              <form method="POST" action="{{ route('establishment.login') }}">
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
                      <button class="btn btn-success px-4" type="submit">{{ __('Login') }}</button>
                  </div>
                  </form>
                  </div>
            </div>
          </div>
          
        </div>
      </div>
    </div>
  </div>
</div>
@endsection