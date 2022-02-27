<div class="c-sidebar-brand d-lg-down-none">     
  <div class="c-sidebar-brand-full">
    <h5 class="text-white mt-2 p-2"><img src="{{ asset('img/pinyasafe_logo.png') }}" width="35" height="35" alt="Canossa Logo" class="mr-2">PinyaTrace</h5>
  </div>
  <div class="c-sidebar-brand-minimized" style="background: none">
    <img src="{{ asset('img/pinyasafe_logo.png') }}" width="35" height="35" alt="Canossa Logo">
  </div>
</div>
<ul class="c-sidebar-nav m-0">
    <li class="c-sidebar-nav-item">
      <a class="c-sidebar-nav-link" href="{{ route('tracer') }}">
        <div class="c-sidebar-nav-icon">
          <i class="cil-speedometer"></i>
        </div>
        Dashboard
      </a>
    </li>
    <li class="c-sidebar-nav-item">
      <a class="c-sidebar-nav-link" href="{{ route('cases') }}">
        <div class="c-sidebar-nav-icon">
          <i class="cil-find-in-page"></i>
        </div>
        Cases
      </a>
    </li>
    <li class="c-sidebar-nav-item">
      <a class="c-sidebar-nav-link" href="{{ route('residents') }}">
        <div class="c-sidebar-nav-icon">
          <i class="cil-address-book"></i>
        </div>
        Residents
      </a>
    </li>
    <form action="{{ route('tracer.logout') }}" method="POST" id="logoutForm">@csrf</form>
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