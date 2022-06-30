@extends('pages.resident.layouts.main')

@section('css')
  <!-- Argon CSS -->
  <link rel="stylesheet" href="{{ asset('argon/css/argon.css') }}" type="text/css">
@endsection

@section('main')


<div class="container-fluid mt-3">
  <div class="row d-flex justify-content-center">
    @if (session('message'))
      <div class="alert alert-success alert-dismissible fade show w-50" role="alert">
        {{ session('message') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    @elseif(session('danger'))
      <div class="alert alert-danger alert-dismissible fade show w-50" role="alert">
          {{ session('danger') }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>  
    @endif
  </div>
  <div class="row">
    <div class="card shadow-none w-100 m-3">
      <div class="row d-flex justify-content-center p-2">
       
      </div>
      <div class="card-body pt-0">
        <form action="{{ route('profile.store') }}" method="POST">
          @csrf
          <h6 class="heading-small text-muted mb-4 text-center">Personal information</h6>
          <div class="form-row">
            <div class="col-md-4 mb-3">
              <label for="first_name">First name</label>
              <input type="text" class="form-control" id="first_name" name="first_name" required>
              <div class="valid-tooltip">
                Looks good!
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <label for="middle_name">Middle name</label>
              <input type="text" class="form-control" id="middle_name" name="middle_name"  required>
              <div class="valid-tooltip">
                Looks good!
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <label for="surname">Last name</label>
              <input type="text" class="form-control" id="surname" name="surname" required>
              <div class="valid-tooltip">
                Looks good!
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-4 mb-3">
              <label for="dob">Date of birth</label>
              <input type="date" class="form-control" id="dob" name="dob" onchange="ageCount()" required>
              <div class="invalid-tooltip">
                Please provide a valid city.
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <label for="age">Age</label>
              <input type="text" class="form-control" id="age" name="age" readonly required>
              <div class="invalid-tooltip">
                Please provide a valid zip.
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <label for="sex">Sex</label>
              <select class="custom-select" id="sex" name="sex" required>
                <option selected disabled value="">Choose...</option>
                <option>Male</option>
                <option>Female</option>
                <option>LGBTQ+</option>
                <option>Prefer not to say...</option>
              </select>
              <div class="invalid-tooltip">
                Please select a valid state.
              </div>
            </div>
          </div>

          <h6 class="heading-small text-muted mb-4 text-center">Role and ID Number</h6>
          <div class="form-row">
            <div class="col-md-6 mb-3">
              <label for="role">Role</label>
              <select class="custom-select" id="role" name="role" required>
              <option selected disabled value="">Choose...</option>
                <option>Visitor</option>
                <option>Student</option>
                <option>Professor</option>
                <option>Admin & Staff</option>
              </select>
              <div class="invalid-tooltip">
                Please select a valid role.
              </div>
            </div>

            <div class="col-md-6 mb-3">
              <label for="id_number">ID Number</label>
              <input type="text" class="form-control" id="id_number" name="id_number" pattern="[0-9]{4}-[0-9]{5}-[A-Z]{2}-[0-9]{1}" title="Incorrect Format of ID Number" readonly>
            </div>
          </div>

          <h6 class="heading-small text-muted mb-4 text-center">Course and Section</h6>
          <div class="form-row d-flex justify-content-center">
            <div class="col-md-4 mb-3">
                <label for="role">Course (Acronym only)</label>
                <input type="text" class="form-control" id="course" name="course" pattern="[A-Z]{4}" title="Incorrect Format of Course" readonly>
              </div>

              <div class="col-md-4 mb-3">
                <label for="role">Section</label>
                <input type="text" class="form-control" id="section" name="section" pattern="[1-4]{1}-[1-4]{1}" title="Incorrect Format of Section" readonly>
              </div>
          </div>

          <h6 class="heading-small text-muted mb-4 text-center">Contact information</h6>
          <div class="form-row">
            <div class="col-md-4 mb-3">
              <label for="address">House No. and Street</label>
              <input type="text" class="form-control" id="address" name="street" required>
            </div>
            <div class="col-md-4 mb3">
              <label for="address">Barangay</label>
              <input type="text" class="form-control" id="address" name="barangay" required>
            </div>
            <div class="col-md-4 mb-3">
              <label for="address">Minicipality and Province</label>
              <input type="text" class="form-control" id="barangay" name="city"  required>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-3">
              <label for="cp_number">Cellphone number (number only)</label>
              <input type="text" pattern="[0-9]{11}" class="form-control" id="cp_number" name="cp_number"  maxlength="11" minlength="11" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="cp_number">Telephone number (optional)</label>
              <input type="text" class="form-control" id="cp_number" name="tel_number">
            </div>
          </div>
          <h6 class="heading-small text-muted mb-4 text-center">Emergency Contact</h6>
          <div class="form-row">
            <div class="col-md-4 mb-3">
              <label for="emergency_contact">Name</label>
              <input type="text" class="form-control" id="emergency_contact" name="emergency_contact"  required>
              <div class="valid-tooltip">
                Looks good!
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <label for="relationship">Relationship</label>
              <select class="custom-select" id="relationship" name="relationship" required>
                <option selected disabled value="">Choose...</option>
                <option>Wife</option>
                <option>Husband</option>
                <option>Child</option>
                <option>Mother</option>
                <option>Father</option>
                <option>Relative</option>
                <option>Neighbor</option>
              </select>
              <div class="invalid-tooltip">
                Please select a valid state.
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <label for="cp_number">Cellphone number (number only)</label>
              <input type="text" pattern="[0-9]{11}" class="form-control" id="cp_number" name="ec_cp_number" maxlength="11" minlength="11" required>
              <div class="valid-tooltip">
                Looks good!
              </div>
            </div>
          </div>
          <button class="btn btn-primary" type="submit" value="Submit Form">Submit form</button>
        </form>
      </div>
    </div>
  </div>
</div>

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
      document.getElementById("course").pattern = "[A-Z]{4}";
      document.getElementById("section").pattern = "[1-4]{1}-[1-4]{1}";
      $("#id_number").removeAttr('readonly');
      $("#course").removeAttr('readonly');
      $("#section").removeAttr('readonly');
    }

    if(this.value == 'Professor') {
      document.getElementById("id_number").pattern = "[0-9]{5}";
      $("#id_number").removeAttr('readonly');

      $("#course").attr('readonly', 'readonly');
      $("#section").attr('readonly', 'readonly');
    }

    if(this.value == 'Admin & Staff') {
      document.getElementById("id_number").pattern = "[0-9]{5}";
      $("#id_number").removeAttr('readonly');

      $("#course").attr('readonly', 'readonly');
      $("#section").attr('readonly', 'readonly');
    }

}

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

