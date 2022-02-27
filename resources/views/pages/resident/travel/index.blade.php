@extends('pages.resident.layouts.main')

@section('main')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
<div class="containerp-3 mt-3">
    <div class="row justify-content-center p-4" >
        <div class="col-md-6">
            <ul class="cbp_tmtimeline">
                @forelse ($history as $location)
                    <li>
                        <time class="cbp_tmtime" datetime="2017-11-03T13:22"><span class="{{ $location->in === 'Not allowed' ? 'text-danger' : 'text-black'}}">{{ $location->in }}</span> <span>{{ $location->updated_at->diffForHumans() }}</span></time>
                        <div class="cbp_tmicon bg-green"><i class="cil-location-pin text-white"></i></div>
                        <div class="cbp_tmlabel">
                            <h2><strong>{{ $location->establishment_name }}</strong></h2>
                            <p>{{ $location->establishment_address }}</p> 
                            <h6>
                                <div class="row">
                                <span class="ml-3 mr-1 text-primary">Time: </span>
                                <p class="{{ $location->in === 'Not allowed' ? 'text-danger' : 'text-black'}}">{{ $location->in }}</p>

                                <span class="text-primary ml-5 mr-1">Date: </span>
                                <p class="text-black">{{ Carbon\Carbon::parse($location->date)->format('F, d Y') }}</p>
                                </div>        
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
