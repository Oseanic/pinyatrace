@extends('pages.establishment.layouts.main')

@section('css')
  <!-- Argon CSS -->
  <link rel="stylesheet" href="{{ asset('argon/css/argon.css') }}" type="text/css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
@endsection

@section('main')


<style>
  .modal-header
 {
     padding:9px 15px;
     border-bottom:1px solid #eee;
     background-color: #0480be;
 }
 .modal-header .close{margin-top:2px}
 .modal-header h3{margin:0;line-height:30px}

 div.ex1 {
  margin: auto;
  border: 1px solid red;
}

div.alert{
  text-align: center;
}

</style>

<div class="container-fluid p-4">

    
    <div class="row w-100 m-0">
      <div class="card w-100">
        <div class="card-header border-0">
          <div class="row align-items-center justify-content-between px-2">
          </div>

        

        @if(Session::has('error'))
        <div class="row">
            <div class="col-12">
                <div class="alert alert-danger">
                    {{ Session::get('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </div>
            </div>
        </div>
        @endif    
        <div class="d-flex justify-content-center">
          <h1 class="mb-4 text-primary"> <i class="cil-user mr-2"></i> Visitors -</h1><h1 class="mb-4 ml-2 text-black">{{ $dt }}</h1>
        </div>
        <div class="d-flex justify-content-center">
        <button type="button" class="btn btn-primary btn mb-3" data-toggle="modal" data-target="#presentModal"><i class="cil-calendar mr-2"></i> Present</button>
        <button type="button" class="btn btn-info btn mb-3" data-toggle="modal" data-target="#filterModal"><i class="cil-calendar mr-2"></i> Date Filter</button>
        <button type="button" class="ex1 btn btn-success mb-3" data-toggle="modal" data-target="#dateModal"><i class="cil-calendar mr-2"></i> Date Range</button>
        <a href="{{ route('visitors.searchnotallowed') }}" class="btn btn-danger btn mb-3" role="button"><i class="cil-warning mr-2"></i> Not allowed</a>
        <button type="button" class="btn btn-dark btn mb-3" data-toggle="modal" data-target="#roleModal"><i class="cil-user mr-2"></i> Role Filter</button>
        <a href="{{ route('visitors') }}" class="btn btn-light btn mb-3" role="button" aria-pressed="true"><i class="cil-description mr-2"></i> View all</a>
        <button type="button" class="btn btn-secondary btn mb-3" data-toggle="modal" data-target="#printModal"><i class="cil-print mr-2"></i> Print</button>
        </div>
        
        <div class="mt-3 d-flex justify-content-end">
            <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search..." title="Type in a name">
        </div>

        <div class="table-responsive">
          <table id="table" class="table align-items-center table-flush">
            <thead class="thead-light">
              
              <tr class="border" style="color: black">
                <th>Name</th>
                <th>Role</th>
                <th>ID Number</th>
                <th>Date</th>
                <th>Scan Time</th>
                <th>Reason for Visit</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="table">
              @forelse ($visitors as $visitor)
                <tr class="border"> 
                    <td>{{ $visitor->res_name }}</td>
                    <td>{{ $visitor->role }}</td>
                    <td>{{ $visitor->id_number }}</td>
                    <td>{{ Carbon\Carbon::parse($visitor->date)->format('M, d Y') }}</td>
                    <td class="{{ $visitor->in === 'Not allowed' ? 'text-danger' : 'text-black'}}">{{ $visitor->in }}</td>
                    @if($visitor->reason_visit != null)
                    <td>{{ $visitor->reason_visit }}</td>
                    @else
                    <td>N/A</td>
                    @endif
                    <td><button class="btn-sm btn-primary detail-btn" data-toggle="modal" data-target="#exampleModal" data-id="{{ $visitor->id }}">View</button>
                   
                  </td>
                </tr>
              @empty
                <tr>
                  <td class="text-center" colspan="8">No visitors on this date</td>
                </tr>
              @endforelse
            </tbody>
          </table> 
        </div>
      </div>
    </div>



<!-- Print Options Modal -->
<div class="modal fade" id="printModal" tabindex="-1" role="dialog" aria-labelledby="exampleprintModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-white" id="exampleModalLabel">Print</h5>
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
      <a href="{{ route('visitorsnotallowed.print') }}" class="btn btn-danger btn mb-3" role="button" target="_blank"><i class="cil-print"></i> Not allowed</a>
      <a href="{{ route('visitorsall.print') }}" class="btn btn-secondary btn mb-3" role="button" aria-pressed="true" target="_blank"><i class="cil-print"></i> Print All</a>
      </div>  


      </div>
    </div>
  </div>
</div>

<!-- Print Range Modal -->
<div class="modal fade" id="rangeModal" tabindex="-1" role="dialog" aria-labelledby="rangeModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-white" id="dateleModalLabel">Print Input Dates</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      
      <div class="modal-body">
            <form action="{{ route('visitorsrange.print') }}" medthod = "POST"  target="_blank">
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

<!-- Range Filter Modal -->
<div class="modal fade" id="dateModal" tabindex="-1" role="dialog" aria-labelledby="dateModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-white" id="dateleModalLabel">Input Dates</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      
      <div class="modal-body">
            <form action="{{ route('visitors.searchrange') }}" medthod = "POST">
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

<!-- Details Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title text-white" id="exampleModalLabel">Visitor Details</h3>
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



<!-- Week Filter Modal -->
<div class="modal fade" id="weekModal" tabindex="-1" role="dialog" aria-labelledby="weekModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-white" id="exampleModalLabel">Week Filter</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('visitors.week') }}">
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

<!-- Role Filter Modal -->
<div class="modal fade" id="roleModal" tabindex="-1" role="dialog" aria-labelledby="roleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-white" id="exampleModalLabel">Role Filter</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('visitors.searchrole') }}">
          <p>Input Role:</p>
              <select class="custom-select" id="role" name="role" required>
                <option selected disabled value="">Choose Role...</option>
                <option value="Visitor">Visitor</option>
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

