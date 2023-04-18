<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Web - @yield('title')</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="{{ asset('template/landing/assets/favicon.ico') }}" />
        <!-- Font Awesome icons (free version)-->
        {{-- <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="{{ asset('template/landing/css/styles.css') }}" rel="stylesheet" /> --}}
    </head>
    <body id="page-top">
        @include('layouts.landing.navbar')
        @yield('content')
        <!-- Footer-->
        @include('layouts.landing.footer')
        <!-- Portfolio Modals-->
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="{{ asset('template/landing/js/scripts.js') }}"></script>
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <!-- * *                               SB Forms JS                               * *-->
        <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.4/dist/sweetalert2.all.min.js"></script>
        {{-- <script src="{{ asset('template/admin-template/plugins/jquery/jquery.min.js') }}"></script> --}}
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

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
