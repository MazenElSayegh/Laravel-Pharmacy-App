<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">


  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{asset('plugins/jqvmap/jqvmap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{asset('plugins/daterangepicker/daterangepicker.css')}}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{asset('plugins/summernote/summernote-bs4.min.css')}}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  
</head>
<body class="hold-transition sidebar-mini layout-fixed"  onload="selectAddress()">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{asset('/storage/defaultImages/logo.png')}}" alt="AdminLTELogo" height="140" width="140">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{route('home')}}" class="nav-link">Home</a>
      </li>
      @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                            @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('login') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
    </ul>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

    <!-- Right navbar links -->

    
    <ul class="navbar-nav ml-auto">
      <li class="nav-item"><button class="btn btn-light btn-dark-mode" type="button" data-toggle="toggle" data-onstyle="dark" data-offstyle="light" data-on="Dark Mode" data-off="Light Mode" >Toggle</button></li>
    </ul>

  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('home')}}" class="brand-link">
      <img src="{{asset('/storage/defaultImages/logo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Pharmacy System</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          @role('admin')
          <img src="{{asset('dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
          @else
          @if(auth()->user())
          <img src="{{asset('/storage/' .auth()->user()->typeable->image_path)}}" class="img-circle elevation-2" alt="User Image">
          @endif
          @endrole
        </div>
        <div class="info">
          @if(auth()->user())
          <a href="#" class="d-block">{{auth()->user()->name}}</a>
          @else
          @endif
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Pharmacy System 
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            @if(auth()->user())
            @if(auth()->user()->hasRole('admin'))
              <li class="nav-item">
                <a href="{{route('pharmacies.index')}}" class="nav-link">
                  <img src="{{asset('/storage/defaultImages/pharmacy.png')}}" width="30px" style="margin-right: 5px ">
                  <p>Pharmacies</p>
                </a>
              </li>
              @endif
              @if(auth()->user()->hasRole('pharmacy'))
              <li class="nav-item">
                <a href="{{route('pharmacies.index')}}" class="nav-link">
                  <img src="{{asset('/storage/defaultImages/pharmacy.png')}}" width="30px" style="margin-right: 5px ">
                  <p>My Pharmacy</p>
                </a>
              </li>
              @endif
              @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('pharmacy'))
              <li class="nav-item">
                <a href="{{route('doctors.index')}}" class="nav-link">
                  <img src="{{asset('/storage/defaultImages/doctor.png')}}" width="30px" style="margin-right: 5px">
                  <p>Doctors</p>
                </a>
              </li>
              @if(auth()->user()->hasRole('admin'))
              <li class="nav-item">
                <a href="{{route('clients.index')}}" class="nav-link">
                  <img src="{{asset('/storage/defaultImages/clients.png')}}" width="30px">
                  <p>Clients</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('areas.index')}}" class="nav-link">
                  <img src="{{asset('/storage/defaultImages/area.png')}}" width="30px" style="margin-right: 5px ">
                  <p>Areas</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('addresses.index')}}" class="nav-link">
                  <img src="{{asset('/storage/defaultImages/address.png')}}" width="30px" style="margin-right: 5px ">
                  <p>User Addresses</p>
                </a>
              </li>
              @endif
              <li class="nav-item">
                <a href="{{route('revenues.index')}}" class="nav-link">
                  <img src="{{asset('/storage/defaultImages/revenue.png')}}" width="30px" style="margin-right: 5px ">
                  <p>Revenue</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('medicines.index')}}" class="nav-link">
                  <img src="{{asset('/storage/defaultImages/medicine.png')}}" width="30px" style="margin-right: 5px ">
                  <p>Medicines</p>
                </a>
              </li>
              @endif
              @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('pharmacy') || auth()->user()->hasRole('doctor') && auth()->user()->typeable->is_banned==0)
              <li class="nav-item">
                <a href="{{route('orders.index')}}" class="nav-link">
                  <img src="{{asset('/storage/defaultImages/order.png')}}" width="30px" style="margin-right: 5px ">
                  <p>Orders</p>
                </a>
              </li> 
              @endif
              @endif
            </ul>
          </li>
          
          
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Pharmacy System</h1>
          </div><!-- /.col -->
         
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- main-content -->
    <div class="container px-5">

    @yield('content')

    </div>
     <!-- /.main-content -->
  <!-- /.content-wrapper -->
  

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{asset('plugins/chart.js/Chart.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{asset('plugins/sparklines/sparkline.js')}}"></script>
<!-- JQVMap -->
<script src="{{asset('plugins/jqvmap/jquery.vmap.min.js')}}"></script>
<script src="{{asset('plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{asset('plugins/jquery-knob/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{asset('plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- Summernote -->
<script src="{{asset('plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.js')}}"></script>
<!-- AdminLTE for demo purposes -->
{{-- <script src="{{asset('dist/js/demo.js')}}"></script> --}}
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{asset('dist/js/pages/dashboard.js')}}"></script>
<script
  src="https://code.jquery.com/jquery-3.6.4.min.js"
  integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8="
  crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<!-- <script>
        $(document).ready( function () {
    $('#mytable').DataTable({
        "processing":true,
        "serverSide":true,
        "ajax":"{{route('pharmacies.index')}}"
    });
} );
    </script> -->
    @stack('scripts')
    
  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>$('.jqSelect').select2({
      tags: true,
      placeholder: "Select a medicine name",
    });

    $(".pharmData").on("change",".pharmSelect",{},function (e){
      let medInPharmacies =  JSON.parse($(this).find(":selected").val());
      var medicines=JSON.parse($(this).attr("data-medicine"));
      $('.jqSelect').html("<option>Choose Medicine</option>")

      for(let i=0 ; i<medInPharmacies.length;i++){
        medicines.forEach(val => {
          if(medInPharmacies[i]['medicine_id']==val['id']){
            var option = $('<option/>');
            console.log(JSON.stringify(medInPharmacies[i]));
        option.attr({ 'value':JSON.stringify(medInPharmacies[i]) }).text(String(val['name']));
        $('.jqSelect').append(option);
          }
          });
      }
     
});


    $(".medData").on("change",".jqSelect",{},function(e){
   

   let medprice =  JSON.parse($(this).find(":selected").val()).price;
    let medqty= $(this).parent().next().children(':first-child').next().val();
    let total_price = Number(medqty)*Number(medprice);
    
   $(this).parent().next().next().children(':first-child').next().val(medprice);
   $(this).parent().next().next().next().children(':first-child').next().val(total_price);
   
   });
   $(".medData").on("change",".medQty",{},function(e){
    var medqty =  JSON.parse($(this).val());
    
    let medprice =$(this).parent().next().children(':first-child').next().val();
    
    let total_price = Number(medqty)*Number(medprice);
    $(this).parent().next().next().children(':first-child').next().val(total_price);
    
});


    
    </script>
  
    {{-- <script src="{{ asset('js/order.js')}}"></script> --}}


<!-- Add this script to your custom JavaScript file -->
<script>
  $(document).ready(function() {
    $('.btn-dark-mode').on('click', function() {
      $('body').toggleClass('dark-mode');
    });
  }); 
</script>
</body>
</html>


