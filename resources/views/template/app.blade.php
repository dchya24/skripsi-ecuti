<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>@yield('title')</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker3.min.css">
  <link rel="stylesheet" href="{{asset('css/template.css')}}">
  <link rel="icon" type="image/x-icon" href="{{asset('img/logo-dlh-small.png')}}">

</head>
<body class="page-wrapper chiller-theme toggled">

  @include('template.sidebars')
  <nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <span class="navbar-brand mb-0 mx-md-auto  pl-sm-3 font-weight-bold">DLH DKI Jakarta</span>
    <ul class="navbar-nav pr-5">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
          <i class="far fa-user-circle fa-lg"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right">
          <div class="dropdown-item">
            Hello, Ria Lantasih
          </div>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">
            <i class="fas fa-sign-out-alt"></i>
            Logout
          </a>
      </li>
    </ul>
  </nav>

  <main class="page-content">
    <div class="contaier">
        @yield('content')
    </div>
  </main>
    

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  {{-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
  <script src="{{asset('js/template.js')}}"></script>
</body>
</html>