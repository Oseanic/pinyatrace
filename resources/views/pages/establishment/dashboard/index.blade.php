@extends('pages.establishment.layouts.main')

@section('css')
  <!-- Argon CSS -->
  <link rel="stylesheet" href="{{ asset('argon/css/argon.css') }}" type="text/css">
  <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
@endsection

@section('main')
<div class="container-fluid pt-3">
  @component('components.covid-updates', 
  ['recovered' => $recovered, 'mortality' => $mortality, 'total' => $total, 'visitortotal' => $visitortotal, 
  'visitornow' => $visitornow, 'visitorweek' => $visitorweek, 'visitormonth' =>$visitormonth, 'notallowed' => $notallowed  ])
  @endcomponent
  

  <div class="row">
    <div class="col d-flex justify-content-center">
       <div class="card" style="width: 28rem;">
       <div class="card-header border-0 d-flex justify-content-center">
         <strong>Qr Code</strong>
         
        </div>
          <div class="card-body">
              <div class="row d-flex justify-content-center p-3" id="qrContainer">
          <div id="carouselExampleIndicators" class="carousel">
            <div class="carousel-inner">
              <div class="carousel-item active">
                <div class="visible-print text-center mb-3" id="target">
                  {!! QrCode::size(200)->generate(route('in', Auth::guard('establishment')->user()->id)); !!}
                </div>
              </div>
          </div>
          <div class="row d-flex flex-column align-items-center">
            <strong>Scan Me to enter</strong>
            <p> <strong>Date: </strong>{{ Carbon\Carbon::now()->format('M, d Y') }}</p>
          </div>
        </div>
          </div>
        </div>               
    </div>
    <div class="col">
    <canvas id="myChart" style="width:100%;max-width:1000px"></canvas>
    </div>
  </div>
</div>


<script>
var xValues = ["This day", "This week", "This month", "Not Allowed", "Total"];
var yValues = [{!!json_encode($visitornow)!!}, {!!json_encode($visitorweek)!!}, {!!json_encode($visitormonth)!!}, {!!json_encode($notallowed)!!}, {!!json_encode($visitortotal)!!}];
var barColors = ["#5e72e4", "#11cdef","#fb6340","#f5365c","#2dce89"];

new Chart("myChart", {
  type: "bar",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    legend: {display: false},
    title: {
      display: true,
      text: "Visitors"
    },
    
    scales: {
      yAxes: [{
        ticks: {
          stepSize: 1,
          beginAtZero: true,
        },
      }],
    },
  }
});
</script>
  

@endsection

@section('js')
<script src="{{ asset('js/html5-qrcode.min.js') }}"></script>
<script type="application/javascript">
  $(document).ready(function () {
    $('.est').click(function(event){
      $('#name').html($(this).data("name"))
      $('#address').html($(this).data("address"))
      $('#date').html($(this).data("date"))
    })
  });
</script>
  <script>
    $(document).ready(function() {
      $('.carousel').carousel({
        interval: false,
      });
      $("#switch").click(function() {
        if ($(this).data("checked") == "True") {
          $(this).data("checked", 'False');
          $("#carouselExampleIndicators").carousel("next");
        } else if ($(this).data("checked") == 'False') {
          $(this).data("checked", 'True');
          $("#carouselExampleIndicators").carousel("prev");
        }
      });
    });

    var dt = new Date();
    document.getElementById("datetime").innerHTML = dt.toLocaleString();  
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
