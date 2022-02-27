@extends('layouts.app')

@section('app')

<style>

.invalid-feedback {
        display: block;
    }

main.c-app  {
  background-image: url("/img/background.jpeg");
  background-repeat: no-repeat;
  background-size: 100% 100%;
}    

</style>
<div class="container w-100 d-flex align-items-center min-vh-100 p-0">
  <div class="row justify-content-center w-100">
    <div class="col-md-6">
      <div class="card mx-4">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <h1>{{ __('PinyaTrace Register') }}</h1>
                <p class="text-muted">Create your resident account</p>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="cil-user"></i>
                    </span>
                    </div>
                    <input class="form-control" type="text" placeholder="{{ __('Name') }}" name="name" value="{{ old('name') }}" required autofocus>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                    <span class="input-group-text">@</span>
                    </div>
                    <input class="form-control" type="text" placeholder="{{ __('E-Mail Address') }}" name="email" value="{{ old('email') }}" required>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="cil-lock-locked"></i>
                    </span>
                    </div>
                    <input class="form-control" type="password" placeholder="{{ __('Password') }}" name="password" required>
                </div>
                <div class="input-group mb-4">
                    <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="cil-lock-locked"></i>
                    </span>
                    </div>
                    <input class="form-control" type="password" placeholder="{{ __('Confirm Password') }}" name="password_confirmation" required>
                </div>
                <button class="btn btn-block btn-primary" type="submit">{{ __('Register') }}</button>
            </form>
            <div class="card-footer">
                <a href="{{ route('resident.showLogin') }}" class="d-flex align-items-center"><i class="cil-arrow-left mr-1"></i> Back to log in</a>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection