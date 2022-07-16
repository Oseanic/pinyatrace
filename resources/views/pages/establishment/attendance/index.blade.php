@extends('pages.establishment.layouts.main')

@section('css')
  <!-- Argon CSS -->
  <link rel="stylesheet" href="{{ asset('argon/css/argon.css') }}" type="text/css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
@endsection

@section('main')


<div class="row w-100 m-0">
      <div class="card w-100">
        <div class="card-header border-0">
          <div class="row align-items-center justify-content-between px-2">
          </div>

        
        <div class="d-flex justify-content-center">
          <h1 class="mb-4 text-primary">Attendances - </h1><h1 class="mb-4 ml-2 text-black">{{ $dt }}</h1>
        </div>
        <div class="d-flex justify-content-center">
        <button type="button" class="btn btn-primary btn mb-3" data-toggle="modal" data-target="#presentModal">Present</button>
        <button type="button" class="btn btn-info btn mb-3" data-toggle="modal" data-target="#filterModal">Date Filter</button>
        <button type="button" class="ex1 btn btn-success mb-3" data-toggle="modal" data-target="#dateModal">Date Range</button>
        <a href="{{ route('attendance.searchnotallowed') }}" class="btn btn-danger btn mb-3" role="button">Not allowed</a>
        <button type="button" class="btn btn-dark btn mb-3" data-toggle="modal" data-target="#roleModal">Role Filter</button>
        <button type="button" class="btn btn-white btn-outline-primary btn mb-3" data-toggle="modal" data-target="#sectionModal">Section Filter</button>
        <a href="{{ route('attendance') }}" class="btn btn-light btn mb-3" role="button" aria-pressed="true">View all</a>
        <button type="button" class="btn btn-secondary btn mb-3" data-toggle="modal" data-target="#printModal"><i class="cil-print"></i> Print</button>
        </div>
        
        @if(Session::has('error'))
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                <div class="alert alert-danger">
                    {{ Session::get('error') }}
                </div>
            </div>
        </div>
        @endif    

        <div class="mt-3 d-flex justify-content-end">
                    <input type="text" id="myInput" placeholder="Search..." title="Type in a name" autocomplete="off">
        </div>

        <div class="table-responsive">
          <table id="table" class="table align-items-center table-flush">
            <thead class="thead-light">
              
              <tr class="border" style="color: black">
                <th>Name</th>
                <th>Role</th>
                <th>ID Number</th>
                <th>Section</th>
                <th>Date</th>
                <th>In</th>
                <th>Out</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="table">
            @forelse ($attendances as $attendance)
                <tr class="{{ $attendance->out === null ? 'bg-gradient-success text-white' : 'border'}}"> 
                    <td>{{ $attendance->res_name }}</td>
                    <td>{{ $attendance->role }}</td>
                    <td>{{ $attendance->id_number }}</td>
                    @if($attendance->section != "N/A N/A")
                    <td>{{  $attendance->section }}</td>
                    @else
                    <td>N/A</td>
                    @endif
                    <td>{{ Carbon\Carbon::parse($attendance->date)->format('M, d Y') }}</td>
                    <td class="{{ $attendance->in === 'Not allowed' ? 'text-danger' : 'text-black'}}">{{ $attendance->in }}</td>
                    <td class="{{ $attendance->out === 'Not allowed' ? 'text-danger' : 'text-black'}}">{{ $attendance->out === null ? 'Still inside' : $attendance->out }}</td>
                    <td><button class="btn-sm btn-primary detail-btn" data-toggle="modal" data-target="#exampleModal" data-id="{{ $attendance->id }}">View</button>
                        @if($attendance->out == null)
                        <a href="{{ route('attendance.kick', [$attendance->id]) }}" class="btn-sm btn-danger btn" role="button" aria-pressed="true">Scan Out</a>
                        @endif</td>
                </tr>
                @empty
                <tr>
                  <td class="text-center" colspan="8">No scans on this date</td>
                </tr>
            @endforelse   
            </tbody>
          </table> 
        </div>
      </div>
    </div>



