<div class="container-fluid top-bar">
  <div class="row">
    <div class="col-lg-6 col-md-6 col-sm-4">
      <a class="navbar-brand title-topbar" href="/">{{\Config::get('constants.content.name')}}</a>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-8 text-right">
        <ul class="navbar-nav">
          @if(Auth::check())
          <li class="nav-item">
            <a class="text-center text-muted user-nav">{{ ucwords(Auth::user()->last_name) ." ". ucwords(Auth::user()->first_name) }}</a>
          </li>
          <li class="nav-item">
            <a class="text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> Salir </a>
            <!--Formulario Logout-->
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
          </li>
          @else
          <li class="nav-item">
            <a class="nav-link" href="{{ route('login') }}">Acceder</a>
          </li>
          @endif
        </ul>
    </div>

  </div>
</div>

<style type="text/css">

.top-bar{
  background: #F8F9FA;
  padding-top:5px;
  padding-bottom:5px;
  margin-bottom: 15px;
}

.navbar-nav {
  display: inline-block;
}

.navbar-nav>li {
   display: inline-block;
}
.title-topbar{
  margin-top: 5px;
}
</style>
