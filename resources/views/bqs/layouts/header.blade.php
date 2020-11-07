<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!-- User Account: style can be found in dropdown.less -->
    <li class="dropdown user user-menu" style="padding-top: 8px;padding-left: 10px">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color:black">
        <img src="{{ Auth::user()->foto!=''  ? url(Auth::user()->foto) : url('lte/dist/img/user2-160x160.jpg')  }}" class="user-image" alt="User Image">
        <span class="hidden-xs" style="color:black">{{ Auth::user()->nama }}</span>
      </a>
      <ul class="dropdown-menu">
        <!-- User image -->
        <li class="user-header">
          <img src="{{ Auth::user()->foto!=''  ? url(Auth::user()->foto) : url('lte/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
          <p>
            {{ Auth::user()->nama}} - {{ strtoupper(Auth::user()->user_level_id)}}
            <small>Bergabung Sejak {{ Auth::user()->created_at!='' && Auth::user()->created_at!= NULL ? date("D M Y",strtotime(Auth::user()->created_at)) : '15 Agustus 2020' }}</small>
          </p>
        </li>
        <!-- Menu Footer-->
        <li class="user-footer">
          <div class="float-left text-sm">
            <a href="{{ URL :: to('bqs_template/users') }}" class="btn btn-default btn-flat">Profile</a>
          </div>
          <div class="float-right text-sm">
            <a href="{{ route('logout') }}" class="btn btn-default btn-flat">{{ __('Logout') }}</a>
            <!-- <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form> -->
          </div>
        </li>
      </ul>
    </li>
  </ul>
</nav>

