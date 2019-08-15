<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="/">{{\Config::get('constants.content.name')}}</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="/">Inicio</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/shops">Mi Negocio</a>
      </li>
    </ul>
    <ul class="navbar-nav justify-content-end">
      @if(Auth::check())
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <img src="" width="35px"  class="img-profile">
          <b>{{ ucwords(Auth::user()->first_name) }}</b>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
          <a class="dropdown-item text-center">
            @if(!empty(Auth::user()->image) && file_exists( public_path('/images/user/'.Auth::user()->image)))
              <img class="text-center profile-image" src="/images/user/{{Auth::user()->image}}">
            @else
              <img class="text-center profile-image img-circle" width="50px" src="{{url('/images/user/001.png')}}">
            @endif
          </a>
          <a class="dropdown-item text-center"><b>¡Hola, {{ ucwords(Auth::user()->first_name) }}!</b></a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="/account/{{Auth::user()->slug}}">Mi Cuenta</a>
          <a
            class="dropdown-item"
            href="{{ route('logout') }}"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
          >
            Salir
          </a>
            <!--Formulario Logout-->
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
        </div>
      </li>
      @else
      <li class="nav-item">
        <a class="nav-link" href="{{ route('login') }}">Acceder</a>
      </li>
      @endif
    </ul>
  </div>
</nav>