<!-- Present Dates Modal -->
<div class="modal fade" id="presentModal" tabindex="-1" role="dialog" aria-labelledby="presentModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-white" id="exampleModalLabel">Present Date Filter</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <p>Choose Present Filter:</p>
              <div class="d-flex justify-content-center">
                <a href="{{ route('visitors.searchtoday') }}" class="btn btn-primary btn mb-3" role="button">{{ Carbon\Carbon::now()->format('M, d Y') }}</a>
                <a href="{{ route('visitors.searchbymonth') }}" class="btn btn-info btn mb-3" role="button">{{ Carbon\Carbon::now()->format('F, Y') }}</a>
                <a href="{{ route('visitors.searchbyweek') }}" class="btn btn-warning btn mb-3" role="button">{{ Carbon\Carbon::now()->startOfWeek()->format('M, d Y') }} - 
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
      <div class="modal-header">
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
      <div class="modal-header">
        <h5 class="modal-title text-white" id="exampleModalLabel">Day Filter</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form action="{{ route('visitors.search') }}" medthod = "POST">
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
<!-- Print Day Filter Modal -->
<div class="modal fade" id="printdayModal" tabindex="-1" role="dialog" aria-labelledby="printdayModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-white" id="exampleModalLabel">Print Day</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form action="{{ route('visitorsday.print') }}" medthod = "POST"  target="_blank">
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
      <div class="modal-header">
        <h5 class="modal-title text-white" id="exampleModalLabel">Print Week</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form action="{{ route('visitorsweek.print') }}" medthod = "POST"  target="_blank">
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
      <div class="modal-header">
        <h5 class="modal-title text-white" id="exampleModalLabel">Print Month</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('visitorsmonth.print') }}" medthod ="POST"  target="_blank">
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


<!-- Month Filter Modal -->
<div class="modal fade" id="monthModal" tabindex="-1" role="dialog" aria-labelledby="monthModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-white" id="exampleModalLabel">Month Filter</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('visitors.month') }}">
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
    <div class="row w-100 d-flex justify-content-center">
        {{ $visitors->links() }}
      </div>
  </div>
@endsection

@section('js')

<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

<script>
   $(document).ready(function() {
          $('.detail-btn').click(function() {
            const id = $(this).attr('data-id');
            $.ajax({
              url: 'detail/'+id,
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

              }
            })
          });
        });

        $(".alert").delay(4000).fadeOut(200, function() {
          $(this).alert('close');
        });
</script>

<script>
  function myFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("table");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
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