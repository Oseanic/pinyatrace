@extends('pages.contact_tracer.layouts.main')

@section('css')
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('argon/vendor/nucleo/css/nucleo.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('argon/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}" type="text/css">
    <!-- Argon CSS -->
    <link rel="stylesheet" href="{{ asset('argon/css/argon.css?v=1.2.0') }}" type="text/css">
@endsection

@section('main')

<div class="container-fluid">
  <div class="row p-2">
      <div class="col-6 d-flex align-items-center" style="height: 4rem;">
        <h2 class="font-weight-bold" style="color: black">COVID - 19 Cases</h2>
      </div>
      <div class="col-6 d-flex justify-content-end align-items-center" style="height: 4rem;">
          <a class="btn btn-icon btn-success btn-sm text-white" type="button" data-toggle="modal" data-target="#createModal">
              <span class="btn-inner--icon"><i class="fas fa-plus"></i></span>
          </a>
      </div>
  </div>
    
  <div class="row p-2">
      <div class="container-fluid d-flex flex-column align-items-center " style="height: 70vh">
          <div class="card w-100">
              <div class="table-responsive w-100">
                <!-- Projects table -->
                <table class="table align-items-center table-flush">
                  <thead class="thead-light">
                    <tr>
                      <th scope="col">Patient ID</th>
                      <th scope="col">Name</th>
                      <th scope="col">Address</th>
                      <th scope="col">Email</th>
                      <th scope="col">Contact Number</th>
                      <th scope="col">Status</th>
                      <th scope="col">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                   @foreach ($cases as $case)
                      <tr>
                        <td>{{ $case->patient_id }}</td>
                        <td>{{ $case->name }}</td>
                        <td>{{ $case->address }}</td>
                        <td>{{ $case->email }}</td>
                        <td>{{ $case->number }}</td>
                        <td class="{{ $case->status === "Recovered" ? 'text-success' : 'text-danger' }}">{{ $case->status }}</td>
                        <td>
                          <button class="btn btn-icon btn-info btn-sm update" type="submit" data-toggle="modal" data-target="#updateModal"
                          data-id="{{ $case->id }}"
                          data-patient="{{ $case->patient_id }}"
                          data-name="{{ $case->name }}"
                          data-address="{{ $case->address }}"
                          data-email="{{ $case->email }}"
                          data-number="{{ $case->number }}"
                          data-status="{{ $case->status }}"
                          >
                              <span class="btn-inner--icon"><i class="fas fa-edit"></i></span>
                          </button>
                        </td>
                      </tr>
                   @endforeach
                  </tbody>
                </table>
                <div class="row w-100 d-flex justify-content-center">{{ $cases->links() }}</div>
              </div>
          </div>
          <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Covid Patient - Update</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form id="updateForm"  method="POST">
                    @method('PUT')
                    @csrf
                    <div class="form-row">
                      <div class="form-group col-md-4">
                        <label for="patient_id">Patient ID</label>
                        <input type="text" class="form-control" id="patient_id" name="patient_id">
                      </div>
                      <div class="form-group col-md-8">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="address">Barangay</label>
                      <select class="form-control" id="address" name="address">
                        @foreach ($barangays as $barangay)
                          <option>{{ $barangay->barangay }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-6">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email">
                      </div>
                      <div class="form-group col-md-6">
                        <label for="number">Contact number</label>
                        <input type="text" class="form-control" id="number" name="number">
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-12">
                        <label for="status">Status</label>
                        <select id="status" class="form-control" name="status">
                          <option id="selected" selected></option>
                          <option>Positive</option>
                          <option>Recovered</option>
                          <option>Died</option>
                          <option>Vaccinated</option>
                        </select>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary" value="Submit Form" onclick="document.getElementById('updateForm').submit()">Submit</button>
                </div>
              </div>
            </div>
          </div>
      </div>
  </div>
  <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Covid Patient</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ route('case.store') }}" method="POST" id="createForm">
            @csrf
            <div class="form-row">
              <div class="form-group col-md-4">
                <label for="patient_id">Patient ID</label>
                <input type="text" class="form-control" id="patient_id" name="patient_id">
              </div>
              <div class="form-group col-md-8">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name">
              </div>
            </div>
            <div class="form-group">
              <label for="address">Barangay</label>
              <select class="form-control" name="address" id="address">
                @foreach ($barangays as $barangay)
                  <option>{{ $barangay->barangay }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email">
              </div>
              <div class="form-group col-md-6">
                <label for="number">Contact number</label>
                <input type="text" class="form-control" id="number" name="number">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-12">
                <label for="status">Status</label>
                <select id="status" class="form-control" name="status">
                  <option value="Positive" selected>Positive</option>
                </select>
              </div>
            </div>
          </div>
        </form>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" value="Submit Form" onclick="document.getElementById('createForm').submit()">Submit</button>
        </div>
      </div>
    </div>
  </div>
</div> 
@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script type="application/javascript">
    $(document).ready(function () {
        $('.update').each(function() {
          $(this).click(function(event){
            console.log($(this).data("patient"));
            $('#updateForm').attr("action", "/tracer/cases/update/"+$(this).data("id")+"")
            $('#patient_id').val($(this).data("patient"));
            $('#name').val($(this).data("name"));
            $('#address').val($(this).data("address"));
            $('#number').val($(this).data("number"));
            $('#email').val($(this).data("email"));
            $('#selected').html($(this).data("status"));
          })
        })
    });
  </script>
    <!-- Argon Scripts -->
    <!-- Core -->
    <script src="{{ asset('argon/vendor/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('argon/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('argon/vendor/js-cookie/js.cookie.j') }}s"></script>
    <script src="{{ asset('argon/vendor/jquery.scrollbar/jquery.scrollbar.min.js') }}"></script>
    <script src="{{ asset('argon/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js') }}"></script>
    <!-- Argon JS -->
    <script src="{{ asset('argon/js/argon.js?v=1.2.0') }}"></script>
@endsection