@extends('layouts.app')

@section('app')
    

<div class="c-sidebar c-sidebar-light c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
  
    @include('include.resident.sidebar')
    @include('include.resident.topbar')
    
    <div class="c-body">
  
      <main class="c-main pt-0">
  
        @yield('main') 
  
      </main>
  
    </div>
  
</div>


@endsection