<!-- Details Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h3 class="modal-title text-white" id="exampleModalLabel">Student Details</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
           <strong> <h2 class="text-primary d-flex justify-content-center">Full Name: </h2></strong><h1 class="d-flex justify-content-center" id="name"></h1>
      </div>
      
      <div class="border mt-3 mb-3"></div>
        <div class="row info">
          <div class="col d-flex justify-content-center">
            <h5>Email address:</h5>
          </div>
        </div>

        <div class="row">
          <div class="col d-flex justify-content-center">
              <p id="email"></p>
          </div>
      </div>
      
      <div class="border mb-3"></div>
        <div class="row info">
          <div class="col d-flex justify-content-center">
            <h5>Contact Number:</h5>
          </div>
          <div class="col d-flex justify-content-center">
            <h5>Tel Number:</h5>
          </div>
        </div>

        <div class="row">
          <div class="col d-flex justify-content-center">
              <p id="cp_number"></p>
          </div>
          <div class="col d-flex justify-content-center">
              <p id="tel_number"></p>
          </div>
        </div>
        <div class="border mt-3 mb-3"></div>
        <div class="row info">
          <div class="col d-flex justify-content-center">
            <h5>Address:</h5>
          </div>
        </div>

        <div class="row">
          <div class="col d-flex justify-content-center">
              <p id="address"></p>
          </div>
        </div>
        <div class="border mt-3 mb-3"></div>
        <div class="row info">
          <div class="col d-flex justify-content-center">
            <h5>Emergency Contact:</h5>
          </div>
          <div class="col d-flex justify-content-center">
            <h5>Emergency Contact Number:</h5>
          </div>
        </div>

        <div class="row">
          <div class="col d-flex justify-content-center">
              <p id="emergency_contact"></p>
          </div>
          <div class="col d-flex justify-content-center">
              <p id="ec_cp_number"></p>
          </div>
        </div>

      
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Present Dates Modal -->
<div class="modal fade" id="presentModal" tabindex="-1" role="dialog" aria-labelledby="presentModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="exampleModalLabel">Present Date Filter</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <p>Choose Present Filter:</p>

              <div class="d-flex justify-content-center">
                <a href="{{ route('attendance.searchtoday') }}" class="btn btn-primary btn mb-3" role="button">{{ Carbon\Carbon::now()->format('M, d Y') }}</a>
                <a href="{{ route('attendance.searchtodaymonth') }}" class="btn btn-info btn mb-3" role="button">{{ Carbon\Carbon::now()->format('F, Y') }}</a>
                <a href="{{ route('attendance.searchtodayweek') }}" class="btn btn-warning btn mb-3" role="button">{{ Carbon\Carbon::now()->startOfWeek()->format('M, d Y') }} - 
                {{ Carbon\Carbon::now()->endOfWeek()->format('M, d Y') }}</a>
              </div>
      </div>
    </div>
  </div>
</div>

<!-- Date Filter Modal -->
<div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="exampleModalLabel">Choose Filter:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <p>Choose Date Filter:</p>

              <div class="d-flex justify-content-center">
              <button type="button" class="btn btn-primary btn mb-3" data-dismiss="modal" data-toggle="modal" data-target="#dayModal">Day</button>
              <button type="button" class="btn btn-info btn mb-3" data-dismiss="modal" data-toggle="modal" data-target="#weekModal">Week</button>
              <button type="button" class="btn btn-warning btn mb-3" data-dismiss="modal" data-toggle="modal" data-target="#monthModal">Month</button>
              </div>
      </div>
    </div>
  </div>
</div>

<!-- Day Filter Modal -->
<div class="modal fade" id="dayModal" tabindex="-1" role="dialog" aria-labelledby="dayModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="exampleModalLabel">Day Filter</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form action="{{ route('attendance.searchday') }}" medthod = "POST">
              <p>Input Day:</p>
              <input type="date" class="form-control" id="date" name="date" required></div> 
              
              <div class="d-flex justify-content-center mb-3">
              <input type="submit" class="btn btn-primary" value="View">
              <button type="button" class="btn btn-secondary" data-dismiss="modal" data-toggle="modal" data-target="#filterModal">Close</button>
              </div>
            </form>
      </div>
    </div>
  </div>
</div>

<!-- Week Filter Modal -->
<div class="modal fade" id="weekModal" tabindex="-1" role="dialog" aria-labelledby="weekModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="exampleModalLabel">Week Filter</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('attendance.searchweek') }}">
          <p>Input Week:</p>
              <input type="week" class="form-control mb-3" id="week" name="week" required>

              <div class="d-flex justify-content-center">
              <input type="submit" class="btn btn-primary" value="View">
              <button type="button" class="btn btn-secondary" data-dismiss="modal" data-toggle="modal" data-target="#filterModal">Close</button>
              </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Month Filter Modal -->
