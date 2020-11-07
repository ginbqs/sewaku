
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{ URL :: to('bqs_template/dashboard') }}" class="brand-link" style="text-align: center;background-color: white;height: 50px;padding-top: 3px">
    <img src="{{ url('images/logo.png') }}"c lass="brand-image img-circle elevation-3" style="width: 120px">
    <!-- <span class="brand-text font-weight-light">AdminLTE 3</span> -->
  </a>

  <!-- Sidebar -->
  <div class="sidebar">

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->

        <?php $i=0;
        $icon_all = config('app.icon_all');
        ?>
        @foreach(config('app.menu_all') as $menu => $link)
          <li class="nav-item has-treeview" id="{{str_replace(' ','_',strtolower('menu '.$menu))}}">
            @if(is_array($link) && (count($link) > 0))
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-{{$icon_all[$i]}}"></i>
                <p>
                  {{$menu}}
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              @foreach($link as $menuChild => $linkChild)
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ URL :: to($linkChild) }}" class="nav-link"  id="{{str_replace(' ','_',strtolower('menu '.$menu.' '.$menuChild))}}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>{{$menuChild}}</p>
                  </a>
                </li>
              </ul>
              @endforeach
            @else
              @if($menu==='Dashboard')
              <a href="{{ URL :: to($link) }}" class="nav-link active">
              @else
              <a href="{{ URL :: to($link) }}" class="nav-link">
              @endif
                <i class="nav-icon fas fa-{{$icon_all[$i]}}"></i>
                <p>
                  {{$menu}}
                </p>
              </a>
            @endif
          </li> 
        <?php $i++;?>
        @endforeach
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>