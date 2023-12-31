
<!DOCTYPE html>
<html lang="en">

@include('admin.layouts.head')

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <!-- <img class="animation__shake" src="{{ asset('assets/dist/img/AdminLTELogo.png')}}" alt="AdminLTELogo" height="60" width="60"> --}}-->
     <img class="animation__shake" src="https://d1yjjnpx0p53s8.cloudfront.net/styles/logo-original-577x577/s3/062013/emr_emergency_medical_response_logo.png?itok=FM5CTCE4" alt="AdminLTELogo" height="60" width="60">
   
  </div>
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      
      <li class="nav-item">
        <div class="dropdown">
          <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
            {{ app()->getLocale() == 'vi' ? 'VI' : 'EN' }}
          </button>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="{{ route('lang',['lang' => app()->getLocale() == 'vi' ? 'en' : 'vi']) }}">
              {{ app()->getLocale() == 'vi' ? 'EN' : 'VI' }}
            </a>
          </div>
        </div>
      </li>
     
      <li class="nav-item">
        
        
      </li>

    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  @include('admin.layouts.sidebar')

  <!-- Content Wrapper. Contains page content -->
  @yield('content')
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2023 <a href="#">EMR</a>.</strong>
    All rights reserved.
  </footer>

</div>
<!-- ./wrapper -->

@include('admin.layouts.footer')

</body>
</html>
