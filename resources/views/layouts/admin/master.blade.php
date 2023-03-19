<!DOCTYPE html>
<html lang="en">
   <head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <title>Pluto - Responsive Bootstrap Admin Panel Templates</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- site icon -->
      <link rel="icon" href="{{ asset('template/admin-template/images/fevicon.png') }}" type="image/png" />
      <!-- bootstrap css -->
      <link rel="stylesheet" href="{{ asset('template/admin-template/css/bootstrap.min.css') }}" />
      <!-- site css -->
      <link rel="stylesheet" href="{{ asset('template/admin-template/style.css') }}" />
      <!-- responsive css -->
      <link rel="stylesheet" href="{{ asset('template/admin-template/css/responsive.css') }}" />
      <!-- color css -->
      <link rel="stylesheet" href="{{ asset('template/admin-template/css/colors.css') }}" />
      <!-- select bootstrap -->
      <link rel="stylesheet" href="{{ asset('template/admin-template/css/bootstrap-select.css') }}" />
      <!-- scrollbar css -->
      <link rel="stylesheet" href="{{ asset('template/admin-template/css/perfect-scrollbar.css') }}" />
      <!-- custom css -->
      <link rel="stylesheet" href="{{ asset('template/admin-template/css/custom.css') }}" />
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
   </head>
   <body class="dashboard dashboard_1">
        <div class="full_container">
            <div class="inner_container">
            <!-- Sidebar  -->
            @include('layouts.admin.components._admin_sidebar')
                <!-- end sidebar -->
                <!-- right content -->
                
                <div id="content">
                    <!-- topbar -->
                    @include('layouts.admin.components._admin_topbar')
                    <!-- end topbar -->
                    <!-- dashboard inner -->
                    @yield('content')
                    <!-- end dashboard inner -->
                </div> 
            </div>
        </div>
      <!-- jQuery -->
      <script src="{{ asset('template/admin-template/js/jquery.min.js') }}"></script>
      <script src="{{ asset('template/admin-template/js/popper.min.js') }}"></script>
      <script src="{{ asset('template/admin-template/js/bootstrap.min.js') }}"></script>
      <!-- wow animation -->
      <script src="{{ asset('template/admin-template/js/animate.js') }}"></script>
      <!-- select country -->
      <script src="{{ asset('template/admin-template/js/bootstrap-select.js') }}"></script>
      <!-- owl carousel -->
      <script src="{{ asset('template/admin-template/js/owl.carousel.js') }}"></script> 
      <!-- chart js -->
      <script src="{{ asset('template/admin-template/js/Chart.min.js') }}"></script>
      <script src="{{ asset('template/admin-template/js/Chart.bundle.min.js') }}"></script>
      <script src="{{ asset('template/admin-template/js/utils.js') }}"></script>
      <script src="{{ asset('template/admin-template/js/analyser.js') }}"></script>
      <!-- nice scrollbar -->
      <script src="{{ asset('template/admin-template/js/perfect-scrollbar.min.js') }}"></script>
      <script>
         var ps = new PerfectScrollbar('#sidebar');
      </script>
      <!-- custom js -->
      <script src="{{ asset('template/admin-template/js/custom.js') }}"></script>
      <script src="{{ asset('template/admin-template/js/chart_custom_style1.js') }}"></script>
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.4/dist/sweetalert2.all.min.js"></script>
      <script>
          
          $(document).ready(function () {  
              const Toast = Swal.mixin({
                  toast: true,
                  position: 'top-end',
                  showConfirmButton: false,
                  timer: 5000,
                  timerProgressBar: true,
                  didOpen: (toast) => {
                      toast.addEventListener('mouseenter', Swal.stopTimer)
                      toast.addEventListener('mouseleave', Swal.resumeTimer)
                  }
              })
              @if(session()->has('success'))
                  Toast.fire({
                      icon: 'success',
                      title: '{{ session()->get("success") }}'
                  })
              @endif
              @if(count($errors) > 0)
                  @foreach($errors->all() as $error)
                      Toast.fire({
                          icon: 'error',
                          title: '{{ $error }}'
                      })
                  @endforeach
              @endif
              @if(session()->has('error'))
                  Toast.fire({
                      icon: 'error',
                      title: '{{ session()->get("error") }}'
                  })
              @endif
              
            $('#sidebarCollapse').on('click', function() {
                $('#sidebar').toggleClass('active');
            })
          });
          
          $(document).scroll(function () {
              var $nav = $(".fixed-top");
              $nav.toggleClass('scrolled', $(this).scrollTop() > $nav.height());
              $("li.nav-item>a.active").addClass('active-color');
          });
          $('.navbar-toggler').on('click', function() {
              let button = $(".navbar-toggler");
              let nav = $(".navbar");
              button.hasClass('collapsed') == false ? nav.addClass('scrolled') : nav.removeClass('scrolled')
              // $nav.contains('rounded') ? $nav.addClass('scrolled') : $nav.removeClass('scrolled');
          });
      </script>
      @stack('scripts')
   </body>
</html>