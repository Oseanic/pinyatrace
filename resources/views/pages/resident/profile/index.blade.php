@extends('pages.resident.layouts.main')

@section('css')
  <!-- Argon CSS -->
  <link rel="stylesheet" href="{{ asset('argon/css/argon.css') }}" type="text/css">
@endsection

@section('main')

<style>
  .image-upload>input {
  display: none;
}
</style>
<div class="container-fluid mt-3">
  @component('components.alert')@endcomponent
  <div class="row">
    <div class="card shadow-none w-100 m-3">
      <div class="card-header mb-2">
        <div class="row align-items-center">
          <div class="col-8">
            <h3 class="mb-0">Profile <button type="button" class="btn btn-primary ml-2" data-toggle="modal" data-target="#exampleModal">Change Password</button></h3>
          </div>
          <div class="col-4 text-right">
          </div>
        </div>
      </div>
      <div class="row d-flex justify-content-center p-2 mb-2">
      </div>
      <div class="card-body pt-0">
        <form action="{{ route('profile.update', Auth::user()->id) }}" id="updateForm" method="POST">
          @method('PUT')
          @csrf
          <h6 class="heading-small text-muted mb-4 text-center">Personal information</h6>

          <div class="row d-flex justify-content-center">
              @if(session('danger'))
                <div class="alert alert-danger alert-dismissible fade show w-50" role="alert">
                    {{ session('danger') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>  
              @endif
          </div>
          
          <div class="form-row">
            <div class="col-md-4 mb-3">
              <label for="first_name">First name</label>
              <input type="text" class="form-control" id="first_name" name="first_name" value="{{ $resident->profile->first_name }}" required>
            </div>
            <div class="col-md-4 mb-3">
              <label for="middle_name">Middle name</label>
              <input type="text" class="form-control" id="middle_name" name="middle_name" value="{{ $resident->profile->middle_name }}"  required>
            </div>
            <div class="col-md-4 mb-3">
              <label for="surname">Last name</label> 
              <input type="text" class="form-control" id="surname" name="surname" value="{{ $resident->profile->surname }}" required>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-4 mb-3">
              <label for="dob">Date of birth</label>
              <input type="date" class="form-control" id="dob" name="dob" value="{{ $resident->profile->dob }}" onchange="ageCount()" required>
            </div>
            <div class="col-md-4 mb-3">
              <label for="age">Age</label>
              <input type="text" class="form-control" id="age" name="age" value="{{ $resident->profile->age }}" readonly required>
            </div>
            <div class="col-md-4 mb-3">
              <label for="sex">Sex</label>
              <select class="custom-select" id="sex" name="sex" required>
                <option value="Male" {{ $resident->profile->sex === 'Male' ? 'selected' : ''}}>Male</option>
                <option value="Female" {{ $resident->profile->sex === 'Female' ? 'selected' : ''}}>Female</option>
                <option value="LGBTQ+" {{ $resident->profile->sex === 'LGBTQ+' ? 'selected' : ''}}>LGBTQ+</option>
                <option value="Prefer not to say..." {{ $resident->profile->sex === 'Prefer not to say...' ? 'selected' : ''}}>Prefer not to say...</option>
              </select>
            </div>
          </div>

          <h6 class="heading-small text-muted mb-4 text-center">Role and ID Number</h6>
          <div class="form-row">
            <div class="col-md-6 mb-3">
              <label for="role">Role</label>
              <select class="custom-select" id="role" name="role" required>
                <option value="Visitor" {{ $resident->profile->role === 'Visitor' ? 'selected' : ''}}>Visitor</option>
                <option value="Student" {{ $resident->profile->role === 'Student' ? 'selected' : ''}}>Student</option>
                <option value="Professor" {{ $resident->profile->role === 'Professor' ? 'selected' : ''}}>Professor</option>
                <option value="Admin & Staff" {{ $resident->profile->role === 'Admin & Staff' ? 'selected' : ''}}>Admin & Staff</option>
              </select>
            </div>

            <div class="col-md-6 mb-3">
              <label for="id_number">ID Number</label>
              <input type="text" class="form-control" id="id_number" name="id_number" value="{{ $resident->profile->id_number }}" pattern="[0-9]{4}-[0-9]{5}-[A-Z]{2}-[0-9]{1}" title="Incorrect Format of ID Number" required>
            </div>
          </div>

          <h6 class="heading-small text-muted mb-4 text-center">Course and Section</h6>
          <div class="form-row d-flex justify-content-center">
            <div class="col-md-4 mb-3">
                <label for="role">Course (Acronym only)</label>
                <input type="text" class="form-control" id="course" name="course" value="{{ $resident->profile->course }}" required>
              </div>

              <div class="col-md-4 mb-3">
                <label for="role">Section</label>
                <input type="text" class="form-control" id="section" name="section" pattern="[1-4]{1}-[1-4]{1}" value="{{ $resident->profile->section }}" title="Incorrect Format of Section" required>
              </div>
          </div>

          <h6 class="heading-small text-muted mb-4 text-center">Contact information</h6>
          <div class="form-row">
            <div class="col-md-4 mb-3">
              <label for="address">House No. and Street</label>
              <input type="text" class="form-control" id="address" name="street" value="{{ $resident->profile->street }}"  required>
            </div>
            <div class="col-md-4 mb3">
              <label for="address">Barangay</label>
              <input type="text" class="form-control" id="address" name="barangay" value="{{ $resident->profile->barangay }}" required>
            </div>
            <div class="col-md-4 mb-3">
              <label for="address">Minicipality and Province</label>
              <input type="text" class="form-control" id="barangay" name="city" value="{{ $resident->profile->city }}"  required>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-3">
              <label for="cp_number">Cellphone number</label>
              <input type="text" pattern="[0-9]{11}" class="form-control" id="cp_number" name="cp_number" value="{{ $resident->profile->cp_number }}" minlength="11" maxlength="11"  required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="cp_number">Telephone number (optional)</label>
              <input type="text" class="form-control" id="cp_number" name="tel_number" value="{{ $resident->profile->tel_number }}">
            </div>
          </div>
          <h6 class="heading-small text-muted mb-4 text-center">Emergency Contact</h6>
          <div class="form-row">
            <div class="col-md-4 mb-3">
              <label for="emergency_contact">Name</label>
              <input type="text" class="form-control" id="emergency_contact" name="emergency_contact" value="{{ $resident->contact->emergency_contact }}"  required>
              <div class="valid-tooltip">
                Looks good!
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <label for="relationship">Relationship</label>
              <select class="custom-select" id="relationship" name="relationship" required>
                <option value="Wife" {{ $resident->contact->relationship === 'Wife' ? 'selected' : '' }} >Wife</option>
                <option value="Husband" {{ $resident->contact->relationship === 'Husband' ? 'selected' : '' }} >Husband</option>
                <option value="Child" {{ $resident->contact->relationship === 'Child' ? 'selected' : '' }}  >Child</option>
                <option value="Mother" {{ $resident->contact->relationship === 'Mother' ? 'selected' : '' }}  >Mother</option>
                <option value="Father" {{ $resident->contact->relationship === 'Father' ? 'selected' : '' }}  >Father</option>
                <option value="Relative" {{ $resident->contact->relationship === 'Relative' ? 'selected' : '' }}  >Relative</option>
                <option value="Neighbor" {{ $resident->contact->relationship === 'Neighbor' ? 'selected' : '' }}  >Neighbor</option>
              </select>
              <div class="invalid-tooltip">
                Please select a valid state.
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <label for="cp_number">Cellphone number</label>
              <input type="text" pattern="[0-9]{11}"  class="form-control" id="cp_number" name="ec_cp_number" value="{{ $resident->contact->ec_cp_number }}" minlength="11" maxlength="11"  required>
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

<!-- Modal -->
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
          <form action="{{ route('profilepass.update', Auth::user()->id) }}" method="POST">
          @method('PUT')
          @csrf
              <p>Username</p>
              <input type="text" class="form-control mb-3"  id="name" name="name" value="{{ Auth::user()->name }}" required>

              <p>Email</p>
              <input type="text" class="form-control mb-3"  id="email" name="email" value="{{ Auth::user()->email }}" required>

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

<script>
document.getElementById('role').onchange = function () {
  if(this.value == 'Visitor') {
      document.getElementById("id_number").value = "N/A";
      document.getElementById("course").value = "N/A";
      document.getElementById("section").value = "N/A";
      $("#id_number").attr('readonly', 'readonly');
      $("#course").attr('readonly', 'readonly');
      $("#section").attr('readonly', 'readonly');
    }

    if(this.value == 'Student') {
      document.getElementById("id_number").pattern = "[0-9]{4}-[0-9]{5}-[A-Z]{2}-[0-9]{1}";
      document.getElementById("section").pattern = "[1-4]{1}-[1-4]{1}";
      $("#id_number").removeAttr('readonly');
      $("#course").removeAttr('readonly');
      $("#section").removeAttr('readonly');
    }

    if(this.value == 'Professor') {
      document.getElementById("id_number").pattern = "[0-9]{5}";
      document.getElementById("course").value = "N/A";
      document.getElementById("section").value = "N/A";
      $("#id_number").removeAttr('readonly');

      $("#course").attr('readonly', 'readonly');
      $("#section").attr('readonly', 'readonly');
    }

    if(this.value == 'Admin & Staff') {
      document.getElementById("id_number").pattern = "[0-9]{5}";
      document.getElementById("course").value = "N/A";
      document.getElementById("section").value = "N/A";
      $("#id_number").removeAttr('readonly');

      $("#course").attr('readonly', 'readonly');
      $("#section").attr('readonly', 'readonly');
    }
}


$(function(){
  if ($('#role').val() == 'Visitor') {
    $("#id_number").attr('readonly', 'readonly');
    $("#course").attr('readonly', 'readonly');
    $("#section").attr('readonly', 'readonly');
    $('#id_number').prop('value', "N/A");
    $('#course').prop('value', "N/A");
    $('#section').prop('value', "N/A");
  } 
  
  if ($('#role').val() == 'Student') {
    $("#id_number").removeAttr('readonly');
    $("#course").removeAttr('readonly');
    $("#section").removeAttr('readonly');
    
    $('#id_number').prop('pattern', "[0-9]{4}-[0-9]{5}-[A-Z]{2}-[0-9]{1}");
    $('#section').prop('pattern', "[1-4]{1}-[1-4]{1}");
  } 

  if ($('#role').val() == 'Professor') {
    $("#id_number").removeAttr('readonly');
    $("#course").attr('readonly', 'readonly');
    $("#section").attr('readonly', 'readonly');

    $('#id_number').prop('pattern', "[0-9]{5}");
    $('#course').prop('value', "N/A");
    $('#section').prop('value', "N/A");
  } 

  if ($('#role').val() == 'Admin & Staff') {
    $("#id_number").removeAttr('readonly');
    $("#course").attr('readonly', 'readonly');
    $("#section").attr('readonly', 'readonly');

    $('#id_number').prop('pattern', "[0-9]{5}");
    $('#course').prop('value', "N/A");
    $('#section').prop('value', "N/A");
  } 
});
</script>

<script>
 function ageCount() {                             
      
    var dobget =document.getElementById('dob').value; 
    var dob= new Date(dobget);                                                 
      
    var age = Math.trunc((Date.now() - dob) / (31557600000));

      
    document.getElementById('age').value = age;
    }
</script>

<script>
$(".alert").delay(4000).fadeOut(200, function() {
          $(this).alert('close');
        });
</script>

  <!-- Core -->
  <script src="{{ asset('argon/vendor/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('argon/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('argon/vendor/js-cookie/js.cookie.js') }}"></script>
  <script src="{{ asset('argon/vendor/jquery.scrollbar/jquery.scrollbar.min.js') }}"></script>
  <script src="{{ asset('argon/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js') }}"></script>
   <!-- Argon JS -->
  <script src="{{ asset('argon/js/argon.js') }}"></script>
@endsection

