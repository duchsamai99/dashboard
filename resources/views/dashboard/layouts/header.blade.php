<div class="c-wrapper">
  <header class="c-header c-header-light c-header-fixed c-header-with-subheader ">
  <div class="c-subheader" style="background: rgb(47, 147, 186)">
    <!-- <button class="c-header-toggler c-class-toggler d-lg-none mr-auto" type="button" data-target="#sidebar" data-class="c-sidebar-show"><span class="c-header-toggler-icon"></span></button><a class="c-header-brand d-sm-none" href="#"><img class="c-header-brand" src="{{ url('/assets/brand/coreui-base.svg" width="97" height="46" alt="CoreUI Logo"></a> -->
    <button class="c-header-toggler c-class-toggler ml-3 d-md-down-none" type="button" data-target="#sidebar" data-class="c-sidebar-lg-show" responsive="true"><span class="c-header-toggler-icon c-header-red"></span></button>
    <?php
      use App\MenuBuilder\FreelyPositionedMenus;
      if(isset($appMenus['top menu'])){
        FreelyPositionedMenus::render( $appMenus['top menu'] , 'c-header-', 'd-md-down-none');
      }
    ?>  
    <ul class="c-header-nav ml-auto  mr-4">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span class="flag-icon flag-icon-{{Config::get('languages')[App::getLocale()]['flag-icon']}}"></span> {{ Config::get('languages')[App::getLocale()]['display'] }}
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          @foreach (Config::get('languages') as $lang => $language)
            @if ($lang != App::getLocale())
              <a class="dropdown-item" href="{{ route('lang.switch', $lang) }}"><span class="flag-icon flag-icon-{{$language['flag-icon']}}"></span> {{$language['display']}}</a>
            @endif
          @endforeach
        </div>
      </li>

      <li class="c-header-nav-item dropdown"><a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
        <img class="c-avatar-img" src="{{ url('/uploads/users/'.Auth::user()->image) }}" style="width: 50px;height: 50px; padding: 5px; margin: 0px; " alt="profile"> 
        <p class="text-white" style="margin-top: auto; margin-bottom: 1rem">{{Auth::user()->name}}</p>
          <div class="dropdown-menu dropdown-menu-right pt-0">
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ url('/users/'.Auth::user()->id.'/edit?current_menu_name=Users') }}">
              <!-- <svg class="c-icon mr-2">
                <use xlink:href="{{ url('/icons/sprites/free.svg#cil-user') }}"></use>
              </svg> -->
              <!-- <a class="c-sidebar-nav-link" href="{{ url('/users/'.Auth::user()->id.'/edit?current_menu_name=Users') }}"> -->
                <button type="submit" class="btn btn-ghost-dark btn-block">Change Profile</button>
              <!-- </a> -->
              <!-- <form action="{{ url('/users/'.Auth::user()->id.'/edit?current_menu_name=Users') }}" method="POST"> 
                @csrf <button type="submit" class="btn btn-ghost-dark btn-block">Change Profile</button>
              </form> -->
            </a>

            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">
              <!-- <svg class="c-icon mr-2">
                <use xlink:href="{{ url('/icons/sprites/free.svg#cil-account-logout') }}"></use>
              </svg> -->
              <form action="{{ url('/logout') }}" method="POST"> 
                @csrf 
                <button type="submit" class="btn btn-ghost-dark btn-block">Logout</button>
              </form>
            </a>
          </div>

      </li>
    </ul>
    </div>
    <div class="c-subheader px-3">
      <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <?php $segments = ''; ?>
        @for($i = 1; $i <= count(Request::segments()); $i++)
          <?php $segments .= '/'. Request::segment($i); ?>
          @if($i < count(Request::segments()))
              <li class="breadcrumb-item">{{ Request::segment($i) }}</li>
          @else
              <li class="breadcrumb-item active">{{ Request::segment($i) }}</li>
          @endif
        @endfor
      </ol>
    </div>
  </header>