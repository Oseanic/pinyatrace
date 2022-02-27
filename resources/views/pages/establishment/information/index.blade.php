@extends('pages.establishment.layouts.main')

@section('css')
  <!-- Argon CSS -->
  <link rel="stylesheet" href="{{ asset('argon/css/argon.css') }}" type="text/css">
@endsection

@section('main')
<div class="container-fluid mt-3">
  @component('components.alert')@endcomponent
  <div class="row">
    <div class="col-xl-4 order-xl-2">
      <div class="card card-profile">
        <div class="row d-flex justify-content-center pt-3">
          <a href="#">
            <img src="/img/Logo.png" class="rounded-circle" height="200" width="200">
          </a>
        </div>
        <div class="card-body pt-3">
          <div class="text-center mb-3">
            @if ($company === null)
              <h5 class="h3">
                {{ Auth::guard('establishment')->user()->name }}
              </h5>
              <div class="h5 font-weight-300">
                {{ Auth::guard('establishment')->user()->email }}
              </div>
            @else
              <h5 class="h3">
                {{ $company->information->company_name }}
              </h5>
              <div class="h5 font-weight-300">
                {{ $company->information->company_address }}
              </div>
             
              <div class="mt-3">
                <h5 class="h3">
                  {{ $company->information->cp_number.' '.'|'.' '.$company->information->tel_number }}
                </h5>
                <div class="h5 font-weight-300">
                {{ Auth::guard('establishment')->user()->email }}
                </div>
              </div>

              <div class="border"></div>
              <h5 class="h3 text-primary mt-3">
                  Representative
              </h5>

              <h5 class="h3">
              {{ $company->representative->name }}
              </h5>

              <div class="h5 font-weight-300">
              {{ $company->representative->number.' '.'|'.' '.$company->representative->email }}
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-8 order-xl-1">
      <div class="card w-100">
        <div class="card-header">
          <div class="row align-items-center">
            <div class="col-8">
              <h3 class="mb-0">Company Information <button type="button" class="btn btn-primary ml-2" data-toggle="modal" data-target="#exampleModal">Change Password</button></h3> 
            </div>
            <div class="col-4 text-right">
              
            </div>
          </div>
        </div>
        <div class="card-body">
          <form action="{{ route('information.update', Auth::user()->id) }}" id="updateForm" method="POST">
            @method('PUT')
            @csrf
            <div class="form-row">
              <div class="col-md-12 mb-3">
                <label for="company_name">Company name</label>
                <input type="text" class="form-control" id="company_name" name="company_name" value="{{ $company->information->company_name }}" required>
                <div class="valid-tooltip">
                  Looks good!
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-12 mb-3">
                <label for="company_address">Address</label>
                <input type="txt" class="form-control" id="company_address" name="company_address" value="{{ $company->information->company_address }}" required>
                <div class="invalid-tooltip">
                  Please provide a valid city.
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-6 mb-3">
                <label for="cp_number">Cellphone</label>
                <input type="txt" class="form-control" id="cp_number" name="cp_number" value="{{ $company->information->cp_number }}" required>
                <div class="invalid-tooltip">
                  Please provide a valid city.
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="tel_number">Telephone</label>
                <input type="txt" class="form-control" id="tel_number" name="tel_number" value="{{ $company->information->tel_number }}" required>
                <div class="invalid-tooltip">
                  Please provide a valid city.
                </div>
              </div>
            </div>
            <h6 class="heading-small text-muted mb-4 text-center">Representative</h6>
            <div class="form-row">
              <div class="col-md-6 mb-3">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $company->representative->name }}"  required>
                <div class="valid-tooltip">
                  Looks good!
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="position">Position</label>
                <input type="text" class="form-control" id="position" name="position" value="{{ $company->representative->position }}"  required>
                <div class="valid-tooltip">
                  Looks good!
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-12 mb-3">
                <label for="address">Address</label>
                <input type="text" class="form-control" id="address" name="address" value="{{ $company->representative->address }}"  required>
                <div class="valid-tooltip">
                  Looks good!
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-6 mb-3">
                <label for="email">Email</label>
                <input type="text" class="form-control" id="email" name="email" value="{{ $company->representative->email }}"  required>
                <div class="valid-tooltip">
                  Looks good!
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="number">Cellphone number</label>
                <input type="text" class="form-control" id="number" name="number" value="{{ $company->representative->number }}"  required>
                <div class="valid-tooltip">
                  Looks good!
                </div>
              </div>
            </div>
            <button class="btn btn-primary" type="submit" value="Submit Form">Update</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Update Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="exampleModalLabel">Change Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form action="{{ route('informationpass.update', Auth::user()->id) }}" method="POST">
            @method('PUT')
            @csrf
              <p>Username</p>
              <input type="text" class="form-control mb-3"  id="name" name="name" value="{{ Auth::guard('establishment')->user()->name }}" required>

              <p>Email</p>
              <input type="email" class="form-control mb-3"  id="email" name="email" value="{{ Auth::guard('establishment')->user()->email }}" required>

              <p>Password</p>
              <input type="password" class="form-control mb-3" id="password" name="password" autocomplete="off" required>
              <p>Confirm Password</p>
              <input type="password" class="form-control mb-3" id="confirm_password" autocomplete="off" required>

              <div class="d-flex justify-content-center">
                <input type="submit" class="btn btn-primary" value="Save">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
          </form>
      </div>
    </div>
  </div>
</div>

<script>
var password = document.getElementById("password")
  , confirm_password = document.getElementById("confirm_password");

function validatePassword(){
  if(password.value != confirm_password.value) {
    confirm_password.setCustomValidity("Passwords Don't Match");
  } else {
    confirm_password.setCustomValidity('');
  }
}

password.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;
</script>
@endsection

@section('js')
  <!-- Core -->
  <script src="{{ asset('argon/vendor/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('argon/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('argon/vendor/js-cookie/js.cookie.js') }}"></script>
  <script src="{{ asset('argon/vendor/jquery.scrollbar/jquery.scrollbar.min.js') }}"></script>
  <script src="{{ asset('argon/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js') }}"></script>
   <!-- Argon JS -->
  <script src="{{ asset('argon/js/argon.js') }}"></script>
@endsection

