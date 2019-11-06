@extends('layouts.header_login')

@section('title', 'Acceder')

@section('content')

<div class="fixedContainer">
  <div class="container">
    <div class="row">
      <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
        <div class="card card-signin my-5">
          <div class="card-body">
            <h5 class="card-title text-center">Iniciar Sesion</h5>
            <form method="POST" action="{{ route('login') }}" class="form-signin" method="POST">
              @csrf
              <div class="form-label-group">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Direccion Email" name="email" required autocomplete="off" autofocus>
                <label for="email">Email</label>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>

              <div class="form-label-group">
                <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password"  autocomplete="off" placeholder="Clave" required>
                <label for="clave">Clave</label>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>

              <div class="custom-control custom-checkbox mb-3">
                <input type="checkbox" class="custom-control-input" id="customCheck1">
                <label class="custom-control-label" for="customCheck1">Recordarme</label>
              </div>
              <button type="submit" class="btn btn-lg btn-primary btn-block text-uppercase">
                  {{ __('Acceder') }}
              </button>
              <hr class="my-4">
            </form>
          </div>
          <div class="container-fluid text-right">
            @if (Route::has('password.request'))
                <a class="btn btn-link" href="{{ route('password.request') }}">
                    {{ __('Recuperar Clave') }}
                </a>
            @endif
          </div>
        </div>
      </div>      
    </div>
    
    <!-- Borrar en Produccion -->
    <br>
    <div class="row">
      <div class="col">
        <div class="container bg-light">
          <br>
          <h6 class="text-default"><b>Sector:</b> Informatica</h6>
          <h6 class="text-default"><b>Usuario:</b> informatica@gmail.com</h6>
          <h6 class="text-default"><b>Rol:</b> Usuario normal</h6>
          <hr>
          <h6 class="text-default"><b>Sector:</b> Mantenimiento</h6>
          <h6 class="text-default"><b>Usuario:</b> mantenimiento@gmail.com</h6>
          <h6 class="text-default"><b>Rol:</b> Usuario normal</h6>
          <hr>
          <h6 class="text-default"><b>Sector:</b> Patrimonio</h6>
          <h6 class="text-default"><b>Usuario:</b> patrimonio@gmail.com</h6>
          <h6 class="text-default"><b>Rol:</b> Usuario normal</h6>
          <hr>
          <h6 class="text-default"><b>Sector:</b> Patrimonio</h6>
          <h6 class="text-default"><b>Usuario:</b> estadisticas@gmail.com</h6>
          <h6 class="text-default"><b>Rol:</b> Usuario estadisticas, solo consultas</h6>
          <hr>
          <h6 class="text-default"><b>Sector:</b> -</h6>
          <h6 class="text-default"><b>Usuario:</b> admin@gmail.com</h6>
          <h6 class="text-default"><b>Rol:</b> Usuario administrador general</h6>
          <hr>
          <h6 class="text-default"><b>Clave de acceso:</b> 123456</h6>
          <br><br>
        </div>
      </div>
    </div>
  </div>
  <br>    <!-- Borrar en Produccion -->


</div>

@endsection