<div class="modal fade" id="monthModal" tabindex="-1" role="dialog" aria-labelledby="monthModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="exampleModalLabel">Month Filter</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('attendance.searchmonth') }}">
          <p>Input Month:</p>
              <input type="month" class="form-control mb-3" id="month" name="month" required>

              <div class="d-flex justify-content-center">
              <input type="submit" class="btn btn-primary" value="View">
              <button type="button" class="btn btn-secondary" data-dismiss="modal" data-toggle="modal" data-target="#filterModal">Close</button>
              </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Range Filter Modal -->
<div class="modal fade" id="dateModal" tabindex="-1" role="dialog" aria-labelledby="dateModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="dateleModalLabel">Input Dates</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      
      <div class="modal-body">
            <form action="{{ route('attendance.searchrange') }}" medthod = "POST">
              <p>From:</p>
                <input type="date" class="form-control" id="date1" name="date1" required>
                <p class="mt-3">To:</p>
              <input type="date" class="form-control mb-3" id="date2" name="date2" required>

              <div class="d-flex justify-content-center">
                <input type="submit" class="btn btn-primary" value="View">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
            </form> 
      </div>
    </div>
  </div>
</div>

<!-- Role Filter Modal -->
<div class="modal fade" id="roleModal" tabindex="-1" role="dialog" aria-labelledby="roleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="exampleModalLabel">Role Filter</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('attendance.searchrole') }}">
          <p>Input Role:</p>
              <select class="custom-select" id="role" name="role" required>
                <option selected disabled value="">Choose Role...</option>
                <option value="Student">Student</option>
                <option value="Professor">Professor</option>
                <option value="Faculty & Staff">Admin & Staff</option>
              </select>
            <div class="d-flex justify-content-center">
              <input type="submit" class="btn btn-primary mt-2" value="View">
              <button type="button" class="btn btn-secondary mt-2" data-dismiss="modal">Close</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Print Options Modal -->
<div class="modal fade" id="printModal" tabindex="-1" role="dialog" aria-labelledby="exampleprintModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="exampleModalLabel">Print <i class="cil-print"></i></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <p>Choose Print Filter:</p>
      
      <div class="d-flex justify-content-center">
      <button type="button" class="btn btn-primary btn mb-3" data-dismiss="modal" data-toggle="modal" data-target="#printdayModal">Day</button>
      <button type="button" class="btn btn-info btn mb-3" data-dismiss="modal" data-toggle="modal" data-target="#printweekModal">Week</button>
      <button type="button" class="btn btn-warning btn mb-3" data-dismiss="modal" data-toggle="modal" data-target="#printmonthModal">Month</button>
      </div>
      
      <div class="border mt-3 mb-3"></div>
      <div class="d-flex justify-content-center">
      <button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#rangeModal" data-dismiss="modal">Date Range</button>
      <a href="{{ route('attendance.printnotallowed') }}" class="btn btn-danger btn mb-3" role="button" target="_blank">Not allowed</a>
      <a href="{{ route('attendance.printall') }}" class="btn btn-secondary btn mb-3" role="button" aria-pressed="true" target="_blank"><i class="cil-print"></i> Print All</a>
      </div>  

      <div class="border mt-3 mb-3"></div>
      <div class="d-flex justify-content-center">
      <button type="button" class="btn btn-white btn-outline-primary btn mb-3" data-dismiss="modal" data-toggle="modal" data-target="#printsectionModal">Section Filter</button>
      </div>
      
      </div>
    </div>
  </div>
</div>

<!-- Print Day Filter Modal -->
<div class="modal fade" id="printdayModal" tabindex="-1" role="dialog" aria-labelledby="printdayModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="exampleModalLabel">Print Day</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form action="{{ route('attendance.printday') }}" medthod = "POST"  target="_blank">
              <input type="date" class="form-control" id="date" name="date" required></div> 
              
              <div class="d-flex justify-content-center mb-3">
              <input type="submit" class="btn btn-primary" value="Print">
              <button type="button" class="btn btn-secondary" data-dismiss="modal" data-toggle="modal" data-target="#printModal">Close</button>
              </div>
            </form>
      </div>
    </div>
  </div>
</div>

<!-- Print Week Filter Modal -->
<div class="modal fade" id="printweekModal" tabindex="-1" role="dialog" aria-labelledby="printweekModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="exampleModalLabel">Print Week</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form action="{{ route('attendance.printweek') }}" medthod = "POST"  target="_blank">
              <input type="week" class="form-control" id="week" name="week" required></div> 
              
              <div class="d-flex justify-content-center mb-3">
              <input type="submit" class="btn btn-primary" value="Print">
              <button type="button" class="btn btn-secondary" data-dismiss="modal" data-toggle="modal" data-target="#printModal">Close</button>
              </div>
            </form>
      </div>
    </div>
  </div>
