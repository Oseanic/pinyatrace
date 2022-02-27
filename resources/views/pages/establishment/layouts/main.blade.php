@extends('layouts.app')

@section('app')
    
{{-- <main class="c-app bg-white"> --}}

    <div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show " id="sidebar">
 
       @include('include.establishment.sidebar')
       @include('include.establishment.topbar')
       
       <div class="c-body">
     
         <main class="c-main pt-0">
     
           @yield('main') 
     
         </main>
     
       </div>
     
     </div>
 
 {{-- </main> --}}

@endsection