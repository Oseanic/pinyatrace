@extends('pages.resident.layouts.main')

@section('css')
  <!-- Argon CSS -->
  <link rel="stylesheet" href="{{ asset('argon/css/argon.css') }}" type="text/css">
@endsection

@section('main')
<style>
div.card :hover {
  background-color: #5F9EA0;
}

div.card{
  margin: 5px;
}
</style>


<div class="row d-flex justify-content-center">  
    <div class="col ml-3">
     <a href="{{ route('scanner') }}"> <div class="card text-white bg-info">
        <div class="card-body">
          <div class="text-muted text-right mb-4">
            <i class="cil-location-pin" style="font-size: 3rem"></i>
          </div>
          <div class="text-value-lg">Recent visit</div><medium class="text-muted text-uppercase font-weight-bold">View</medium>
        </div>
      </div></a>
    </div>
  

    <div class="col">
      <a href="{{ route('travel') }}"><div class="card text-white bg-success">
        <div class="card-body">
          <div class="text-muted text-right mb-4">
            <i class="cil-walk" style="font-size: 3rem"></i>
          </div>
          <div class="text-value-lg">Scan History</div><medium class="text-muted text-uppercase font-weight-bold">View</medium>
        </div>
      </div></a>
    </div>

    <div class="col mr-3">
      <a href="{{ route('profile') }}"><div class="card text-white bg-warning">
        <div class="card-body">
          <div class="text-muted text-right mb-4">
            <i class="cil-user" style="font-size: 3rem"></i>
          </div>
          <div class="text-value-lg">Profile</div><medium class="text-muted text-uppercase font-weight-bold">View</medium>
        </div>
      </div></a>
    </div>
</div>
<div>


<div class="row">
    <div class="col">
      <div class="row d-flex justify-content-center pt-3">
      </div>
      <div class="card-body p-0 pb-4">
        <div class="d-flex flex-column justify-content-center align-items-center m-3">
          <div id="qr-reader" style="width:300px"></div>
        </div>
      </div>
    </div>
</div>
</div>



@endsection

@section('js')

<script src="{{ asset('js/html5-qrcode.min.js') }}"></script>
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

<script type="text/javascript">
     function docReady(fn) {
    // see if DOM is already available
    if (document.readyState === "complete"
        || document.readyState === "interactive") {
        // call on next available tick
        setTimeout(fn, 1);
    } else {
        document.addEventListener("DOMContentLoaded", fn);
    }
    }

    docReady(function () {
        var resultContainer = document.getElementById('qr-reader-results');
        var lastResult, countResults = 0;
        function onScanSuccess(decodedText, decodedResult) {
            if (decodedText !== lastResult) {
                ++countResults;
                lastResult = decodedText;
                // Handle on success condition with the decoded message.
                console.log(`Scan result ${decodedText}`, decodedResult);
                window.location.href = decodedText;
            }
        }

        var html5QrcodeScanner = new Html5QrcodeScanner(
            "qr-reader", { fps: 10, qrbox: 250, disableFlip: false,  aspectRatio: 1.1 });
        html5QrcodeScanner.render(onScanSuccess);
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