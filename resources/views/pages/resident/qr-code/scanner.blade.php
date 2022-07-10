@extends('pages.resident.layouts.main')

@section('css')
  <!-- Argon CSS -->
  <link rel="stylesheet" href="{{ asset('argon/css/argon.css') }}" type="text/css">
  <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
@endsection

@section('main')

<style>
  #reason_visit
{
    height:60px;
    font-size:14pt;
    width: 400px;
}
</style>
<div class="container w-75 mt-3">
  @component('components.alert')@endcomponent
  <div class="row">
    <div class="card w-100">
      <div class="card-body">
        <div class="row">
          <div class="col-xl-12 order-xl-1">
            <p>Your Information</p>
            <h3>{{ Auth::user()->profile->getFullname() }}</h3>
            <h5>{{ Auth::user()->profile->address() }}</h5>
            <h5>{{ Auth::user()->profile->sex.' '.'-'.' '.Auth::user()->profile->age }}</h5>
            <hr>
          </div>
          <div class="col-xl-12 order-xl-2">
            @if (!empty($establishment->information->company_name))
              <p>You're entering</p>
              <h3>{{ $establishment->information->company_name }}</h3>
              <h5>{{ $establishment->information->company_address }}</h5>
              <p class="mt-3">Date and Time</p>
              <h5>{{ $dateTime }}</h5>
              <p class="mt-3">Kindly answer the health declaration form</p>
              <button class="btn btn-sm btn-success est" data-toggle="modal" data-target="#healthDec"
              data-id="{{ $establishment->id }}"
              data-name="{{ $establishment->information->company_name }}"
              data-address="{{ $establishment->information->company_address }}"
              data-date="{{ $dateTime }}"
              >Health Declaration</button>
            @else
              @if (!empty($latest))
                <p>Recent scan history</p>
                <h3>{{ $latest->establishment_name }}</h3>
                <h5>{{ $latest->establishment_address }}</h5>
                <p style="font-size: .8rem">{{ $latest->updated_at->diffForHumans() }}</p>
              @else
                <p>No recent scan</p>
              @endif
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
  @if(session('health'))
    <script type="text/javascript">
      $(document).ready(function() {
        $('#healthForm').modal();
      });
    </script>
    <div class="modal fade" id="healthForm" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Health Declaration form</h5>
            <div class="d-flex justify-content-center"><strong class="text-danger">*If you answered ‘yes’ to any of the questions below, you are not allowed to enter the establishment</strong></div>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="{{ route('health.store', $establishment->id) }}" method="POST" id="healthDec">
              @csrf
              <p class="mb-0">You're Entering</p>
              <strong id="name">{{ $establishment->information->company_name }}</strong><br>
              <small id="address">{{ $establishment->information->company_address }}</small><br>
              <small id="date">{{ $dateTime }}</small>
              <hr>
              <div class="form-group row">
                <label for="temp" class="col-sm-2 col-form-label">Temperature</label>
                <div class="col-sm-10">
                  <input type="number" step="0.01" pattern="\d*" class="form-control" id="temp" name="temp" required>
                </div>
              </div>
              <h3>The following questions must be answered with “yes” or “no”</h3><br>
              <h3>No to all <input id="selectAll" type="checkbox"><label for='selectAll'></h3>
              <div class="form-row">
                <p>1.) Do you (or the person for whom you are completing this form) currently have symptoms of, or have
                  you been diagnosed with, pneumonia or coronavirus disease (COVID-19)?</p>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" id="q1Yes" name="q1" class="custom-control-input" value="Yes" required>
                  <label class="custom-control-label" for="q1Yes">Yes</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" id="q1No" name="q1" class="custom-control-input" value="No">
                  <label class="custom-control-label" for="q1No">No</label>
                </div>
              </div>
              <hr>
              <div class="form-row">
                <p>2.) In the past 10 days, have you (or the person for whom you are completing this form) been in contact with
                  someone who is or could be infected with coronavirus?</p>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" id="q2Yes" name="q2" class="custom-control-input" value="Yes" required>
                  <label class="custom-control-label" for="q2Yes">Yes</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" id="q2No" name="q2" class="custom-control-input" value="No">
                  <label class="custom-control-label" for="q2No">No</label>
                </div>
              </div>
              <hr>
              <div class="form-row d-flex flex-column">
                <p>3.) In the past 24 hours, have you (or the person for whom you are completing this form) had any of the following symptoms:</p>
                <div class="form-row">
                  <div class="col-7">
                    <p>Fever</p>
                  </div>
                  <div class="col-5">
                    <div class="custom-control custom-radio custom-control-inline">
                      <input type="radio" id="feverYes" name="fever" class="custom-control-input" value="Yes" required>
                      <label class="custom-control-label" for="feverYes">Yes</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                      <input type="radio" id="feverNo" name="fever" class="custom-control-input" value="No">
                      <label class="custom-control-label" for="feverNo">No</label>
                    </div>
                  </div>
                </div>
                <div class="form-row">
                  <div class="col-7">
                    <p>Cough</p>
                  </div>
                  <div class="col-5">
                    <div class="custom-control custom-radio custom-control-inline">
                      <input type="radio" id="coughYes" name="cough" class="custom-control-input" value="Yes" required>
                      <label class="custom-control-label" for="coughYes">Yes</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                      <input type="radio" id="coughNo" name="cough" class="custom-control-input" value="No">
                      <label class="custom-control-label" for="coughNo">No</label>
                    </div>
                  </div>
                </div> <div class="form-row">
                  <div class="col-7">
                    <p>Runny nose</p>
                  </div>
                  <div class="col-5">
                    <div class="custom-control custom-radio custom-control-inline">
                      <input type="radio" id="runny_noseYes" name="runny_nose" class="custom-control-input" value="Yes" required>
                      <label class="custom-control-label" for="runny_noseYes">Yes</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                      <input type="radio" id="runny_noseNo" name="runny_nose" class="custom-control-input" value="No">
                      <label class="custom-control-label" for="runny_noseNo">No</label>
                    </div>
                  </div>
                </div> <div class="form-row">
                  <div class="col-7">
                    <p>Sore throat</p>
                  </div>
                  <div class="col-5">
                    <div class="custom-control custom-radio custom-control-inline">
                      <input type="radio" id="sore_throatYes" name="sore_throat" class="custom-control-input" value="Yes" required>
                      <label class="custom-control-label" for="sore_throatYes">Yes</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                      <input type="radio" id="sore_throatNo" name="sore_throat" class="custom-control-input" value="No">
                      <label class="custom-control-label" for="sore_throatNo">No</label>
                    </div>
                  </div>
                </div> <div class="form-row">
                  <div class="col-7">
                    <p>Shortness of breath</p>
                  </div>
                  <div class="col-5">
                    <div class="custom-control custom-radio custom-control-inline">
                      <input type="radio" id="shortness_of_breathYes" name="shortness_of_breath" class="custom-control-input" value="Yes" required>
                      <label class="custom-control-label" for="shortness_of_breathYes">Yes</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                      <input type="radio" id="shortness_of_breathNo" name="shortness_of_breath" class="custom-control-input" value="No">
                      <label class="custom-control-label" for="shortness_of_breathNo">No</label>
                    </div>
                  </div>
                </div>
              </div>

              @if(Auth::user()->profile->role == 'Visitor')
              <hr>
              <h2 class="d-flex justify-content-center">Reason for Visit</h2>
              <div class="row mb-3 d-flex justify-content-center">
                <div>
                  <input type="text" id="reason_visit" name="reason_visit" autocomplete="off" required>
                </div>
              </div>
              @endif

            <div class="model-footer d-flex flex-row-reverse">
              <button class="btn btn-primary" type="submit" value="Submit Form">Submit</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>      
            </form>
          </div>
          
        </div>
      </div>
    </div>
  @endif

  @if(session('out'))
    <script type="text/javascript">
      $(document).ready(function() {
        $('#modal-notification').modal();
      });
    </script>
    <div class="modal fade" id="modal-notification" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
      <div class="modal-dialog modal-success modal-dialog-centered modal-" role="document">
        <div class="modal-content bg-gradient-success">
          <div class="modal-header">
            <h6 class="modal-title" id="modal-title-notification">You're Leaving</h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="py-3 text-center">
                <i class="cil-room" style="font-size: 3rem"></i>
                <h4 class="heading mt-4">{{ session('out') }}</h4>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-white" data-dismiss="modal">Ok, Got it</button>
            <button type="button" class="btn btn-link text-white ml-auto" data-dismiss="modal">Close</button>
          </div> 
        </div>
      </div>
    </div>
  @endif

  @if(session('reason'))
    <script type="text/javascript">
      $(document).ready(function() {
        $('#modal-notification').modal();
      });
    </script>
    <div class="modal fade" id="modal-notification" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-" role="document">
        <div class="modal-content">
          <div class="modal-header bg-primary">
            <h6 class="modal-title text-white" id="modal-title-notification">{{ session('reason') }}</h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="py-3 text-center">
                <form action="{{ route('updatereason') }}" >
                  <h2 class="d-flex justify-content-center">Reason for Visit</h2>
                  <div class="row mb-2 d-flex justify-content-center">
                    <div>
                      <input type="text" id="reason_visit" name="reason_visit" autocomplete="off" required>
                    </div>
                  </div>

                  <button class="btn btn-primary" type="submit" value="Submit Form">Submit</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endif

  <div class="row">
    <div class="card w-100">
      <div class="row d-flex justify-content-center pt-3">
      </div>
      <div class="card-body p-0 pb-4">
        <div class="d-flex flex-column justify-content-center align-items-center m-3">
          <div id="qr-reader" style="width:300px"></div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="healthDec" tabindex="-1" role="dialog" aria-labelledby="healthDec" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Health Declaration form</h5>
          <div class="d-flex justify-content-center"><strong class="text-danger">*If you answered ‘yes’ to any of the questions below, you are not allowed to enter the establishment</strong></div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ !empty($establishment->id) ? route('health.store', $establishment->id) : '#' }}" method="POST" id="healthDec">
              @csrf
              <p class="mb-0">You're Entering</p>
              
              <hr>
              <div class="form-group row">
                <label for="temp" class="col-sm-2 col-form-label">Temperature</label>
                <div class="col-sm-10">
                  <input type="number" step="0.01" pattern="\d*" class="form-control" id="temp" name="temp" required>
                </div>
              </div>
              <h3>The following questions must be answered with “yes” or “no”</h3><br>
              <h3>No to all <input id="selectAll" type="checkbox"><label for='selectAll'></h3>
              <div class="form-row">
                <p>1.) Do you (or the person for whom you are completing this form) currently have symptoms of, or have
                  you been diagnosed with, pneumonia or coronavirus disease (COVID-19)?</p>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" id="q1Yes" name="q1" class="custom-control-input" value="Yes" required>
                  <label class="custom-control-label" for="q1Yes">Yes</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" id="q1No" name="q1" class="custom-control-input" value="No">
                  <label class="custom-control-label" for="q1No">No</label>
                </div>
              </div>
              <hr>
              <div class="form-row">
                <p>2.) In the past 10 days, have you (or the person for whom you are completing this form) been in contact with
                  someone who is or could be infected with coronavirus?</p>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" id="q2Yes" name="q2" class="custom-control-input" value="Yes" required>
                  <label class="custom-control-label" for="q2Yes">Yes</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" id="q2No" name="q2" class="custom-control-input" value="No">
                  <label class="custom-control-label" for="q2No">No</label>
                </div>
              </div>
              <hr>
              <div class="form-row d-flex flex-column">
                <p>3.) In the past 24 hours, have you (or the person for whom you are completing this form) had any of the following symptoms:</p>
                <div class="form-row">
                  <div class="col-7">
                    <p>Fever</p>
                  </div>
                  <div class="col-5">
                    <div class="custom-control custom-radio custom-control-inline">
                      <input type="radio" id="feverYes" name="fever" class="custom-control-input" value="Yes" required>
                      <label class="custom-control-label" for="feverYes">Yes</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                      <input type="radio" id="feverNo" name="fever" class="custom-control-input" value="No">
                      <label class="custom-control-label" for="feverNo">No</label>
                    </div>
                  </div>
                </div>
                <div class="form-row">
                  <div class="col-7">
                    <p>Cough</p>
                  </div>
                  <div class="col-5">
                    <div class="custom-control custom-radio custom-control-inline">
                      <input type="radio" id="coughYes" name="cough" class="custom-control-input" value="Yes" required>
                      <label class="custom-control-label" for="coughYes">Yes</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                      <input type="radio" id="coughNo" name="cough" class="custom-control-input" value="No">
                      <label class="custom-control-label" for="coughNo">No</label>
                    </div>
                  </div>
                </div> <div class="form-row">
                  <div class="col-7">
                    <p>Runny nose</p>
                  </div>
                  <div class="col-5">
                    <div class="custom-control custom-radio custom-control-inline">
                      <input type="radio" id="runny_noseYes" name="runny_nose" class="custom-control-input" value="Yes" required>
                      <label class="custom-control-label" for="runny_noseYes">Yes</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                      <input type="radio" id="runny_noseNo" name="runny_nose" class="custom-control-input" value="No">
                      <label class="custom-control-label" for="runny_noseNo">No</label>
                    </div>
                  </div>
                </div> <div class="form-row">
                  <div class="col-7">
                    <p>Sore throat</p>
                  </div>
                  <div class="col-5">
                    <div class="custom-control custom-radio custom-control-inline">
                      <input type="radio" id="sore_throatYes" name="sore_throat" class="custom-control-input" value="Yes" required>
                      <label class="custom-control-label" for="sore_throatYes">Yes</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                      <input type="radio" id="sore_throatNo" name="sore_throat" class="custom-control-input" value="No">
                      <label class="custom-control-label" for="sore_throatNo">No</label>
                    </div>
                  </div>
                </div> <div class="form-row">
                  <div class="col-7">
                    <p>Shortness of breath</p>
                  </div>
                  <div class="col-5">
                    <div class="custom-control custom-radio custom-control-inline">
                      <input type="radio" id="shortness_of_breathYes" name="shortness_of_breath" class="custom-control-input" value="Yes" required>
                      <label class="custom-control-label" for="shortness_of_breathYes">Yes</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                      <input type="radio" id="shortness_of_breathNo" name="shortness_of_breath" class="custom-control-input" value="No">
                      <label class="custom-control-label" for="shortness_of_breathNo">No</label>
                    </div>
                  </div>
                </div>
              </div>

              @if(Auth::user()->profile->role == 'Visitor')
              <hr>
              <h2 class="d-flex justify-content-center">Reason for Visit</h2>
              <div class="row mb-2 d-flex justify-content-center">
                <div>
                  <input type="text" id="reason_visit" name="reason_visit" autocomplete="off" required>
                </div>
              </div>
              @endif 
            <div class="model-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button class="btn btn-primary" type="submit" value="Submit Form">Submit</button>
            </div>      
            </form>
        </div>
      </div>
    </div>
  </div>
  @if(session('danger'))
    <script type="text/javascript">
      $(document).ready(function() {
        $('#modal-notification').modal();
      });
    </script>
    <div class="modal fade" id="modal-notification" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
      <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
        <div class="modal-content bg-gradient-danger">
          <div class="modal-header">
            <h6 class="modal-title" id="modal-title-notification">You're not allowed to enter</h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="py-3 text-center">
              <i class="cil-bell" style="font-size: 3rem"></i>
                <h4 class="heading mt-4">You should read this!</h4>
                <p>{{ session('danger') }}</p>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-white" data-dismiss="modal">Ok, Got it</button>
            <button type="button" class="btn btn-link text-white ml-auto" data-dismiss="modal">Close</button>
          </div> 
        </div>
      </div>
    </div>
  @elseif(session('enter'))
  <script type="text/javascript">
    $(document).ready(function() {
      $('#modal-notification').modal();
    });
  </script>
  <div class="modal fade" id="modal-notification" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
    <div class="modal-dialog modal-success modal-dialog-centered modal-" role="document">
      <div class="modal-content bg-gradient-success">
        <div class="modal-header">
          <h6 class="modal-title" id="modal-title-notification">{{ session('enter') }}</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="py-3 text-center">
              <i class="cil-room" style="font-size: 3rem"></i>
              <h4 class="heading mt-4">Welcome</h4>
              <p>You're allowed to enter</p>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-white" data-dismiss="modal">Ok, Got it</button>
          <button type="button" class="btn btn-link text-white ml-auto" data-dismiss="modal">Close</button>
        </div> 
      </div>
    </div>
  </div>
  @endif
</div>

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
<script>
$("#selectAll").click(function() {
  $("input[type=radio]").prop("checked", $(this).prop("checked"));
});

$("input[type=radio]").click(function() {
  if (!$(this).prop("checked")) {
    $("#selectAll").prop("checked", false);
  }
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
