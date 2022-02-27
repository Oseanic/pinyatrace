@extends('pages.contact_tracer.layouts.main')

@section('css')
  <!-- Argon CSS -->
  <link rel="stylesheet" href="{{ asset('argon/css/argon.css') }}" type="text/css">
  <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
@endsection
@section('main')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
<div class="containerp-3 mt-3">
    <div class="row justify-content-center p-4" >
        <div class="col-md-6">
            <div class="card w-100">
                <div class="card-body">
                  <div class="row">
                    <div class="col-xl-12 order-xl-1">
                      <p>Your Information</p>
                      <h3>{{ $user->profile->getFullname() }}</h3>
                      <h5>{{ $user->profile->address() }}</h5>
                      <h5>{{ $user->profile->sex.' '.'-'.' '.$user->profile->age }}</h5>
                      <hr>
                    </div>
                    <div class="col-xl-12 order-xl-2">
                        @if (!empty($latest))
                          <p>Recent travel history</p>
                          <h3>{{ $latest->establishment_name }}</h3>
                          <h5>{{ $latest->establishment_address }}</h5>
                          <p style="font-size: .8rem">{{ $latest->updated_at->diffForHumans() }}</p>
                        @else
                          <p>No recent travel history</p>
                        @endif
                    </div>
                  </div>
                </div>
              </div>
        </div>
        <div class="col-md-6">
            <ul class="cbp_tmtimeline">
                @forelse ($history as $location)
                    <li>
                        <time class="cbp_tmtime" datetime="2017-11-03T13:22"><span>{{ Carbon\Carbon::parse($location->out)->format('h:m a') }}</span> <span>{{ $location->updated_at->diffForHumans() }}</span></time>
                        <div class="cbp_tmicon bg-green"><i class="cil-location-pin text-white"></i></div>
                        <div class="cbp_tmlabel">
                            <h2><a href="javascript:void(0);">{{ $location->establishment_name }}</a></h2>
                            <p>{{ $location->establishment_address }}</p> 
                            <h6>
                                <span class="text-success">In: </span>
                                {{ Carbon\Carbon::parse($location->in)->format('h:m a') }}
                                <span class="text-danger ml-2">Out: </span>
                                {{ $location->out === null ? 'Still Inside' : Carbon\Carbon::parse($location->out)->format('h:m a') }}
                            </h6>                           
                        </div>
                    </li>
                @empty
                  <div class="row d-flex justify-content-center">
                    <p>No recent travel history</p>
                  </div>
                @endforelse
            </ul>  
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