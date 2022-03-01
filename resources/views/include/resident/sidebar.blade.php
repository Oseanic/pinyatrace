<div class="c-sidebar-brand d-lg-down-none">     
  <div class="c-sidebar-brand-full">
    <h5 class="text-white mt-2 p-2"><img src="{{ asset('img/Pinyatrace_logo.jpg') }}" width="35" height="35" alt="Canossa Logo" class="mr-2">PinyaTrace</h5>
  </div>
  <div class="c-sidebar-brand-minimized" style="background: none">
    <img src="{{ asset('img/pinyasafe_logo.png') }}" width="35" height="35" alt="Canossa Logo">
  </div>
</div>
<ul class="c-sidebar-nav m-0">
  <li class="c-sidebar-nav-item">
    <a class="c-sidebar-nav-link" href="{{ route('resident') }}">
      <div class="c-sidebar-nav-icon">
        <i class="cil-speedometer"></i>
      </div>
      Dashboard
    </a>
  </li>
  <li class="c-sidebar-nav-item">
    <a class="c-sidebar-nav-link" href="{{ route('scanner') }}">
      <div class="c-sidebar-nav-icon">
        <i class="cil-location-pin"></i>
      </div>
      Recent Visit
    </a>
  </li>
  <li class="c-sidebar-nav-item">
    <a class="c-sidebar-nav-link" href="{{ route('travel') }}">
      <div class="c-sidebar-nav-icon">
        <i class="cil-walk"></i>
      </div>
      Scan History
    </a>
  </li>
  <li class="c-sidebar-nav-item">
    <a class="c-sidebar-nav-link" href="{{ route('profile') }}">
      <div class="c-sidebar-nav-icon">
        <i class="cil-user"></i>
      </div>
      Profile
    </a>
  </li>
  <form action="{{ route('logout') }}" method="POST" id="logoutForm">@csrf</form>
  <li class="c-sidebar-nav-item mt-auto">
    <a class="c-sidebar-nav-link c-sidebar-nav-link-danger text-white" data-toggle="modal" data-target="#feedbackModal" onclick="document.getElementById('logoutForm').submit()">
        <div class="c-sidebar-nav-icon">
            <i class="cil-exit-to-app"></i>
        </div>
      Logout
    </a>
  </li>
</ul>

<button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent" data-class="c-sidebar-minimized"></button>  

</div>