</div>

<!-- Print Month Modal -->
<div class="modal fade" id="printmonthModal" tabindex="-1" role="dialog" aria-labelledby="printmonthModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="exampleModalLabel">Print Month</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('attendance.printmonth') }}" medthod ="POST"  target="_blank">
          <p>Input Month:</p>
              <input type="month" class="form-control mb-3" id="month" name="month" required>

              <div class="d-flex justify-content-center">
              <input type="submit" class="btn btn-primary" value="Print">
              <button type="button" class="btn btn-secondary" data-dismiss="modal" data-toggle="modal" data-target="#printModal">Close</button>
              </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Print Range Modal -->
<div class="modal fade" id="rangeModal" tabindex="-1" role="dialog" aria-labelledby="rangeModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="dateleModalLabel">Print Input Dates</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      
      <div class="modal-body">
            <form action="{{ route('attendance.printrange') }}" medthod = "POST"  target="_blank">
              <p>From:</p>
                <input type="date" class="form-control" id="date1" name="date1" required>
                <p class="mt-3">To:</p>
              <input type="date" class="form-control mb-3" id="date2" name="date2" required>

              <div class="d-flex justify-content-center">
                <input type="submit" class="btn btn-primary" value="Print">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
            </form> 
      </div>
    </div>
  </div>
</div>

<!-- Print Section Filter Modal -->
<div class="modal fade" id="printsectionModal" tabindex="-1" role="dialog" aria-labelledby="sectionModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="exampleModalLabel">Section Filter</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form action="{{ route('attendance.printsection') }}" target="_blank" medthod = "POST">
              <p>Input Course (Acronym):</p>
              <input type="text" class="form-control" id="course" name="course" required>
              
              <p class="mt-2">Input Section:</p>
              <input type="text" class="form-control" id="section" name="section" pattern="[1-4]{1}-[1-4]{1}" required></div> 
              <div class="d-flex justify-content-center mb-3">
              <input type="submit" class="btn btn-primary" value="View">
              <button type="button" class="btn btn-secondary" data-dismiss="modal" data-toggle="modal">Close</button>
              </div>
            </form>
      </div>
    </div>
  </div>
</div>

<!-- Section Filter Modal -->
<div class="modal fade" id="sectionModal" tabindex="-1" role="dialog" aria-labelledby="sectionModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="exampleModalLabel">Section Filter</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form action="{{ route('attendance.searchsection') }}" medthod = "POST">
              <p>Input Course (Acronym):</p>
              <input type="text" class="form-control" id="course" name="course" required>
              
              <p class="mt-2">Input Section:</p>
              <input type="text" class="form-control" id="section" name="section" pattern="[1-4]{1}-[1-4]{1}" required></div> 
              <div class="d-flex justify-content-center mb-3">
              <input type="submit" class="btn btn-primary" value="View">
              <button type="button" class="btn btn-secondary" data-dismiss="modal" data-toggle="modal">Close</button>
              </div>
            </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js')

<script>
  $(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase(); 
    
    $("#table tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>

<script>
   $(document).ready(function() {
          $('.detail-btn').click(function() {
            const id = $(this).attr('data-id');
            $.ajax({
              url: 'detailA/'+id,
              type: 'GET',
              data: {
                "id": id
              },
              success:function(data) {
                console.log(data);
                $('#name').html(data.res_name)
                $('#cp_number').html(data.cp_number)
                $('#tel_number').html(data.tel_number)
                $('#emergency_contact').html(data.emergency_contact)
                $('#ec_cp_number').html(data.ec_cp_number)
                $('#address').html(data.address);
                $('#email').html(data.email);
                $('#section').html(data.section);
                $('#image').attr('src', data.image);
              }
            })
          });
        });

$(".alert").delay(4000).fadeOut(200, function() {
$(this).alert('close');
});
</script>


<script src="{{ asset('argon/vendor/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('argon/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('argon/vendor/js-cookie/js.cookie.js') }}"></script>
  <script src="{{ asset('argon/vendor/jquery.scrollbar/jquery.scrollbar.min.js') }}"></script>
  <script src="{{ asset('argon/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js') }}"></script>
   <!-- Argon JS -->
  <script src="{{ asset('argon/js/argon.js') }}"></script>
@endsection