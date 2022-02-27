@extends('pages.contact_tracer.layouts.main')

@section('css')
  <!-- Argon CSS -->
  <link rel="stylesheet" href="{{ asset('argon/css/argon.css') }}" type="text/css">
  <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
@endsection

@section('main')
<div class="container-fluid p-3">
    <div class="row ">
        <div class="col-6 d-flex align-items-center" style="height: 4rem;">
          <h2 class="font-weight-bold" style="color: black">Residents</h2>
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
                        <th scope="col">Name</th>
                        <th scope="col">Address</th>
                        <th scope="col">Email</th>
                        <th scope="col">Contact Number</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                     @foreach ($residents as $resident)
                        <tr>
                          <td>{{ $resident->profile->getFullname() }}</td>
                          <td>{{ $resident->profile->address() }}</td>
                          <td>{{ $resident->email }}</td>
                          <td>{{ $resident->profile->cp_number }}</td>
                          <td>
                            <a href="{{ route('travel.history', $resident->id) }}" class="btn btn-sm btn-primary">Travel History</a>
                          </td>
                        </tr>
                     @endforeach
                    </tbody>
                  </table>
                </div>
            </div>
        </div>
    </div>
</div>
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